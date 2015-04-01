<?php 
class stripeWebhookController extends Laravel\Cashier\WebhookController {

    public function handleInvoicePaymentSucceeded($payload)
    {
        //Handle the event
    }



}