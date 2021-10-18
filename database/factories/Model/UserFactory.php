<?php

namespace Database\Factories\Model;

use App\Model\User;
use App\Model\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [ 		
            'nickname' => $this->faker->name, 	
            'phone' => $this->faker->phoneNumber(),
			'code' => Str::random(4),
			'openid' => Str::random(10),
            'avatar' => $this->faker->image(public_path("upload"),640,480) ,
            'last_at' => $this->faker->date('Y-m-d H:m:s','now'),
            'last_ip' => $this->faker->ipv4, 
            'login_times' => $this->faker->randomNumber(),
            'passed' => $this->faker->numberBetween(0,1),
            'desc' => $this->faker->text(200),
			'is_system' => 0
        ];
    }
}
