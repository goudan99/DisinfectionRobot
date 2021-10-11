<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Container\Container;
use Tests\TestCase;
use App\Repositories\Mobile;
use Faker\Generator;
use Str;

class AuthTest extends TestCase
{
	//use RefreshDatabase;//测试完重置数据库

    public function __construct() {

		parent::__construct();
	}
    /**
     * 用户登录,无法测试没有openid
     *
     * @return void
     */
    public function testAuthRegister()
    {
		$phone = $this->withFaker()->phoneNumber;//随便生成一个手机进行注册
		
		$phone1 = "15113339677";
		
        $response = $this->json('POST', '/api/public/mobile/code', ['type'=>0,'phone'=>$phone]);
		
		$code=$response->json('data');
		
		//注册失败，手机号已注册
		$response = $this->json('POST', '/api/auth/register', ['phone'=>$phone1,'phone_code' => $code,'invite_code' => Str::random(10),'password'=>'admin456','password_confirmation' => 'admin456'])->assertStatus(200)->assertJson(['code'=>'422']);
		
		//注册失败，手机号与验证码不匹配
		$response = $this->json('POST', '/api/auth/register', ['phone'=>$phone,'phone_code' => Str::random(4),'invite_code' => Str::random(10),'password'=>'admin456','password_confirmation' => 'admin456'])->assertStatus(200)->assertJson(['code'=>'422']);
		
		//注册成功
        $response = $this->json('POST', '/api/auth/register', ['phone'=>$phone,'phone_code' => $code,'invite_code' => Str::random(10),'password'=>'admin456','password_confirmation' => 'admin456'])->assertStatus(200)->assertJson(['code'=>'0']);

	}
	
    /**
     * 需找密码
     *
     * @return void
     */
    public function testAuthFind()
    {
		$phone= "15113339677";
		
        $response = $this->json('POST', '/api/public/mobile/code', ['type'=>Mobile::FIND,'phone'=>$phone]);
		$code=$response->json('data');
		
        $response = $this->json('POST', '/api/auth/find/password', ['phone'=>$phone,'code' => $code,'password' => 'admin888','password_confirmation' => 'admin888'])->assertStatus(200)->assertJson(['code'=>'0']);//修改成功
		$response = $this->json('POST', '/api/auth/find/password', ['phone'=>$phone,'code' => '123','password' => 'admin123','password_confirmation' => 'admin123'])->assertStatus(200)->assertJson(['code'=>'422']);//修改失败
		$response = $this->json('POST', '/api/auth/find/password', ['phone'=>$phone,'code' => $code,'password' => 'admin123','password_confirmation' => 'admin122'])->assertStatus(200)->assertJson(['code'=>'422']);//修改失败
		$response = $this->json('POST', '/api/auth/find/password', ['phone'=>$phone,'code' => $code,'password' => 'a3','password_confirmation' => 'a3'])->assertStatus(200)->assertJson(['code'=>'422']);//修改失败
	}
	
    /**
     * 用户登录
     *
     * @return void
     */
    public function testAuthLogin()
    {

		$phone = "15113339677";
	
		
		//登录成功
        $response = $this->json('POST', '/api/auth/login/token', ['username' => 'admin','password' => 'admin888'])->assertStatus(200)->assertJson(['code'=>'0']);		// 登录成功，以帐号登录
		$response = $this->json('POST', '/api/auth/login/token', ['username' => $phone,'password' => 'admin888'])->assertStatus(200)->assertJson(['code'=>'0']);		// 登录成功，以手机号为帐登录
        $response = $this->json('POST', '/api/auth/login/token', ['username' => 'admin','password' => ''])->assertStatus(200)->assertJson(['code'=>'422']);				// 登录失败,同样以422返回，产表识字段为 password
        $response = $this->json('POST', '/api/auth/login/token', ['username' => 'admin','password' => '12345678'])->assertStatus(200)->assertJson(['code'=>'422']);		// 登录失败,同样以422返回，产表识字段为 password
		//小程序登录
		//$response = $this->json('POST', '/api/auth/login/program', ['code' => '111'])->assertStatus(200)->assertJson(['code'=>'0']);	//成功
        $response = $this->json('POST', '/api/auth/login/program', ['code' => '222'])->assertStatus(200)->assertJson(['code'=>'422']);	// 失败
		//手机验证码登录
        $response = $this->json('POST', '/api/public/mobile/code', ['type'=>Mobile::LOGIN,'phone'=>$phone]);
		$code=$response->json('data');
        $response = $this->json('POST', '/api/auth/login/phone', ['phone'=>$phone,'code' => $code])->assertStatus(200)->assertJson(['code'=>'0']);	// 成功
        $response = $this->json('POST', '/api/auth/login/phone', ['phone'=>$phone,'code' => '222'])->assertStatus(200)->assertJson(['code'=>'422']);	// 失败

    }
	
	
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
