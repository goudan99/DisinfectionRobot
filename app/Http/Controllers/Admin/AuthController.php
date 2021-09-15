<?php

namespace App\Http\Controllers\Admin;

use App\Constant\Code;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Mobile;
use App\Repositories\Auth;
use App\Model\Account;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\LoginPhoneRequest;
use App\Http\Requests\RegisterRequest;
use EasyWeChat\Factory;

class AuthController extends Controller
{
	
    public function __construct(Auth $repo)
    {
        parent::__construct($repo);	
    }
	
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $req)
    { 
        $credentials = request(['username', 'password']);
		
		 $credentials = ["name"=>$req->username, 'password'=>$req->password];
		 
        if (! $token = auth()->attempt($credentials)) {
            return $this->error("帐号或密码错误");
        }

        $data = [
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
		];
		  
        return $this->success($data);
    }

    public function program(Request $request)
    { 
		$code = request("code");
		
		$config = config("shop")["miniProgram"];
		
		$app = Factory::miniProgram($config);
		
		$openid = "ofeYf1JTKjv6eutx_2lM8McRq3sw";
		
		$wedata = [];
		
		if(config("app")["env"]!="local"){
			
			$wedata = $app->auth->session($code);
			
			if(isset($wedata["errcode"])){
				
				return $this->error("code无效，重新获取",[["code"=>$wedata["errmsg"]]],Code::VALIDATE);
				
			}
			
			$openid = $wedata["openid"];
		}

		if(!$user = Account::where("name",$config["app_id"])->where("password",$openid)->where("type",2)->first()){
			return $this->error("没有关联帐号，需要关键帐号");
		}
		
		$token = auth()->login($user);
		
        $data = [
          'access_token' => $token,
          'token_type' => 'bearer',
		  'session_key' => isset($wedata["session_key"])?$wedata["session_key"]:'',
          'expires_in' => auth()->factory()->getTTL() * 60
		];
		  
        return $this->success($data);
		
    }
	/*
	  手机验证码登录
	*/
    public function phone(LoginPhoneRequest $request)
    { 
		$data = $request->all();
		
		if($data["code"]!=$request->session()->get('mobile_code_'.$data["phone"].'_'.Mobile::LOGIN)){
		  return $this->error("验证码不正确");
		}
		
		if(!$user = Account::where("name",$data["phone"])->where("type",1)->first()){
			return $this->error("验证码错误");
		}
		
		$token = auth()->login($user);
		
		$request->session()->put('mobile_code_'.$data["phone"].'_'.Mobile::LOGIN,'');//修改完以后清掉这个session值
		
        $data = [
          'access_token' => $token,
          'token_type' => 'bearer',
		  'session_key' => isset($wedata["session_key"])?$wedata["session_key"]:'',
          'expires_in' => auth()->factory()->getTTL() * 60
		];
		  
        return $this->success($data);
    }
	
    public function register(RegisterRequest $request)
    {
		$data = $request->all();
		
	    if(!$this->getRepositories()->register($request->all(),['form'=>['user'=>'']])){
			 return $this->error("手机号存在");
	    }

		return $this->success([],"注册成功");
	}

    public function logout(ServerRequestInterface $req)
    { 
        return $this->success([],"成功退出");
	}
	
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function code(Request $request)
    { 

		$mobile=new Mobile();
		
		$type=$request->get("type");

		$phone=$request->get("phone");
		
		$code= $mobile->code($phone, '', $type);
		
		$request->session()->put('mobile_code_'.$phone.'_'.$type, $code);
		
		return $this->success([],"验证码发送成功，请注意查收");
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
		
		$auth=new Auth();
		
		if($data["code"]!=$request->session()->get('mobile_code_'.$data["phone"].'_'.Mobile::FIND)){
			return $this->error("验证码不正确");
		}
		
		$auth->change($data);
		
		$request->session()->put('mobile_code_'.$data["phone"].'_'.Mobile::FIND,'');//修改完以后清掉这个session值
		
        return $this->success([],"密码重置成功");
    }
}
