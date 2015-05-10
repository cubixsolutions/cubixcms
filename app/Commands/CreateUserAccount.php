<?php  namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use App\Http\Requests;
use App\User;
use Mail,Hash;

class CreateUserAccount extends Command implements SelfHandling {

    public $name, $email, $password;

    public function __construct($name,$email,$password)
    {

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;

    }

    public function handle()
    {

        $user = New User;

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Hash::make($this->password);

        $user->save();

        $name = $this->name;
        $email = $this->email;

        Mail::send('emails.welcome', array('name' => $this->name), function ($message) use ($name, $email) {

            $message->to($email,$name)->subject('Welcome!');


        });

    }

}