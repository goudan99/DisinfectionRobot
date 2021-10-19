<?php

namespace Database\Factories\Model;

use App\Model\Job;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [ 		
            'name' => Str::random(10),
			'type_id' => $this->faker->numberBetween(1,5),
            'rate_type' => $this->faker->numberBetween(0,3),
			'is_test' => $this->faker->numberBetween(0,1),
			'status' => $this->faker->numberBetween(0,1),
			'start_at' => $this->faker->date('Y-m-d H:m:s','now'),
			'end_at' => $this->faker->date('Y-m-d H:m:s','now')
        ];
    }
}
