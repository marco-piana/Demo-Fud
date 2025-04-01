<?php

namespace Modules\Tablereservations\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Customer extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Tablereservations\Models\Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' =>1,
            'name' => $this->faker->name,           // Generates a full name
            'email' => $this->faker->unique()->safeEmail,  // Generates a unique email
            'phone' => $this->faker->phoneNumber    // Generates a phone number 
        ];
    }
}
