<?php

namespace LeadBrowser\Payment\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use LeadBrowser\Sales\Repositories\OrderRepository;
use LeadBrowser\Sales\Repositories\InvoiceRepository;

/**
 * Generate Invoice Event handler
 *
 */
class GenerateInvoice
{
    /**
     * Create the event listener.
     *
     * @param  LeadBrowser\Sales\Repositories\OrderRepository $orderRepository
     * @param \LeadBrowser\Sales\Repositories\InvoiceRepository invoiceRepository
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected InvoiceRepository $invoiceRepository
    )
    {
    }

    /**
     * Generate a new invoice.
     *
     * @param  object  $order
     * @return void
     */
    public function handle($order)
    {
        if ($order->payment->method == 'cashondelivery' && core()->getConfigData('sales.paymentmethods.cashondelivery.generate_invoice')) {
            $this->invoiceRepository->create($this->prepareInvoiceData($order), core()->getConfigData('sales.paymentmethods.cashondelivery.invoice_status'), core()->getConfigData('sales.paymentmethods.cashondelivery.order_status'));
        }

        // TODO
        // if ($order->payment->method == 'moneytransfer' && core()->getConfigData('sales.paymentmethods.moneytransfer.generate_invoice')) {
            $this->invoiceRepository->create($this->prepareInvoiceData($order), core()->getConfigData('sales.paymentmethods.moneytransfer.invoice_status'), core()->getConfigData('sales.paymentmethods.moneytransfer.order_status'));
        // }
    }

    /**
     * Prepares order's invoice data for creation.
     *
     * @return array
     */
    protected function prepareInvoiceData($order)
    {
        $invoiceData = ['order_id' => $order->id];

        // TODO
        $invoiceData['invoice']['items'] = [];
        // foreach ($order->items as $item) {
        //     $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        // }

        return $invoiceData;
    }
}