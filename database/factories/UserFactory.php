<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'cost_place' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'password' => Hash::make('password'), // Hashed default password
            'statuses' => $this->faker->randomElement(['active', 'inactive']),
            'send_security_report' => $this->faker->boolean(),
            'report_delete_duration' => $this->faker->randomDigit(),
            'groups' => $this->faker->words(3, true),
            'reg_email' => $this->faker->safeEmail(),
            'parent_id' => $this->faker->numberBetween(1, 10),
            'dep_id' => $this->faker->numberBetween(1, 10),
            'interview_template' => $this->faker->numberBetween(1, 5),
            'interviewed' => $this->faker->boolean(),
            'remainder_email' => $this->faker->email(),
            'remainder_email_template' => $this->faker->word(),
            'sent_email' => $this->faker->randomDigit(),
            'remember_token' => Str::random(10),
        ];
    }
}
