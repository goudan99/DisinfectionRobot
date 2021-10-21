<?php
namespace App\Repositories;
use App\Events\AccessRemoved;
use App\Events\AccessStored;
use App\Model\Access as AccessModel;
use App\Exceptions\AttachException;
use Illuminate\Support\Facades\Cache;

class Mobile
{
    public const REGISTER 		= 0; 	//用户注册
    public const FIND 			= 1;   	//找密码
    public const CHANGE 		= 2;   	//更改密码
    public const CHANGEPHONE	= 3;  	//更改手机身份认证
    public const VALIDATEPHONE 	= 4;	//更改手机确认新手机
    public const LOGIN 			= 5; 	//登录

	
	//发送验证码
	public function code($phone,$code="",$type=0)
	{
		$code =  $code?$code:(int)rand(111111, 999999);
		
		//if(!(config("app")["env"]=="local"||config("app")["env"]=="testing")){
			$prefix="mobile_code_limt";
			$count=Cache::get($prefix.$phone.date("Y.m.d"));
			if($count<15){
			  sendSms($phone,$this->tempid($type),$code);
			  Cache::put($prefix.$phone.date("Y.m.d"),$count+1);
			  return $code;
			}else{
			  throw new AttachException("手机号码发送次数超过限制",[],422);
			}

		//}
		
	}
	
	private function tempid($type){
		$arr=[
			0=>1157956,
			1=>1157959,
			2=>1157962,
			3=>1157968,
			4=>1157973,
			5=>1157975,
		]; 
		return $arr[$type];
	}
}
