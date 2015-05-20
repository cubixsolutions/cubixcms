<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\WebPayments;
use Carbon\Carbon,Omnipay,Mail;
class webpaymentController extends Controller {

	private $is_customer = false;
    private $last_four = null;
    private $invoice_id;
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($token)
	{

        $webpayment = new WebPayments;
        $form = $webpayment->where('token', '=', $token)->firstOrFail();

        if ($form->user->stripe_id != null) {

            $this->is_customer = true;
            $this->last_four = $form->user->last_four;

        } else {

            $this->is_customer = false;

        }

        if(view()->exists('forms.webpayment') && $form->active == true) {

            //dd(Carbon::now()->year);
            return view('forms.webpayment',['webpayments_token' => $token,'is_customer' => $this->is_customer, 'last_four' => $this->last_four, 'name' => $form->user->name, 'amount' => $form->amount ]);

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

        $webpayments_token = $request->input('webpayments_token');
        $token = ($request->input('stripeToken') ? $request->input('stripeToken') : null);
        $amount = $request->input('amount') * 100;
        //dd($amount);

        $webpayment = new WebPayments;
        $webpayment = $webpayment->where('token','=',$webpayments_token)->first();

        /*
         * STEP ONE -- check if user has a stripe account and if not create one
         */

        if ($webpayment->user->stripe_active != true) {

            try {
                // This creates the user account in Stripe with credit card on file.
                // The sole purpose of this is only to create an account and then the customer is charged
                // in the next try block.
                $webpayment->user->subscription('customer')->create($token, [

                    'email' => $webpayment->user->email

                ]);

            } catch(\Stripe_CardError $e) {

                $body = $e->getJsonBody();
                $err = $body['error'];

                return response()->json(['card_error'       => array('type' => $err['type'],
                                                                     'code' => $err['code'],
                                                                     'param' => $err['param'],
                                                                     'message' => $err['message'])]);

            } catch(\Stripe_Error $e) {

                $body = $e->getJsonBody();
                $err = $body['error'];
                return response()->json(['card_error'       => array('type' => $err['type'],
                    'code' => $err['code'],
                    'param' => $err['param'],
                    'message' => $err['message'])]);


            } catch (\Exception $e) {

                $err = $e->getMessage();

                return response()->json(['exception'    => $err]);

            }
        }

        /*
         * STEP TWO -- charge customer credit card
         */
        try {
            $charge = $webpayment->user->charge($amount, [

                'customer' => $webpayment->user->stripe_id,
                'description' => 'new purchase',
                'receipt_email' => $webpayment->user->email,
            ]);
        } catch(\Stripe_CardError $e) {

            $body = $e->getJsonBody();
            $err = $body['error'];

            return response()->json(['card_error'       => array('type' => $err['type'],
                                                                 'code' => $err['code'],
                                                                 'param' => $err['param'],
                                                                 'message' => $err['message'])]);
        } catch(\Stripe_Error $e) {

            $body = $e->getJsonBody();
            $err = $body['error'];
            return response()->json(['card_error'       => array('type' => $err['type'],
                'code' => $err['code'],
                'param' => $err['param'],
                'message' => $err['message'])]);


        } catch (\Exception $e) {

            $err = $e->getMessage();

            return response()->json(['exception'    => $err]);

        }

        if(!$charge) {


            return response()->json(['status' => 'unsuccessful','charge' => $charge ]);


        } else {

            $webpayment->active = false;
            $webpayment->save();

            $confirmation_code = strtoupper(substr(md5(uniqid(rand(), true)), 16, 16));
            $name = $webpayment->user->name;
            $email = $webpayment->user->email;

            // TODO:  Send email to customer

            Mail::send('emails.payment_confirmation', array('name' => $name, 'amount' => $amount), function($message) use ($name, $email)
            {

                $message->to($email, $name)->subject('Thank you for your payment');

            });


            return response()->json(['status' => 'successful', 'charge' => $charge, 'name' => $name, 'email' => $email]);

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
