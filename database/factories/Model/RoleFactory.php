<?php

namespace Database\Factories\Model;

use App\Model\User;
use App\Model\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->userName,
            'status' => $this->faker->numberBetween(0,1),
            'desc' => $this->faker->text(200),
			'is_system' => $this->faker->numberBetween(0,1)
        ];
    }
}
