<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Container\Container;
use Tests\TestCase;
use App\Model\User;
use App\Model\Role;
use Laravel\Passport\Passport;
use Faker\Generator;

class MemberTest extends TestCase
{
	//use RefreshDatabase;
    protected $faker;
	
    // public function __construct()
    // {
        // $this->faker = $this->withFaker();
    // }
	//use RefreshDatabase;
	
    /**
     * 登录流程
     *
     * @return void
     */
    public function testLogin()
    {
		$this->artisan('db:seed');
		//没有登录前
		$response = $this->getJson('/api/profile/user');
		$response->assertStatus(401);
		$response = $this->getJson('/api/profile/menu');
		$response->assertStatus(401);
		$response = $this->getJson('/api/member/user');
		$response->assertStatus(401);
		$response = $this->getJson('/api/member/role');
		$response->assertStatus(401);
		
		//登录后
        $response = $this->json('POST', '/api/login/token', ['username' => 'admin','password' => '123456']);
        $response->assertStatus(200)->assertJson(['code'=>'0']);
		$token=$response->json('data.token_type').' '.$response->json('data.access_token');
		//获取用户信息
		$response = $this->withHeaders(['Authorization' => $token,])->getJson('/api/profile/user');
		$response->assertStatus(200)->assertJson(['code'=>'0','message'=>'success']);
		//获取用户菜单权限
		$response = $this->withHeaders(['Authorization' => $token])->getJson('/api/profile/menu');
		$response->assertStatus(200)->assertJson(['code'=>'0','message'=>'success']);
    }
	
    /**
     * 创建修改删除用户
     *
     * @return void
     */
    public function testCreateUser()
    {
		$role = Role::first();
		//登录后
        $response = $this->json('POST', '/api/login/token', ['username' => 'admin','password' => '123456']);
        $response->assertStatus(200)->assertJson(['code'=>'0']);
		$token=$response->json('data.token_type').' '.$response->json('data.access_token');
		
		//验证不通过
		//1,电话验证
		$response = $this->withHeaders(['Authorization' => $token,])->json('post','/api/member/user', [
			'name' => 'adm',
			'password' => '1',
			'passed' => '25',
			'nickname' => 'test',
			'phone' => '130',
			'email' => '',
			'role_id' => '99999',
			'role_name' => '2000',
			'desc' => '9999'
		]);
		
		$response->assertJson(['code'=>'422','msg'=>'数据验证不正确']);
		
		//1,邮件验证
		$response = $this->withHeaders(['Authorization' => $token,])->json('post','/api/member/user', [
			'name' => 'pppp0000',
			'password' => '123445678',
			'passed' => '1',
			'nickname' => 'test',
			'phone' => '13129294899',
			'email' => 'adbc@163.com',
			'role_id' => $role?$role->id:-1,
			'role_name' => $role?$role->name:'',
			'desc' => '9999'
		]);
		//$response->assertJson(['code'=>'101','msg'=>'帐号已存在']);
		//$response->dump();
		//$this->assertDatabaseHas('users', ['email' => 'xueyuanjun@laravelacademy.org']);
		//验证帐号重复
		
		//获取用户菜单权限
		$response = $this->withHeaders(['Authorization' => $token])->getJson('/api/profile/menu');
		$response->assertStatus(200)->assertJson(['code'=>'0','message'=>'success']);
    }
	
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
