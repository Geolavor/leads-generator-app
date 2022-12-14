<?php
    use LeadBrowser\Payment\Payment;
    
    if (! function_exists('payment')) {
        function payment()
        {
            return new Payment;
        }
    }
