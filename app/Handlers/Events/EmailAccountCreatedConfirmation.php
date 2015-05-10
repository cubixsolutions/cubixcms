<?php namespace App\Handlers\Events;

use App\Events\AccountCreated;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class EmailAccountCreatedConfirmation {

	/**
	 * Create the event handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  AccountCreated  $event
	 * @return void
	 */
	public function handle(AccountCreated $event)
	{
		//
	}

}
