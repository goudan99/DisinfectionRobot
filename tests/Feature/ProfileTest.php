<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Container\Container;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Faker\Generator;
use Str;
use App\Model\Notice;
use App\Model\Account;

class ProfileTest extends TestCase
{
	//use RefreshDatabase;//测试完重置数据库
    protected $faker;
	
    public function __construct() {
		
		$this->faker = $this->withFaker();

		parent::__construct();
	}

    /**
     * 显示个人信息
     *
     * @return void
     */
    public function testProfileUserInfo()
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		//开始进行测试
		//$this->json('get', '/api/profile/user')->assertStatus(200)->assertJson(['code'=>401]);//这样会影响下一个获取到用户
		
		$response = $this->actingAs($account, 'api')->json('get', '/api/profile/user')->assertStatus(200)->assertJson(['code'=>0]);
		
    }
	
	/*获取用户菜单*/
    public function testProfileUserMenu()
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$data["nickname"] = $this->faker->name;
		
		$data["avatar"] = $this->faker->phoneNumber;
		
		$response = $this->actingAs($account, 'api')->json('get', '/api/profile/menu',$data)->assertStatus(200)->assertJson(['code'=>0]);
		
    }
	
	/*保存个信息*/
    public function testProfileUserStore()
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$data["nickname"] = $this->faker->name;
		
		$data["avatar"] = $this->faker->phoneNumber;
		
		$response = $this->actingAs($account, 'api')->json('post', '/api/profile/user',$data)->assertStatus(200)->assertJson(['code'=>0]);
		
    }
	
	/*上传头像*/
    public function testProfileUserAvatar()
    {
		$account = Account::where('id',1)->first();//模拟用户
		
		$data["file"] = UploadedFile::fake()->image('avatar.jpg');
		
		$response = $this->actingAs($account, 'api')->json('post', '/api/profile/avatar',$data)->assertStatus(200)->assertJson(['code'=>0]);
		
		//Storage::disk(config("shop")["avatar"])->assertExists('avatar.jpg');
    }
	
	/*修密码*/
    public function testProfileUserPassword()
    {
		$account = Account::where('id',1)->first();//模拟用户
		
        $response = $this->actingAs($account, 'api')->json('POST', '/api/public/mobile/code', ['type'=>2]);
		
		$code=$response->json('data');
		
		$data["code"] = $code;
		
		$data["password"] = "123123";
		
		$data["password_confirmation"] = "123123";
		
		$response = $this->actingAs($account, 'api')->json('post', '/api/profile/password',$data)->assertStatus(200)->assertJson(['code'=>0]);
		
    }
	/*修手机*/
    public function testProfileUserPhone()
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$data["nickname"] = $this->faker->name;
		
		$data["avatar"] = $this->faker->phoneNumber;
		
		$response = $this->actingAs($account, 'api')->json('post', '/api/profile/user',$data)->assertStatus(200)->assertJson(['code'=>0]);
		
    }

	/*通知列表*/
    public function testProfileNoticeList()
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();
		
		$response = $this->actingAs($account, 'api')->json('get', '/api/profile/notice')->assertStatus(200)->assertJson(['code'=>0]);

    }

	
    public function testProfileNoticeShow()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		if($notice=Notice::inRandomOrder()->first()){	//随机取一条数据进行修改测试
		
			$response = $this->actingAs($account, 'api')->json('get', '/api/profile/notice/'.$notice->id)->assertStatus(200)->assertJson(['code'=>0]);
		}else{
			$this->assertTrue(true);
		}
		
    }
	
    public function testProfileNoticeRead()//标志为已读
    {
		$this->faker = App(Generator::class);
		$account = Account::where('id',1)->first();//模拟用户
		if($notice=Notice::inRandomOrder()->first()){	//随机取一条数据进行修改测试
			$response = $this->actingAs($account, 'api')->json('put', '/api/profile/notice/'.$notice->id)->assertStatus(200)->assertJson(['code'=>0]);
		}else{
			$this->assertTrue(true);
		}
		
		
    }
	
    public function testProfileNoticeRemove()
    {
		$this->faker = App(Generator::class);
		$account = Account::where('id',1)->first();//模拟用户
		if($notice=Notice::inRandomOrder()->first()){	//随机取一条数据进行修改测试
			$response = $this->actingAs($account, 'api')->json('delete', '/api/profile/notice/'.$notice->id)->assertStatus(200)->assertJson(['code'=>0]);
		}else{
			$this->assertTrue(true);
		}
		
		
    }
	
    public function testProfileNoticeRestore()//恢复删除数据
    {
		$this->faker = App(Generator::class);
		$account = Account::where('id',1)->first();//模拟用户
		if($notice=Notice::inRandomOrder()->first()){
			$response = $this->actingAs($account, 'api')->json('patch', '/api/profile/notice/'.$notice->id)->assertStatus(200)->assertJson(['code'=>0]);
		}else{
			$this->assertTrue(true);
		}
		
    }
	
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
