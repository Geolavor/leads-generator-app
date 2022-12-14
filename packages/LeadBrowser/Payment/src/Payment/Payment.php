<?php

namespace LeadBrowser\Payment\Payment;

abstract class Payment
{
    /**
     * Checks if payment method is available
     *
     * @return array
     */
    public function isAvailable()
    {
        return $this->getConfigData('active');
    }

    /**
     * Returns payment method code
     *
     * @return array
     */
    public function getCode()
    {
        if (empty($this->code)) {
            // throw exception
        }

        return $this->code;
    }

    /**
     * Returns payment method title
     *
     * @return array
     */
    public function getTitle()
    {
        return $this->getConfigData('title');
    }

    /**
     * Returns payment method description
     *
     * @return array
     */
    public function getDescription()
    {
        return $this->getConfigData('description');
    }

    /**
     * Retrieve information from payment configuration
     *
     * @param  string  $field
     * @param  int|string|null  $channelId
     * @return mixed
     */
    public function getConfigData($field)
    {
        return core()->getConfigData('sales.paymentmethods.' . $this->getCode() . '.' . $field);
    }

    abstract public function getRedirectUrl();

    /**
     * Returns payment method sort order
     *
     * @return int
     */
    public function getSortOrder()
    {
        return $this->getConfigData('sort');
    }

    /**
     * Returns payment method additional information
     *
     * @return array
     */
    public function getAdditionalDetails()
    {
        if (! $this->getConfigData('instructions')
            || $this->getConfigData('instructions') == ''
        ) {
            return [];
        }

        return [
            'title' => trans('admin::app.system.instructions'),
            'value' => $this->getConfigData('instructions'),
        ];
    }
}