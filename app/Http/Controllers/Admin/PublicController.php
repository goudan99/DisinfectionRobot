<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Config;
use App\Repositories\UnReposity;
use App\Repositories\Mobile;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PublicController extends Controller
{
    public function __construct(UnReposity $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * 发送手机验证码,发送成功
     *
     * @return \Illuminate\Http\Response
     */
    public function code(Request $request)
    {

		$mobile=new Mobile();
		
		$type=$request->get("type");

		$phone=$request->get("phone");

		if(Mobile::CHANGEPHONE==$type&&!$this->user){
			return $this->error("没有登录");
		}
		
		if(Mobile::CHANGEPHONE==$type&&$this->user&&$this->user){
			$phone = $this->user->phone;
		}
		if($type==2){
			
			if(!$user = Auth::user("api")){
				return $this->error('需要登录',[], 401);
			}
			
			$phone=$user->user->phone;
		}
		Validator::make(['phone'=>$phone,'type'=>$type], [
          'phone' => 'required|size:11',
          'type' => 'required',
		],[
			"phone.required"=>"手机必填",
			"phone.size"=>"手机必须11位",
			"type.required"=>"类型必填"
		])->validate();
		
		$code= $mobile->code($phone, '', $type);
		
		phonecode($phone,$type, $code);
		
		if(config("app")["env"]=="testing"){
			return $this->success($code,"验证码发送成功，请注意查收");
		}
		if(config("app")["env"]=="local"){
			return $this->success([],"验证码发送成功，请注意查收".$code);
		}else{
			return $this->success([],"验证码发送成功，请注意查收");
		}
    }
	
    /**
     * 显示配置
     *
     * @return \Illuminate\Http\Response
     */
    public function config(Request $request)
    {
		return $this->success(Config::make(true),"获取成功");
	}
}
