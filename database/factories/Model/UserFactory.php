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
            'name' => $this->faker->userName,  
			'password' => Hash::make($this->faker->password),			
            'nickname' => $this->faker->name, 
            'role_id' => Role::factory(),  
            'role_name' => function (array $attributes) {
				return Role::find($attributes['role_id'])->name;
			},		
            'phone' => $this->faker->phoneNumber(),
			'email' => $this->faker->email(),
            'avatar' => $this->faker->image(storage_path("uplpoad"),640,480) ,
            'last_at' => $this->faker->date('Y-m-d H:m:s','now'),
            'last_ip' => $this->faker->ipv4, 
            'login_times' => $this->faker->randomNumber(),
            'passed' => $this->faker->numberBetween(0,1),
            'desc' => $this->faker->text(200),
			'is_system' => $this->faker->numberBetween(0,1)
        ];
    }
}
