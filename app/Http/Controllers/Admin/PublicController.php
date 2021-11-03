<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Config;
use App\Repositories\UnReposity;
use App\Repositories\Mobile;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Model\Account;

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
		
		$data = $request->all();
		
		$type=isset($data["type"])?$data["type"]:0;

		$phone=isset($data["phone"])?$data["phone"]:'';

		if(Mobile::VALIDATEPHONE==$type||Mobile::CHANGEPHONE==$type||Mobile::CHANGE==$type){//修改密码以及修改手机号时需要用户已经登录
			if(!$this->user){
				return $this->error("没有登录",[],401);
			}
			if(Mobile::CHANGEPHONE==$type||Mobile::CHANGE==$type){
				$phone = $this->user->phone;//修改手机号时,旧手机就是自己现在绑定的手机号，更密码时的手机号就是现在用着的手机号
			}
		}
		
		Validator::make(['phone'=>$phone,'type'=>$type], [
          'phone' => 'required|size:11',
          'type' => 'required',
		],[
			"phone.required"=>"手机必填",
			"phone.size"=>"手机必须11位",
			"type.required"=>"类型必填"
		])->validate();
		
		if(Mobile::REGISTER==$type&&Account::where('name',$phone)->first()){
			return $this->error('验证不通过',["phone"=>"该手机号已注册"], 422);
		}
		
		if(Mobile::FIND==$type&&!Account::where('name',$phone)->first()){
			return $this->error('验证不通过',["phone"=>"该手机号未注册"], 422);
		}
		if(Mobile::LOGIN==$type&&!Account::where('name',$phone)->first()){
			return $this->error('验证不通过',["phone"=>"该手机号未注册"], 422);
		}
		
		if(Mobile::VALIDATEPHONE==$type&&Account::where('name',$phone)->first()){
			return $this->error('验证不通过',["phone"=>"该手机号已注册"], 422);
		}
		
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
