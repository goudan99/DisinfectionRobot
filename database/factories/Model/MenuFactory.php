<?php

namespace Database\Factories\Model;

use App\Model\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

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
			'desc' => $this->faker->text(10),
			'prefix' => "/",
			'path' => "/",
			'icon' => "home",
			'order' => 0,
			'status' => 1,
			'is_system' => 0,
			'target' => $this->faker->text(10)
        ];
    }
}
