<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Model\User;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		User::factory()->times(50)->hasPosts(1)->create();
    }
}
