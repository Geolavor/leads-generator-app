<?php

namespace LeadBrowser\Admin\Traits;

use Illuminate\Support\Facades\Mail;
use LeadBrowser\Admin\Mail\CancelOrderAdminNotification;
use LeadBrowser\Admin\Mail\CancelOrderNotification;
use LeadBrowser\Admin\Mail\DuplicateInvoiceNotification;
use LeadBrowser\Admin\Mail\NewAdminNotification;
use LeadBrowser\Admin\Mail\NewInvoiceNotification;
use LeadBrowser\Admin\Mail\NewOrderNotification;
use LeadBrowser\Admin\Mail\NewRefundNotification;
use LeadBrowser\Admin\Mail\OrderCommentNotification;

trait Mails
{
    /**
     * Send new order Mail to the customer and admin.
     *
     * @param  \LeadBrowser\Sales\Contracts\Order  $order
     * @return void
     */
    public function sendNewOrderMail($order)
    {
        $customerLocale = $this->getLocale($order);

        try {
            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-order';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new NewOrderNotification($order));
            }

            /**
             * Email to admin.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-admin';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail(config('app.locale'), new NewAdminNotification($order));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send new invoice mail to the customer.
     *
     * @param  \LeadBrowser\Sales\Contracts\Invoice  $invoice
     * @return void
     */
    public function sendNewInvoiceMail($invoice)
    {
        $customerLocale = $this->getLocale($invoice);

        try {
            if ($invoice->email_sent) {
                return;
            }

            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-invoice';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new NewInvoiceNotification($invoice));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send duplicate invoice mail to the customer.
     *
     * @param  \LeadBrowser\Sales\Contracts\Invoice  $invoice
     * @param  string  $customerEmail
     * @return void
     */
    public function sendDuplicateInvoiceMail($invoice, $customerEmail)
    {
        $customerLocale = $this->getLocale($invoice);

        try {
            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-invoice';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new DuplicateInvoiceNotification($invoice, $customerEmail));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send new refund mail to the customer.
     *
     * @param  \LeadBrowser\Sales\Contracts\Refund  $refund
     * @return void
     */
    public function sendNewRefundMail($refund)
    {
        $customerLocale = $this->getLocale($refund);

        try {
            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-refund';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new NewRefundNotification($refund));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send cancel order mail.
     *
     * @param  \LeadBrowser\Sales\Contracts\Order  $order
     * @return void
     */
    public function sendCancelOrderMail($order)
    {
        $customerLocale = $this->getLocale($order);

        try {
            /**
             * Email to customer.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.cancel-order';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail($customerLocale, new CancelOrderNotification($order));
            }

            /**
             * Email to admin.
             */
            $configKey = 'emails.general.notifications.emails.general.notifications.new-admin';

            if (core()->getConfigData($configKey)) {
                $this->prepareMail(config('app.locale'), new CancelOrderAdminNotification($order));
            }
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Send order comment mail.
     *
     * @param  \LeadBrowser\Sales\Contracts\OrderComment  $comment
     * @return void
     */
    public function sendOrderCommentMail($comment)
    {
        $customerLocale = $this->getLocale($comment);

        if (! $comment->customer_notified) {
            return;
        }

        try {
            /**
             * Email to customer.
             */
            $this->prepareMail($customerLocale, new OrderCommentNotification($comment));
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Get the locale of the customer if somehow item name changes then the english locale will pe provided.
     *
     * @param object \LeadBrowser\Sales\Contracts\Order|\LeadBrowser\Sales\Contracts\Invoice|\LeadBrowser\Sales\Contracts\Refund|\LeadBrowser\Sales\Contracts\OrderComment
     * @return string
     */
    private function getLocale($object)
    {
        if ($object instanceof \LeadBrowser\Sales\Contracts\OrderComment) {
            $object = $object->order;
        }

        $objectFirstItem = $object->items->first();

        return isset($objectFirstItem->additional['locale']) ? $objectFirstItem->additional['locale'] : 'en';
    }

    /**
     * Prepare mail.
     *
     * @return void
     */
    private function prepareMail($locale, $notification)
    {
        app()->setLocale($locale);

        Mail::queue($notification);
    }
}