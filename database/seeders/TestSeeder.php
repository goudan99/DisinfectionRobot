<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Model\User;
use App\Model\Role;
use App\Model\Account;
use App\Model\Access;
use App\Model\Menu;
use App\Model\Machine;
use App\Model\Map;
use App\Model\Job;
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
		
		$user=User::factory()->has(Account::factory()->count(3))->count(20)->create()->each(function($item) use ($role){
			$item->roles()->attach($role->random(6)) ;
		});
		
		$machine=Machine::factory()->count(10)->create();
		
		$map=Map::factory()->count(20)->create()->each(function($item) use ($machine,$user){
			$mac=$machine->random(1)[0];
			$item->machine_id=$mac->id;
			$item->machine_name=$mac->name;
			$u=$user->random(1)[0];
			$item->user_id=$u->id;
			$item->user_name=$u->nickname;
			$item->save();
		});
		
		$job=Job::factory()->count(20)->create()->each(function($item) use ($machine,$user,$map){
			
			$mac=$machine->random(1)[0];
			$item->machine_id=$mac->id;
			$item->machine_name=$mac->name;
			
			$u=$user->random(1)[0];
			$item->user_id=$u->id;
			$item->user_name=$u->nickname;
			
			$m=$map->random(1)[0];
			$item->map_id=$m->id;
			$item->map_name=$m->name;
			$item->save();
		});
		
    }
}
