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
			'type' => $this->faker->numberBetween(0,1),			
			'relace_id' => $this->faker->numberBetween(0,1),
			'code' => $this->faker->userName,
			'path' => $this->faker->image(storage_path("uplpoad"),640,480),
			'desc' => $this->faker->text(200),
            'status' => $this->faker->numberBetween(0,1),            
			'is_system' => $this->faker->numberBetween(0,1)
        ];
    }
}
