<?php
namespace App\Repositories;
use App\Events\AccessRemoved;
use App\Events\AccessStored;
use App\Model\Access as AccessModel;
use App\Model\User;
use App\Model\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use DB;

class Auth implements Repository
{
	public function store($user,$notify)
	{

		$user->login_times=$user->login_times+1;
		
		if($user->is_first===0){
			$user->is_first=1;
		}elseif($user->is_first===1){
			$user->is_first=2;
		}
		
		$user->save();
	}
	
	public function remove($id,$notify)	{}
	
	
	public function login($data,$request){
		
		if(!$account = Account::where("name",$data["name"])->first()){
            throw ValidationException::withMessages(["name" => "帐号密码不正确"]);
		}
		if(!Hash::check($data["password"], $account->password)){
            throw ValidationException::withMessages(["name" => "帐号密码不正确"]);
		}
		
		$user=$account->user;
		
		if(isset($data["openid"])){
			
			$wechat_account=Account::where("user_id",$account->user_id)->where("type",2)->first();
			
			if($wechat_account){
				if($wechat_account->name!=$data["openid"]){
					throw ValidationException::withMessages(["name" => "你必须使用之前的微信才能登录"]);
				}
			}
			//如果该帐号没有绑定openid 并且该openid没有绑定其他帐号则可以绑定
			if(!$wechat_account&&!Account::where("name",$data["openid"])->where("password",$data["app_id"])->where("type",2)->first()){
				Account::create(['name'=>$data['openid'],'password'=>$data['app_id'],'type'=>2,'user_id'=>$account->user_id]);
				$user->openid=$data['openid'];
			}
		}
			
		$token = auth("api")->login($account);

		$notify["login"]="password";
		
		$user->last_ip=$request->ip();

		$user->last_at=date('Y-m-d H:i:s', time());
		
		$this->store($user,$notify);
		
		return $token;
		
	}
		
	public function phone($data,$request){
		
		if(!$account = Account::where("name",$data["phone"])->where("type",1)->first()){
            throw ValidationException::withMessages(["code" => "手机号没有注册"]);
		}
		
		$user=$account->user;
		
		if(isset($data["openid"])){
			
			$wechat_account=Account::where("user_id",$account->user_id)->where("type",2)->first();
			
			if($wechat_account){
				if($wechat_account->name!=$data["openid"]){
					throw ValidationException::withMessages(["name" => "你必须使用之前的微信才能登录"]);
				}
			}
			//如果该帐号没有绑定openid 并且该openid没有绑定其他帐号则可以绑定
			if(!$wechat_account&&!Account::where("name",$data["openid"])->where("password",$data["app_id"])->where("type",2)->first()){
				Account::create(['name'=>$data['openid'],'password'=>$data['app_id'],'type'=>2,'user_id'=>$account->user_id]);
				$user->openid=$data['openid'];
			}
		}
		
		$token = auth("api")->login($account);
		
		$notify["login"]="phone";
		
		$user=$account->user;
		
		$user->last_ip=$request->ip();

		$user->last_at=date('Y-m-d H:i:s', time());
		
		$this->store($user,$notify);
		
		return $token;
		
	}
	
	public function program($data,$request){
		
		if(!$account = Account::where("name",$data["name"])->where("password",$data["password"])->where("type",2)->first()){
            throw ValidationException::withMessages(["wechat_code" => "你没有绑定",]);
		}
		
		$token = auth("api")->login($account);
		
		$notify["login"]="program";
		
		$user=$account->user;
		
		$user->last_ip=$request->ip();

		$user->last_at=date('Y-m-d H:i:s', time());
		
		$this->store($user,$notify);
		
		return $token;
		
	}
	
	//注册
	public function register($data,$notify=[]){

		if($account=Account::where('name',$data['phone'])->first()){
            throw ValidationException::withMessages(["phone" => "手机号已存在"]);
		}
		
		if(isset($data['openid'])&&Account::where("name",$data["openid"])->where("password",$data["app_id"])->where("type",2)->first()){
			throw ValidationException::withMessages(["phone" => "小程序已注册，请换个微信注册"]);	
		}
		
		DB::transaction(function () use ($data){
			$user =User::create([
				'phone'=>$data['phone'],
				'nickname'=>isset($data['nickname'])?$data['nickname']:'',
				'code'=>isset($data['invite_code'])?$data['invite_code']:'',
				'openid'=>isset($data['openid'])?$data['openid']:'',
			]);
			Account::create(['name'=>$data['phone'],'type'=>1,'user_id'=>$user->id,'password'=>Hash::make($data["password"])]);
			
			if(isset($data['openid'])){
				Account::create(['name'=>$data['openid'],'password'=>$data['app_id'],'type'=>2,'user_id'=>$user->id]);
			}
		});
		
		return true;
		
	}
	
	//修改密码
	public function change($data,$notify=[]){
		
		DB::transaction(function () use ($data){
			if($user_id=Account::where('name',$data['phone'])->first()){
				$user_id->password=Hash::make($data["password"]);
				$user_id->save();
			}
		});
		
		return true;
		
	}
}
