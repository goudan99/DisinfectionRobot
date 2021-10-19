<?php

namespace Database\Factories\Model;

use App\Model\Map;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class MapFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Map::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [ 		
            'name' => Str::random(10),
            'area' => $this->faker->phoneNumber(),
            'image' => $this->faker->image(public_path("upload"),640,480),
			'image_size' => $this->faker->numberBetween(0,1),
			'file_size' => $this->faker->numberBetween(0,1),
			'status' => $this->faker->numberBetween(0,1),
        ];
    }
}
