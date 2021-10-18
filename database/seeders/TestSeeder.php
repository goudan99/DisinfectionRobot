<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Model\User;
use App\Model\Role;
use App\Model\Account;
use App\Model\Access;
use App\Model\Menu;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
		$access=Access::factory()->count(50)->create();
		
		Menu::factory()->count(8)->create()->each(function($item) use ($access){
		  $item->access()->attach($access->random(6)) ;
		});
		
		$role=Role::factory()->count(8)->create()->each(function($item) use ($access){
		  $item->access()->attach($access->random(6)) ;
		});
		
		User::factory()->has(Account::factory()->count(3))->count(50)->create()->each(function($item) use ($role){
			$item->roles()->attach($role->random(6)) ;
		});


        //
		/*User::factory()->has(
			Role::factory()->has(
				Access::factory()->count(10)
			)->count(3)
		)->has(
			Account::factory()->count(2)
		)->count(50)->create();
		*/
    }
}
