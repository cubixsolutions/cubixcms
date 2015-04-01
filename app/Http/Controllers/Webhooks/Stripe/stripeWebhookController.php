<?php namespace App\Http\Controllers\Webhooks\Stripe;

use App\Http\Controllers\Controller;

class stripeWebhookController extends Laravel\Cashier\WebhookController {

    public function handleInvoicePaymentSucceeded($payload)
    {
        //Handle the event
    }



}