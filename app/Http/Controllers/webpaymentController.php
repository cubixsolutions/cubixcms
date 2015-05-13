<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\WebPayments;

class webpaymentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($token)
	{

        $webpayment = new WebPayments;
        $form = $webpayment->where('token', '=', $token)->firstOrFail();

        dd($form);

        if(view()->exists('forms.webpayment')) {

            return view('forms.webpayment');

        } else {

            abort('404');

        }

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		/*
		 * Creates Charge for x amount of dollars
		 */

        User::setStripeKey('sk_test_QkkR4Mq7x4VcMl3Tw9sf2P0A');

        $token = $request->input('stripeToken');

        $user = new User;

        $customer = $user->find(1);

        if(!$customer->charge(1000, [
            'source'    => $token,
            'receipt_email' => $customer->email
        ])) {

            echo "error in charging customer";

        } else {

            dd($customer);

        }

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
