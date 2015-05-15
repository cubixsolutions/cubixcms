@extends('../layouts.default')

@section('head')

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

@stop

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="wizard" data-initialize="wizard" data-restrict="previous" id="webpayment_wizard"
                     ng-controller="webpaymentController">

                    <ul class="steps">

                        <li data-step="1" data-name="welcome" class="active"><span class="badge">1</span>Welcome<span
                                    class="chevron"></span></li>
                        <li data-step="2" data-name="payment"><span class="badge">2</span>Payment<span
                                    class="chevron"></span></li>
                        <li data-step="3" data-name="completed"><span class="badge">3</span>Completed<span
                                    class="chevron"></span></li>

                    </ul>

                    <div class="step-content">

                        <div class="step-pane" data-step="1">

                            <div class="row">

                                <div class="col-md-12">

                                    <p>Welcome {{$name}},</p>

                                    <p>You have been sent to this web payment form in order to pay a bill to {{$title}}
                                        in the amount of ${{$amount}}.</p>

                                    <p>This web payment form is completely secure and in no way does your credit card
                                        information touch our servers.</p>

                                    <p>Click the next button to proceed.</p>
                                    <a class="btn btn-primary" ng-click="next()">Next</a>

                                </div>

                            </div>

                        </div>

                        <div class="step-pane" data-step="2">

                            <div class="panel panel-default">

                                <div class="panel-heading">

                                    Web Payment Form for {{$name}}

                                </div>

                                <div class="panel-body" ng-controller="webpaymentController">


                                    <form action="/webpayment/create" method="post" id="webpayment_form">

                                        @if($is_customer == true)
                                        <div class="row">

                                            <div class="col-md-12">



                                                    <div class="alert alert-info">

                                                        <strong>Important!</strong>

                                                        <p>You will be billed in the amount of ${{$amount}} from your
                                                            credit card ending in {{$last_four}}. If you would like to
                                                            use a different card or would like to change the card we
                                                            have on file please contact customer support.</p>

                                                    </div>

                                                    <div class="alert alert-danger payment-errors">

                                                        <strong>Error!</strong>
                                                    </div>
                                            </div>

                                        </div>

                                            <div class="row">

                                                <div class="col-md-4">

                                                    <div class="form-group">

                                                        <label for="amount" class="label-control">Amount:</label>
                                                        <div class="input-group">

                                                            <span class="input-group-addon">$</span>
                                                            <input type="text" class="form-control" name="amount" id="amount" value="{{$amount}}" disabled/>

                                                        </div>
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                        <input type="hidden" name="webpayments_token"
                                                               value="{{$webpayments_token}}"/>

                                                    </div>

                                                    <input type="submit" class="btn btn-primary" ng-click="paynow()" value="Pay Now" />
                                                </div>

                                            </div>

                                        @elseif($is_customer == false)

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="alert alert-danger payment-errors">

                                                        <strong>Error!</strong>

                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row">

                                            <div class="col-md-6">

                                                <!-- TODO: Address Fields go here -->
                                                <div class="form-group">

                                                    <label for="name" class="label-control">
                                                        Name as Shown on Credit Card:
                                                    </label>
                                                    <input type="text" class="form-control" id="name"/>

                                                </div>

                                                <div class="form-group">

                                                    <label for="address_line1" class="label-control">

                                                        Address line 1:

                                                    </label>

                                                    <input type="text" class="form-control" id="address_line1"
                                                           placeholder="Street address as shown on billing statement"/>

                                                </div>

                                                <div class="form-group">

                                                    <label for="address_line2" class="label-control">

                                                        Address line 2:

                                                    </label>

                                                    <input type="text" class="form-control" id="address_line2"
                                                           placeholder="Apartment or Suite #"/>

                                                </div>

                                                <div class="form-group">

                                                    <label for="city" class="label-control">

                                                        City:

                                                    </label>

                                                    <input type="text" class="form-control" id="city"/>

                                                </div>

                                                <div class="form-group">

                                                    <label for="state" class="label-control">

                                                        State:

                                                    </label>

                                                    <input type="text" class="form-control" id="state"/>


                                                </div>

                                                <div class="form-group">

                                                    <label for="zip_code" class="label-control">

                                                        Zip Code:

                                                    </label>

                                                    <input type="text" class="form-control" id="zip_code"/>


                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <!-- TODO: Credit Card Fields go here -->
                                                <div class="form-group has-error has-feedback">

                                                    <label for="credit_card" class="label-control">

                                                        Credit Card Number (No Dashes) <span class="ccbrand"></span>:

                                                    </label>

                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                                        <input type="text" class="form-control" cbx-credit-card-validation id="credit_card"/>
                                                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <label for="exp-month" class="label-control">Month:</label>
                                                            <select class="form-control" id="exp-month">

                                                                <?php $month = array('1' => 'January',
                                                                                  '2' => 'February',
                                                                                  '3' => 'March',
                                                                                  '4' => 'April',
                                                                                  '5' => 'May',
                                                                                  '6' => 'June',
                                                                                  '7' => 'July',
                                                                                  '8' => 'August',
                                                                                  '9' => 'September',
                                                                                  '10' => 'October',
                                                                                  '11' => 'November',
                                                                                  '12' => 'December');

                                                                foreach($month as $key => $value) {


                                                                    echo "<option value='" . $key . "'>$value</option>";

                                                                }?>



                                                            </select>

                                                        </div>

                                                        <div class="col-md-6">

                                                            <label for="exp-year" class="label-control">Year:</label>
                                                            <select class="form-control" id="exp-year">

                                                            <?php

                                                                    for($i = 0; $i < 10; $i++) {

                                                                        echo "<option value='" . Carbon::now()->addYear($i)->year . "'>" . Carbon::now()->addYear($i)->year . "</option>";

                                                                    }

                                                            ?>
                                                            </select>

                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="form-group has-error has-feedback">

                                                    <label for="cvc" class="label-control">CVC:</label>

                                                    <div class="input-group">

                                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                        <input type="text" class="form-control" cbx-cvc-validation id="cvc"/>
                                                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label for="amount" class="label-control">

                                                        Amount:

                                                    </label>

                                                    <div class="input-group">

                                                        <span class="input-group-addon">$</span>
                                                        <input type="text" class="form-control" name="amount" id="amount" value="{{$amount}}" readonly/>

                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <input type="button" id="paybutton" class="btn btn-primary btn-lg"
                                                           ng-click="paynow()" value="Pay Now"/>
                                                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
                                                    <input type="hidden" name="webpayments_token" id="webpayments_token"
                                                           value="{{$webpayments_token}}"/>

                                                </div>

                                            </div>

                                        </div>
                                        @endif

                                    </form>

                                </div>

                            </div>

                        </div>

                        <div class="step-pane" data-step="3">

                            <div class="row">

                                <div class="col-md-12">

                                    <h4>Thank you for your payment</h4>
                                    <p></p>

                                </div>

                            </div>


                        </div>

                    </div>
                </div>


            </div>

        </div>


    </div>




@stop
