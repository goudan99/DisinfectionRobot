<?php

namespace App\Http\Controllers\Admin;

use App\Constant\Code;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Repositories\Mobile;
use App\Repositories\Auth;
use App\Model\Account;
use App\Http\Requests\LoginPasswordRequest;
use App\Http\Requests\LoginPhoneRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\PasswordRequest;
use EasyWeChat\Factory;
use Hash;

class AuthController extends Controller
{
	
    public function __construct(Auth $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * 用户手机号密码登录
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginPasswordRequest $request)
    { 
        $data = request(['username', 'password']);

		$config = config("robot")["miniProgram"];
		
		$data = ["name"=>$request->username, 'password'=>$request->password,"app_id"=>$config["app_id"]];
		
		if(isset($data["wechat_code"])&&$openid=openid($data["wechat_code"])){$data['openid']=$openid;}

		$token =$this->getRepositories()->login($data,$request);
		
        $data = [
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
		];
		  
        return $this->success($data);
    }
	
	/**
	 *  手机验证码登录
	**/
    public function phone(LoginPhoneRequest $request)
    { 
		$config = config("robot")["miniProgram"];
		
		$data["phone"]=$phone = request('phone');
		
		$code = request("phone_code")?request("phone_code"):request("code");
				
		if(isset($data["wechat_code"])&&$openid=openid($data["wechat_code"])){$data['openid']=$openid;}
		
		if($code!=phonecode($data["phone"],Mobile::LOGIN)){ throw ValidationException::withMessages(["phone_code" => "验证码不正确"]);}
		
		$token = $this->getRepositories()->phone($data,$request);
		
		phonecode($data["phone"],Mobile::LOGIN,'');//修改完以后清掉这个session值
		
        $data = [
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
		];
		  
        return $this->success($data);
    }
	
    public function program(Request $request)
    { 
		$code = request("wechat_code")?request("wechat_code"):request("code");
		
		$config = config("robot")["miniProgram"];
		
		$app = Factory::miniProgram($config);
		
		$openid = "ofeYf1JTKjv6eutx_2lM8McRq3sw";
		
		$wedata = [];
		
        if(config("app")["env"]=="testing"&&$code!="111"){
			return $this->error("wechat_code无效，重新获取",["code"=>"无效的wechat_code无效码"],Code::VALIDATE);
	    }
		
		if(!(config("app")["env"]=="local"||config("app")["env"]=="testing")){
			$wedata = $app->auth->session($code);
			if(isset($wedata["errcode"])){
				return $this->error("wechat_code无效无效，重新获取",[["code"=>$wedata["errmsg"]]],Code::VALIDATE);
			}
			$openid = $wedata["openid"];
		}

		$token = $this->getRepositories()->program(['name'=>$config["app_id"],'password'=>$openid],$request);
		
        $data = [
          'access_token' => $token,
          'token_type' => 'bearer',
		  'session_key' => isset($wedata["session_key"])?$wedata["session_key"]:'',
          'expires_in' => auth()->factory()->getTTL() * 60
		];
		  
        return $this->success($data);
		
    }

	
	/**
	 * 用户注册
	**/
    public function register(RegisterRequest $request)
    {
		$config = config("robot")["miniProgram"];
		
		$data = $request->all();
		
		$data['openid']='123';
		
		$data['app_id']=$config["app_id"];
		
		if(isset($data["wechat_code"])&&$openid=openid($data["wechat_code"])){$data['openid']=$openid;}
		
		/*验证验证码*/
		if($data["phone_code"]!=phonecode($data["phone"],Mobile::REGISTER)){
            throw ValidationException::withMessages(["phone_code" => "验证码不正确"]);
		}

		/*验证邀请码*/
		//if(!checkInvite($data["invite_code"])){throw ValidationException::withMessages(["invite_code" => "邀请码不正确"]);}

	    $this->getRepositories()->register($data,['form'=>['user'=>'']]);

		phonecode($data["phone"],Mobile::REGISTER,'');

		return $this->success([],"注册成功");
	}

    public function logout(Request $req)
    { 
        return $this->success([],"成功退出");
	}
	
	
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function password(PasswordRequest $request)
    { 
		$data =$request->all();
		
		if($data["code"]!=phonecode($data["phone"],Mobile::FIND)){
            throw ValidationException::withMessages([
              "code" => "验证码不正确",
            ]);
		}
		
		$this->getRepositories()->change($data);
		
		phonecode($data["phone"],Mobile::FIND,'');//修改完以后清掉这个session值
		
        return $this->success([],"密码重置成功");
    }
}
