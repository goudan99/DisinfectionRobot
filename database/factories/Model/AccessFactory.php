<?php

namespace Database\Factories\Model;

use App\Model\User;
use App\Model\Access;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class AccessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Access::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
			'parent_id' => $this->faker->numberBetween(0,20),
            'name' => $this->faker->userName,
			'code' => $this->faker->userName,
			'path' => "/",
			'method' => "POST",
			'desc' => $this->faker->text(10)
        ];
    }
}
