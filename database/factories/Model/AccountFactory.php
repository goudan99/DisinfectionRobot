<?php

namespace Database\Factories\Model;
use App\Model\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Hash;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->text(200),
            'name' => $this->faker->userName,
            'password' => Hash::make($this->faker->password),
            'type' => $this->faker->numberBetween(0,3),
			'passed' => $this->faker->numberBetween(0,1)
        ];
    }
}
