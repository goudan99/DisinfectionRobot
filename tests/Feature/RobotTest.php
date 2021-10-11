<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Container\Container;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Faker\Generator;
use Str;
use App\Model\Machine;
use App\Model\Map;
use App\Model\Account;

class RobotTest extends TestCase
{
	//use RefreshDatabase;//测试完重置数据库
    protected $faker;

	/*机器列表*/
    public function testRobotMachineList()
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();
		
		$response = $this->actingAs($account, 'api')->json('get', '/api/robot/machine')->assertStatus(200)->assertJson(['code'=>0]);

    }

	/*机器详情*/
    public function testRobotMachineShow()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		if($machine=Machine::inRandomOrder()->first()){	//随机取一条数据进行修改测试
		
			$response = $this->actingAs($account, 'api')->json('get', '/api/robot/machine/'.$machine->id)->assertStatus(200)->assertJson(['code'=>0]);
		}else{
			$this->assertTrue(true);
		}
		
    }
	/*添加机器*/
    public function testRobotMachineAdd()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$data=["name"=>$this->faker->userName,"sn"=>$this->faker->name];
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$response = $this->actingAs($account, 'api')->json('post', '/api/robot/machine',$data)->assertStatus(200)->assertJson(['code'=>0]);
		

    }
	
	/*修改机器*/
    public function testRobotMachineEdit()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$data=["name"=>$this->faker->userName,"sn"=>$this->faker->name];
		
		$machine=Machine::inRandomOrder()->first();
		
		$data["id"]=$machine->id;
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$response = $this->actingAs($account, 'api')->json('post', '/api/robot/machine',$data)->assertStatus(200)->assertJson(['code'=>0]);

    }
	
	/*删除机器*/
    public function testRobotMachineRemove()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$data=Machine::inRandomOrder()->limit(2)->get()->map(function ($item, $key) {
			return $item->id;
		})->toArray();
		
		$response = $this->actingAs($account, 'api')->json('delete', '/api/robot/machine/',$data)->assertStatus(200)->assertJson(['code'=>0]);
    }
	
	/*地图列表*/
    public function testRobotMapList()
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();
		
		$response = $this->actingAs($account, 'api')->json('get', '/api/robot/map')->assertStatus(200)->assertJson(['code'=>0]);

    }

	/*地图详情*/
    public function testRobotMapShow()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		if($map=Map::inRandomOrder()->first()){	//随机取一条数据进行修改测试
		
			$response = $this->actingAs($account, 'api')->json('get', '/api/robot/map/'.$map->id)->assertStatus(200)->assertJson(['code'=>0]);
		}else{
			$this->assertTrue(true);
		}
		
    }
	/*添加地图*/
    public function testRobotMapAdd()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$machine=Machine::inRandomOrder()->first();
		
		$data=["name"=>$this->faker->userName,"machine_id"=>$machine->id];
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$response = $this->actingAs($account, 'api')->json('post', '/api/robot/map',$data)->assertStatus(200)->assertJson(['code'=>0]);

    }
	
	/*修改地图*/
    public function testRobotMapEdit()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$map=Map::inRandomOrder()->first();
		
		$data=["name"=>$this->faker->userName,"machine_id"=>$map->machine_id,"id"=>$map->id,"area"=>[]];
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$response = $this->actingAs($account, 'api')->json('post', '/api/robot/map',$data)->assertStatus(200)->assertJson(['code'=>0]);

    }
	
    public function testRobotMapRemove()//显示详情
    {
		$this->faker = App(Generator::class);
		
		$account = Account::where('id',1)->first();//模拟用户
		
		$data=Map::inRandomOrder()->limit(2)->get()->map(function ($item, $key) {
			return $item->id;
		})->toArray();
		
		$response = $this->actingAs($account, 'api')->json('delete', '/api/robot/map/',$data)->assertStatus(200)->assertJson(['code'=>0]);
    }
	
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
