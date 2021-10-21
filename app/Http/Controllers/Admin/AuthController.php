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
    public function login(Request $request)
    { 
        $credentials = request(['username', 'password']);
		
		$credentials = ["name"=>$request->username, 'password'=>$request->password];
		
		$this->validateLogin($request);
		
        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
		
        if (!$token = auth()->attempt($credentials)) {
			
			$this->incrementLoginAttempts($request);
			
            throw ValidationException::withMessages([
              "password" => "帐号或密码错误",
            ]);
        }
		
		$request->session()->regenerate();
		
		$this->clearLoginAttempts($request);
		
        $data = [
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
		];
		  
        return $this->success($data);
    }
	
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|min:6|max:16|regex:/^[a-zA-Z0-9~@#%_]{6,16}$/i',
        ],[
			$this->username().".required"=>"帐号必填",
			$this->username().".string"=>"帐号必须字符串",
			"password.required"=>"密码必填",
			"password.min"=>"密码最短为6位",
			"password.max"=>"密码不要超过16位",
			"password.regex"=>"密码包含非法字符，只能为英文字母(a-zA-Z)、阿拉伯数字(0-9)与特殊符号(~@#%_)组合",
		]);
    }
	
    public function username()
    {
        return 'username';
    }
	
    public function program(Request $request)
    { 
		$code = request("code");
		
		$config = config("robot")["miniProgram"];
		
		$app = Factory::miniProgram($config);
		
		$openid = "ofeYf1JTKjv6eutx_2lM8McRq3sw";
		
		$wedata = [];
		
		if(!(config("app")["env"]=="local"||config("app")["env"]=="testing")){
			$wedata = $app->auth->session($code);
			if(isset($wedata["errcode"])){
				return $this->error("code无效，重新获取",[["code"=>$wedata["errmsg"]]],Code::VALIDATE);
			}
			$openid = $wedata["openid"];
		}

        if(config("app")["env"]=="testing"&&$code!="111"){
			return $this->error("code无效，重新获取",["code"=>"无效的ode码"],Code::VALIDATE);
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
		
		//if($data["code"]!=phonecode($data["phone"],Mobile::LOGIN)){
        //    throw ValidationException::withMessages([
        //      "code" => "验证码不正确",
        //    ]);
		//}
		
		if(!$user = Account::where("name",$data["phone"])->where("type",1)->first()){
            throw ValidationException::withMessages([
              "code" => "验证码不正确",
            ]);
		}
		
		$token = auth()->login($user);
		
		phonecode($data["phone"],Mobile::LOGIN,'');//修改完以后清掉这个session值
		
        $data = [
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60
		];
		  
        return $this->success($data);
    }
	
	/**
	  注册必须是
	**/
    public function register(RegisterRequest $request)
    {
		$data = $request->all();
		
		$data['openid']='123';
		
		/*验证验证码*/
		// if($data["phone_code"]!=phonecode($data["phone"],Mobile::REGISTER)){
            // throw ValidationException::withMessages([
              // "phone_code" => "验证码不正确",
            // ]);
		}
		
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
		
		$auth=new Auth();
		
		if($data["code"]!=phonecode($data["phone"],Mobile::FIND)){
            throw ValidationException::withMessages([
              "code" => "验证码不正确",
            ]);
		}
		
		$auth->change($data);
		
		phonecode($data["phone"],Mobile::FIND,'');//修改完以后清掉这个session值
		
        return $this->success([],"密码重置成功");
    }
	
    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxAttempts()
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit(
            $this->throttleKey($request), $this->decayMinutes() * 60
        );
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => "请 $seconds 秒后再试",
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        $this->limiter()->clear($this->throttleKey($request));
    }

    /**
     * Fire an event when a lockout occurs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function fireLockoutEvent(Request $request)
    {
        event(new Lockout($request));
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input($this->username())).'|'.$request->ip();
    }

    /**
     * Get the rate limiter instance.
     *
     * @return \Illuminate\Cache\RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return int
     */
    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    /**
     * Get the number of minutes to throttle for.
     *
     * @return int
     */
    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
    }
}
