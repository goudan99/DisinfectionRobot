<?php
namespace App\Repositories;
use App\Events\AccessRemoved;
use App\Events\AccessStored;
use App\Model\Access as AccessModel;
use App\Exceptions\ValidationException;
use App\Model\User;
use App\Model\Account;
use Illuminate\Support\Facades\Hash;
use DB;

class Auth implements Repository
{
	public function store($data,$notify){}
	
	public function remove($id,$notify)	{}
	
	//发送验证码
	public function change($data,$notify=[]){
		
		DB::transaction(function () use ($data){
			if($user=Account::where('name',$data['phone'])->first()){
				$user->password=Hash::make($data["password"]);
				$user->save();
			}
			if($user&&$account=Account::where('user_id',$user->user_id)->where('type',0)->first()){
				$account->password=Hash::make($data["password"]);
				$account->save();
			}else{
				return false;
			}
		});
		
		return true;
		
	}
	
	//发送验证码
	public function register($data,$notify=[]){

		if($account=Account::where('name',$data['phone'])->first()){
            throw ValidationException::withMessages([
              "phone" => "手机号已存在"
            ]);
		}
		
		DB::transaction(function () use ($data){
			$user =User::create([
				'phone'=>$data['phone'],
				'nickname'=>isset($data['nickname'])?$data['nickname']:'',
				'code'=>isset($data['invite_code'])?$data['invite_code']:'',
				'openid'=>isset($data['openid'])?$data['openid']:'',
			]);
			Account::create(['name'=>$data['phone'],'type'=>1,'user_id'=>$user->id,'password'=>Hash::make($data["password"])]);
		});
		
		return true;
		
	}
}
