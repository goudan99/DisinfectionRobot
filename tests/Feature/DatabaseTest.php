<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Model\User;
use App\Model\Role;

class DatabaseTest extends TestCase
{
	use RefreshDatabase;
    /**
     * 数据库测试
     *
     * @return void
     */
    public function testDatabaseFactories()
    {
		// $user = User::factory()->create();
		
		// $user = User::where('name','admin')->first();
		// print_r($user);
		// $user = User::factory()->count(5)->create();
		// $users = User::factory()->count(500)->make();
        // $task = [
           // 'text' => 'New task text',
           // 'user_id' => $user->id
        // ];
		
		// $role = Role::factory()->has(User::factory()->count(3))->create();
		// Access::factory()->create();
		
    }

}
