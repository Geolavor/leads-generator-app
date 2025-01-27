<?php

return [
    /**
     * Sales.
     *
     * Child keys are in different package.
     *
     * Sort `1` | Shipping         | Shipping Package
     * Sort `2` | Shipping Method  | Shipping Package
     * Sort `3` | Payment Method   | Payment Package
     * Sort `4` | Order Settings   | Self
     * Sort `5` | Invoice Settings | Self
     */
    [
        'key'  => 'sales',
        'name' => 'admin::app.system.sales',
        'sort' => 5,
    ],

    /**
     * Order settings.
     */
    [
        'key'  => 'sales.orderSettings',
        'name' => 'admin::app.system.order-settings',
        'sort' => 4,
    ], [
        'key'    => 'sales.orderSettings.order_number',
        'name'   => 'admin::app.system.orderNumber',
        'sort'   => 0,
        'fields' => [
            [
                'name'          => 'order_number_prefix',
                'title'         => 'admin::app.system.order-number-prefix',
                'type'          => 'text',
                'validation'    => false,
                'channel_based' => true,
                'locale_based'  => true,
            ],
            [
                'name'          => 'order_number_length',
                'title'         => 'admin::app.system.order-number-length',
                'type'          => 'text',
                'validation'    => 'numeric',
                'channel_based' => true,
                'locale_based'  => true,
            ],
            [
                'name'          => 'order_number_suffix',
                'title'         => 'admin::app.system.order-number-suffix',
                'type'          => 'text',
                'validation'    => false,
                'channel_based' => true,
                'locale_based'  => true,
            ],
            [
                'name'          => 'order_number_generator_class',
                'title'         => 'admin::app.system.order-number-generator-class',
                'type'          => 'text',
                'validation'    => false,
                'channel_based' => true,
                'locale_based'  => true,
            ],
        ],
    ], [
        'key'    => 'sales.orderSettings.minimum-order',
        'name'   => 'admin::app.system.minimum-order',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'minimum_order_amount',
                'title'         => 'admin::app.system.minimum-order-amount',
                'type'          => 'text',
                'validation'    => 'decimal',
                'channel_based' => true,
                'locale_based'  => true,
            ],
        ],
    ],

    /**
     * Invoice settings.
     */
    [
        'key'  => 'sales.invoice_setttings',
        'name' => 'admin::app.system.invoice-settings',
        'sort' => 5,
    ], [
        'key'    => 'sales.invoice_setttings.invoice_number',
        'name'   => 'admin::app.system.invoice-number',
        'sort'   => 0,
        'fields' => [
            [
                'name'          => 'invoice_number_prefix',
                'title'         => 'admin::app.system.invoice-number-prefix',
                'type'          => 'text',
                'validation'    => false,
                'channel_based' => true,
                'locale_based'  => true,
            ],
            [
                'name'          => 'invoice_number_length',
                'title'         => 'admin::app.system.invoice-number-length',
                'type'          => 'text',
                'validation'    => 'numeric',
                'channel_based' => true,
                'locale_based'  => true,
            ],
            [
                'name'          => 'invoice_number_suffix',
                'title'         => 'admin::app.system.invoice-number-suffix',
                'type'          => 'text',
                'validation'    => false,
                'channel_based' => true,
                'locale_based'  => true,
            ],
            [
                'name'          => 'invoice_number_generator_class',
                'title'         => 'admin::app.system.invoice-number-generator-class',
                'type'          => 'text',
                'validation'    => false,
                'channel_based' => true,
                'locale_based'  => true,
            ],
        ],
    ], [
        'key'    => 'sales.invoice_setttings.payment_terms',
        'name'   => 'admin::app.system.payment-terms',
        'sort'   => 1,
        'fields' => [
            [
                'name'          => 'due_duration',
                'title'         => 'admin::app.system.due-duration',
                'type'          => 'text',
                'validation'    => 'numeric',
                'channel_based' => true,
            ],
        ],
    ], [
        'key'    => 'sales.invoice_setttings.invoice_slip_design',
        'name'   => 'admin::app.system.invoice-slip-design',
        'sort'   => 2,
        'fields' => [
            [
                'name'          => 'logo',
                'title'         => 'admin::app.system.logo',
                'type'          => 'image',
                'validation'    => 'mimes:bmp,jpeg,jpg,png,webp',
                'channel_based' => true,
            ],
        ],
    ], [
        'key'    => 'sales.invoice_setttings.invoice_reminders',
        'name'   => 'admin::app.system.invoice-reminders',
        'sort'   => 2,
        'fields' => [
            [
                'name'          => 'reminders_limit',
                'title'         => 'admin::app.system.maximum-limit-of-reminders',
                'type'          => 'text',
                'validation'    => 'numeric',
                'channel_based' => true,
            ],
            [
                'name'    => 'interval_between_reminders',
                'title'   => 'admin::app.system.interval-between-reminders',
                'type'    => 'select',
                'options' => [
                    [
                        'title' => '1 day',
                        'value' => 'P1D',
                    ], [
                        'title' => '2 days',
                        'value' => 'P2D',
                    ], [
                        'title' => '3 days',
                        'value' => 'P3D',
                    ], [
                        'title' => '4 days',
                        'value' => 'P4D',
                    ], [
                        'title' => '5 days',
                        'value' => 'P4D',
                    ], [
                        'title' => '6 days',
                        'value' => 'P4D',
                    ], [
                        'title' => '7 days',
                        'value' => 'P4D',
                    ], [
                        'title' => '2 weeks',
                        'value' => 'P2W',
                    ], [
                        'title' => '3 weeks',
                        'value' => 'P3W',
                    ], [
                        'title' => '4 weeks',
                        'value' => 'P4W',
                    ],
                ],
            ],
        ],
    ],
];
