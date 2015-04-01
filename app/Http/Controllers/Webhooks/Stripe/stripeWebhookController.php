<?php namespace Laravel\Cashier\WebhookController;

use App\Http\Controllers\Controller;

class stripeWebhookController extends Controller {

    public function handleInvoicePaymentSucceeded($payload)
    {
        //Handle the event
    }



}