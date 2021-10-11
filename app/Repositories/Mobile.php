<?php
namespace App\Repositories;
use App\Events\AccessRemoved;
use App\Events\AccessStored;
use App\Model\Access as AccessModel;
use App\Exceptions\ValidationException;

class Mobile
{
    public const REGISTER = 0; 	 //用户注册
    public const FIND = 1;      	 //找密码
    public const LOGIN = 5;      	 //登录
    public const CHANGE = 2;    	 //更改密码
    public const CHANGEPHONE = 3;  	 //更改手机身份认证
    public const VALIDATEPHONE = 4;  //更改手机确认新手机
	
	//发送验证码
	public function code($phone,$code="",$type=0)
	{
		return rand();
	}
	
}
