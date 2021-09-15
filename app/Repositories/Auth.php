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
		
		$user=Account::where('phone',$data['phone'])->first();
		
		$user->password=Hash::make($data["password"]);
		
		$user->save();
		
		return true;
		
	}
	
	//发送验证码
	public function register($data,$notify=[]){

		if($account=Account::where('name',$data['phone'])->first()){
			return false;
		}
		
		DB::transaction(function () use ($data){
			$user =User::create(['phone'=>$data['phone']]);
			Account::create(['name'=>$data['phone'],'type'=>1,'user_id'=>$user->id]);
		});
		
		return true;
		
	}
}
