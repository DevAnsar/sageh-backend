<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'name' => $this->faker->firstName,
            'family' => $this->faker->lastName,
            'mobile' => $this->faker->phoneNumber,
            'national_code' => $this->faker->postcode,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$12$DzcWanzpjIGUYgooQ9Enx.rEpp9g/0J4Keo01bZ0aBq58/TtGDWMi', // password:12345678
            'remember_token' => Str::random(10),
        ];
    }
}
