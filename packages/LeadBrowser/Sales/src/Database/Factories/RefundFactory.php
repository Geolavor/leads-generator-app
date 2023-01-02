<?php

namespace LeadBrowser\Sales\Database\Factories;

use LeadBrowser\Sales\Models\Order;
use LeadBrowser\Sales\Models\Refund;
use Illuminate\Database\Eloquent\Factories\Factory;

class RefundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Refund::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
        ];
    }
}

