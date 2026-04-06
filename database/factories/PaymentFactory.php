<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition()
    {
        $statuses = ['pending', 'success', 'failed', 'expired', 'canceled'];

        return [
            'order_id' => 'PYMT-' . time() . '-' . strtoupper(fake()->bothify('??????')),
            'status' => fake()->randomElement($statuses),
            'amount' => fake()->numberBetween(10000, 1000000),
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => fake()->phoneNumber(),
            'payment_data' => [
                'transaction_time' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'payment_type' => fake()->randomElement(['bank_transfer', 'credit_card', 'gopay', 'shopeepay']),
                'bank' => fake()->randomElement(['bca', 'bni', 'bri', 'mandiri', null]),
            ],
        ];
    }
}
