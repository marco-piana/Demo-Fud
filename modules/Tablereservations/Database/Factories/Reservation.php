<?php

namespace Modules\Tablereservations\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Reservation extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Tablereservations\Models\Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'customer_id' => \Modules\Tablereservations\Models\Customer::factory(),  // Assuming you have a CustomerFactory
            'table_id' => $this->faker->randomElement([null, '1', null, '2', null, '3', null, '4', null, '5', null, '6', null, '7', null, '8', null, '9', null, '10', '11', '12', '13', '14', '15', '16', '17']),
            'reservation_date' => $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'reservation_time' => $this->faker->time(),
            'created_by' => $this->faker->randomElement(["customer", "admin", "staff", "system"]),
            'number_of_guests' => $this->faker->numberBetween(1, 10),
            'special_requests' => $this->faker->boolean(30) ? $this->faker->sentence : null,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'pending', 'cancelled', 'pending', 'completed', 'seated', 'soon', 'late', 'no-show']),
            'reservation_code' => $this->faker->unique()->randomNumber(6)
        ];
    }
}
