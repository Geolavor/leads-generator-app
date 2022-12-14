<?php

namespace LeadBrowser\Notification\Listeners;

use Illuminate\Database\Eloquent\Collection;
use LeadBrowser\Notification\Repositories\NotificationRepository;
use LeadBrowser\Notification\Events\CreateOrderNotification;
use LeadBrowser\Notification\Events\UpdateOrderNotification;

class Order
{
    /**
     * Create a new listener instance.
     *
     * @return void
     */
    public function __construct(protected NotificationRepository $notificationRepository)
    {
    }

    /**
     * Create a new resource.
     *
     * @return void
     */
    public function createOrder($order)
    {
        $this->notificationRepository->create(['type' => 'order', 'order_id' => $order->id]);
          
        event(new CreateOrderNotification);
    }

    /**
     * Fire an Event when the order status is updated.
     *
     * @return void
     */
    public function updateOrder($order)
    { 
        $orderArray = [
            'id'     => $order->id,
            'status' => $order->status,
        ];

        event(new UpdateOrderNotification($orderArray));
    }
}
