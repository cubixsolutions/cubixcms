<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenConfirmationCode extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate-confirmation';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generates a 16bit confirmation code for emails.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
        $random_hash = substr(md5(uniqid(rand(), true)), 16, 16);

        $this->info($random_hash);

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */

}
