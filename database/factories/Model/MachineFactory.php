<?php

namespace Database\Factories\Model;

use App\Model\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class MachineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Machine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [ 		
            'name' => Str::random(10),, 	
            'sn' => Str::random(10),
            'status' => $this->faker->numberBetween(0,1)
        ];
    }
}
