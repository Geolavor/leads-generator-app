<?php

namespace LeadBrowser\Sales\Database\Factories;

use LeadBrowser\Customer\Models\Customer;
use LeadBrowser\Customer\Models\CustomerAddress;
use LeadBrowser\Sales\Models\Order;
use LeadBrowser\Sales\Models\OrderAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $customer = Customer::factory()
                            ->create();
        $customerAddress = CustomerAddress::factory()
                                          ->make();

        return [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'email' => $customer->email,
            'address1' => $customerAddress->address1,
            'country' => $customerAddress->country,
            'state' => $customerAddress->state,
            'city' => $customerAddress->city,
            'postcode' => $customerAddress->postcode,
            'phone' => $customerAddress->phone,
            'address_type' => OrderAddress::ADDRESS_TYPE_BILLING,
            'order_id' => Order::factory(),
        ];
    }

}