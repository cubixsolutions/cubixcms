<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use App\Http\Requests;
use App\User;
use Mail,Hash;

class CreateUserAccount extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */

    public $name, $email, $password;

	public function __construct($name,$email,$password)
	{
		$this->name = $name;
        $this->email = $email;
        $this->password = $password;

	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */

	public function handle()
	{
		$user = new User;

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);

        $user->save();

	}

}
