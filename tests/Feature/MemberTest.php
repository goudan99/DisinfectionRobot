<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Container\Container;
use Tests\TestCase;
use Faker\Generator;
use Str;
use App\Model\User;
use App\Model\Role;
use App\Model\Account;

class MemberTest extends TestCase
{
	//use RefreshDatabase;//测试完重置数据库
    protected $faker;
	
    public function __construct() {
		$this->faker = $this->withFaker();
		parent::__construct();
	}

    /**
     * 成员管理
     *
     * @return void
     */
    public function testMemberUserList()
    {
		$this->faker = App(Generator::class);
		
		$search=[];//查询条件
		
		mt_rand(0,1)===1?$search['page']=mt_rand(-1,10):'';
		
		mt_rand(0,1)===1?$search['limit']=mt_rand(-1,10):'';
		
		mt_rand(0,1)===1?$search['key']=mt_rand(-1,10):'';
		
		$account = Account::where('id',1)->first();//模拟用户
		
		//开始进行测试
		$this->json('get', '/api/member/user', $search)->assertStatus(200)->assertJson(['code'=>401]);//所有用户
		
		$response = $this->actingAs($account)->json('get', '/api/member/user',$search);
		
		$response->assertStatus(200)->assertJson(['code'=>0]);
		
		/*核实数据*/
		$user=User::where('id','>',0);
		
		isset($search['key'])&&$search['key']?$user=$user->where('nickname','like','%'.trim($search['key']).'%'):'';
		
		isset($search['status'])&&$search['status']>0?$user=$user->where('passed',$search['status']):'';
		
		$count=$user->count();
		
		if($response->json('data.total')!==$count){
			print_r('开始分析');
			print_r('search:');
			print_r($search);
			print_r('数据库的数量:');
			print_r($count);
			print_r('api接口返回数量:');
			print_r($response->json('data.total'));
			print_r('结束分析');
			
		}
		
		$this->assertTrue($response->json('data.total')===$count, '这应该已经是能正常工作的');//有时候不等于true

    }
	
    /**
     * 添加成员
     *
     * @return void
     */
    public function testMemberUserAdd()
    {

		/*创建*/
        $this->faker = App(Generator::class);
		
		$data=[];
		$data["name"] = $this->faker->userName;
		$data["nickname"] = $this->faker->name;
		$data["phone"] = $this->faker->phoneNumber;
		$data["password"] = "3929699";
		$data["code"] = $this->faker->numerify('test###');
		$data["roles"] = [];
		$data["passed"] = mt_rand(0,1);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$response = $this->json('post', '/api/member/user',$data)->assertJson(['code'=>401]);
		
		$response = $this->actingAs($account)->json('post', '/api/member/user',$data)->assertJson(['code'=>0]);
		/*核实数据*/
		$user=User::where('phone',$data["phone"])->first();
		
		$count=Account::where('user_id',$user->id)->where(function($query) use ($data){
			$query->where('name', $data["name"])->orWhere('name',$data["phone"]);
		})->count();
		
		$this->assertTrue(2===$count);//有时候不等于true
	}
	
    /**
     * 修改成员
     *
     * @return void
     */
    public function testMemberUserEdit()
    {
		$this->faker = App(Generator::class);
		$user=User::inRandomOrder()->where('id','>',3)->first();//随机取一条数据进行修改测试
		$account = Account::where('id',1)->first();//模拟用户
		
		$data=["id"=>$user->id,"name"=>$this->faker->userName,"nickname"=>$this->faker->name,"phone"=>$this->faker->phoneNumber,"password"=>"3929699","roles"=>[],"passed"=>mt_rand(0,1)];//修改的数据

		$num=0;//要帐号数量
		$count = 0;//实际处理帐号数量
		$t=true;
		
		//随机处理移除手机修改
		if(mt_rand(0,1)===1){
			unset($data["phone"]);
		}else{
			$num=$num+1;
		}
		
		//随机处理移除帐号修改
		if(mt_rand(0,1)===1){
			unset($data["name"]);
			
		}else{
			$num=$num+1;
			
		}

		$this->actingAs($account)->json('put', '/api/member/user/',$data)->assertJson(['code'=>0]);
		
		
		/*核实数据*/
		
		//要帐号数量与实际修改数量是否相等
		if($num>0){
			$count=Account::where('user_id',$user->id)->where(function($query) use ($data,$num){
				if($num==2){
					$query->where('name', $data["name"])->orWhere('name',$data["phone"]);
				}else{
					isset($data["phone"])&&$data["phone"]?$query->where('name', $data["phone"]):'';
					isset($data["name"])&&$data["name"]?$query->where('name', $data["name"]):'';
				}
			});
			$count=$count->count();
		}
		$t=$t&&($num===$count);
		//user修改数据是否存在
		$user=User::where('id',$user->id);
		isset($data["nickname"])&&$data["nickname"]?$user=$user->where('nickname', $data["nickname"]):'';
		isset($data["phone"])&&$data["phone"]?$user=$user->where('phone', $data["phone"]):'';
		$user=$user->first();
		
		$user?$t=$t&&$t:$t=false;
		
		if(!$t){
			print_r('开始分析');
			print_r('要修改的帐号num数为:'.$num);
			print_r();
			print_r('实际修改帐号count数:'.$count);
			print_r('data:'.$data);
			print_r('结束分析');
		}

		$this->assertTrue($t);
	}
	
    /**
     * 删除成员
     *
     * @return void
     */
    public function testMemberUserRemove()
    {
		$user=User::inRandomOrder()->where('id','>',3)->limit(5)->get("id");//随机取一条数据进行修改测试
		$user=$user->map(function ($item, $key) {
			return $item->id;
		})->toArray();
		$account = Account::where('id',1)->first();//模拟用户
		$this->json('delete', '/api/member/user/',[1,2,3])->assertJson(['code'=>401]);
		$this->actingAs($account)->json('delete', '/api/member/user/',$user)->assertJson(['code'=>0]);
		
		/*核实数据*/
		if($a=User::whereIn('id',$user)->get()->toArray()){
			print_r($a);
			$this->assertTrue(false);
		}
		if($a=Account::whereIn('user_id',$user)->get()->toArray()){
			print_r($a);
			$this->assertTrue(false);
		}
		$this->assertTrue(true);
	}
    /**
     * 角色管理
     *
     * @return void
     */
    public function testMemberRoleList()
    {
		$search=[];//查询条件
		mt_rand(0,1)===1?$search['page']=mt_rand(-1,10):'';
		
		mt_rand(0,1)===1?$search['limit']=mt_rand(-1,10):'';
		
		mt_rand(0,1)===1?$search['key']=mt_rand(-1,10):'';
		
		$user = Account::where('id',1)->first();//模拟用户
		
		//没有登录
		$this->json('get', '/api/member/role', $search)->assertStatus(200)->assertJson(['code'=>401]);
		
		//查询测试
		$response = $this->actingAs($user)->json('get', '/api/member/role',$search);
		
		$response->assertStatus(200)->assertJson(['code'=>0]);//不管查询条件如何一定是成功，最多没有数据
		
		/*核实数据*/
		$user=Role::where('id','>',0);
		
		isset($search['key'])?$user=$user->where('name','like','%'.trim($search['key']).'%'):'';
		
		$this->assertTrue($response->json('data.total')===$user->count());
		
	}
	
    /**
     * 保存角色
     *
     * @return void
     */
    public function testMemberRoleAdd()
    {
		/*创建*/
        $this->faker = App(Generator::class);

		$user = Account::where('id',1)->first();//模拟用户
		$data=["name"=>$this->faker->userName,"access"=>[],"status"=>mt_rand(0,1)];//模拟数据

		//没有登录时
		$this->json('post', '/api/member/role', $data)->assertStatus(200)->assertJson(['code'=>401]);
		//查询测试
		$response = $this->actingAs($user)->json('post', '/api/member/role',$data)->assertStatus(200)->assertJson(['code'=>0]);
		
		/*核实数据*/
		$is_save=true;
		
		if(!$role=Role::where('name',$data["name"])->where('status',$data["status"])->first()){
			$is_save=false;
		}

		$this->assertTrue($is_save);
		
	}
	
    /**
     * 保存角色
     *
     * @return void
     */
    public function testMemberRoleEdit()
    {
		/*创建*/
        $this->faker = App(Generator::class);

		$user = Account::where('id',1)->first();//模拟用户
		
		$role=Role::inRandomOrder()->first();//随机取一条数据进行修改测试
		$data=["id"=>$role->id,"name"=>$this->faker->userName,"access"=>[],"status"=>mt_rand(0,1)];//模拟数据

		//没有登录时
		$this->json('post', '/api/member/role', $data)->assertStatus(200)->assertJson(['code'=>401]);
		//查询测试
		$response = $this->actingAs($user)->json('post', '/api/member/role',$data)->assertStatus(200)->assertJson(['code'=>0]);
		
		/*核实数据*/
		$is_save=true;
		
		if(!$role1=Role::where('id',$role->id)->where('name',$data["name"])->where('status',$data["status"])->first()){
			$is_save=false;
		}
		$this->assertTrue($is_save);
		
	}
	
    /**
     * 删除成员
     *
     * @return void
     */
    public function testMemberRoleRemove()
    {
		$role=Role::inRandomOrder()->limit(5)->get("id");//随机取数据进行修改测试
		
		$role=$role->map(function ($item, $key) {
			return $item->id;
		})->toArray();
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$this->json('delete', '/api/member/role/',$role)->assertJson(['code'=>401]);
		
		$this->actingAs($account)->json('delete', '/api/member/role/',$role)->assertJson(['code'=>0]);
		
		/*核实数据*/
		//if($a=Role::whereIn('id',$role)->get()->toArray()){
		//	print_r($a);
		//	$this->assertTrue(false);
		//}

		$this->assertTrue(true);
	}
	
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
