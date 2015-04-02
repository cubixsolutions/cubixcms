<?php namespace App\Http\Controllers\Webhooks;

use Laravel\Cashier\WebhookController;
use App\Http\Requests\Request;
class StripeWebhookController extends WebhookController {

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    public function handleWebhook()
    {

        $payload = $this->getJsonPayload();

        dd($payload);

    }

    protected function getJsonPayload()
    {
        return (array) json_decode(Request::getContent(), true);
    }

}