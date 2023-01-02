<?php

namespace LeadBrowser\Sales\Repositories;

use Illuminate\Container\Container as App;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Sales\Models\DownloadableLinkPurchased;

class DownloadableLinkPurchasedRepository extends Repository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        App $app
    )
    {
        parent::__construct($app);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return DownloadableLinkPurchased::class;
    }

    /**
     * @param  \LeadBrowser\Sales\Contracts\OrderItem  $orderItem
     * @return void
     */
    public function saveLinks($orderItem)
    {
        if (! $this->isValidDownloadableProduct($orderItem)) {
            return;
        }

        foreach ($orderItem->additional['links'] as $linkId) {
            $this->create([
                'product_name'    => $orderItem->name,
                'status'          => 'pending',
                'user_id'     => $orderItem->order->user_id,
                'order_id'        => $orderItem->order_id,
                'order_item_id'   => $orderItem->id,
            ]);
        }
    }

    /**
     * Return true, if ordered item is valid downloadable product with links
     *
     * @param  \LeadBrowser\Sales\Contracts\OrderItem  $orderItem
     * @return bool
     */
    private function isValidDownloadableProduct($orderItem) : bool {
        if (stristr($orderItem->type,'downloadable') !== false && isset($orderItem->additional['links'])) {
            return true;
        }

        return false;
    }

    /**
     * @param  \LeadBrowser\Sales\Contracts\OrderItem  $orderItem
     * @param  string    $status
     * @return void
     */
    public function updateStatus($orderItem, $status)
    {
        $purchasedLinks = $this->findByField('order_item_id', $orderItem->id);

        foreach ($purchasedLinks as $purchasedLink) {
            if ($status == 'expired') {
                if (count($purchasedLink->order_item->invoice_items) > 0) {
                    $totalInvoiceQty = 0;

                    foreach ($purchasedLink->order_item->invoice_items as $invoice_item) {
                        $totalInvoiceQty = $totalInvoiceQty + $invoice_item->qty;
                    }

                    $orderedQty = $purchasedLink->order_item->qty_ordered;
                    $totalInvoiceQty = $totalInvoiceQty * ($purchasedLink->download_bought / $orderedQty);            

                    $this->update([
                        'status' => $purchasedLink->download_used == $totalInvoiceQty ? $status : $purchasedLink->status,
                        'download_canceled' => $purchasedLink->download_bought - $totalInvoiceQty,
                    ], $purchasedLink->id);
                } else {
                    $this->update([
                        'status' => $status,
                        'download_canceled' => $purchasedLink->download_bought,
                    ], $purchasedLink->id);
                }
            } else {
                $this->update([
                    'status' => $status,
                ], $purchasedLink->id);
            }
        }
    }
}