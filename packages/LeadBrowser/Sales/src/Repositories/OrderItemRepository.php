<?php

namespace LeadBrowser\Sales\Repositories;

use Illuminate\Support\Facades\Log;
use LeadBrowser\Core\Eloquent\Repository;
use LeadBrowser\Sales\Models\OrderItem;

class OrderItemRepository extends Repository
{
    /**
     * Specify model class name.
     *
     * @return string
     */
    public function model()
    {
        // TODO: Change this to contract
        return OrderItem::class;
    }

    /**
     * Create.
     *
     * @param  array  $data
     * @return \LeadBrowser\Sales\Contracts\OrderItem
     */
    public function create(array $data)
    {
        if (isset($data['product']) && $data['product']) {
            // TODO
            $data['product_id']     = $data['product'];//$data['product']->id ?: 1;
            $data['product_type']   = '\LeadBrowser\Products\Models\Product';//get_class($data['product']);

            unset($data['product']);
        }

        return parent::create($data);
    }

    /**
     * Collect totals.
     *
     * @param  \LeadBrowser\Sales\Contracts\OrderItem  $orderItem
     * @return \LeadBrowser\Sales\Contracts\OrderItem
     */
    public function collectTotals($orderItem)
    {
        $qtyInvoiced = $qtyRefunded = 0;

        $totalInvoiced = $baseTotalInvoiced = 0;
        $taxInvoiced = $baseTaxInvoiced = 0;

        $totalRefunded = $baseTotalRefunded = 0;
        $taxRefunded = $baseTaxRefunded = 0;

        foreach ($orderItem->invoice_items as $invoiceItem) {
            $qtyInvoiced += $invoiceItem->qty;

            $totalInvoiced += $invoiceItem->total;
            $baseTotalInvoiced += $invoiceItem->base_total;

            $taxInvoiced += $invoiceItem->tax_amount;
            $baseTaxInvoiced += $invoiceItem->base_tax_amount;
        }

        foreach ($orderItem->refund_items as $refundItem) {
            $qtyRefunded += $refundItem->qty;

            $totalRefunded += $refundItem->total;
            $baseTotalRefunded += $refundItem->base_total;

            $taxRefunded += $refundItem->tax_amount;
            $baseTaxRefunded += $refundItem->base_tax_amount;
        }

        $orderItem->qty_invoiced = $qtyInvoiced;
        $orderItem->qty_refunded = $qtyRefunded;

        $orderItem->total_invoiced = $totalInvoiced;
        $orderItem->base_total_invoiced = $baseTotalInvoiced;

        $orderItem->tax_amount_invoiced = $taxInvoiced;
        $orderItem->base_tax_amount_invoiced = $baseTaxInvoiced;

        $orderItem->amount_refunded = $totalRefunded;
        $orderItem->base_amount_refunded = $baseTotalRefunded;

        $orderItem->tax_amount_refunded = $taxRefunded;
        $orderItem->base_tax_amount_refunded = $baseTaxRefunded;

        $orderItem->save();

        return $orderItem;
    }

}
