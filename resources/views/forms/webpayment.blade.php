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


                                    <form action="/webpayment/create" method="post" name="webpaymentForm" id="webpayment_form" novalidate rc-submit="paynow()">

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

                                                    </div>

                                                    <div class="form-group">

                                                        <input type="button" id="paybutton" class="btn btn-primary btn-lg"
                                                               ng-click="paynow()" ng-model="ui.paybutton" value="<% ui.paybutton %>"/>
                                                        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"/>
                                                        <input type="hidden" name="webpayments_token" id="webpayments_token"
                                                               value="{{$webpayments_token}}"/>

                                                    </div>


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
                                                <div class="form-group has-error has-feedback">

                                                    <label for="name" class="label-control">
                                                        Name as Shown on Credit Card:
                                                    </label>
                                                    <input type="text" class="form-control" cbx-input-validation id="name"/>
                                                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>

                                                </div>

                                                <div class="form-group has-error has-feedback">

                                                    <label for="address_line1" class="label-control">

                                                        Address line 1:

                                                    </label>

                                                    <input type="text" class="form-control" cbx-input-validation id="address_line1"
                                                           placeholder="Street address as shown on billing statement"/>
                                                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>

                                                </div>

                                                <div class="form-group">

                                                    <label for="address_line2" class="label-control">

                                                        Address line 2:

                                                    </label>

                                                    <input type="text" class="form-control" id="address_line2"
                                                           placeholder="Apartment or Suite #"/>

                                                </div>

                                                <div class="form-group has-error has-feedback">

                                                    <label for="city" class="label-control">

                                                        City:

                                                    </label>

                                                    <input type="text" class="form-control" cbx-input-validation id="city"/>
                                                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>

                                                </div>

                                                <div class="form-group">

                                                    <label for="state" class="label-control">

                                                        State:

                                                    </label>

                                                    <select class="form-control" id="state">

                                                        <?php

                                                            $states = array('Please select state...' => '0',
                                                                            'Alabama' => 'AL',
                                                                            'Alaska'  => 'AK',
                                                                            'Arizona' => 'AZ',
                                                                            'Arkansas' => 'AR',
                                                                            'California' => 'CA',
                                                                            'Colorado'   => 'CO',
                                                                            'Connecticut'   => 'CT',
                                                                            'Delaware'      => 'DE',
                                                                            'Florada'       => 'FL',
                                                                            'Georgia'       => 'GA',
                                                                            'Hawaii'        => 'HI',
                                                                            'Idaho'         => 'ID',
                                                                            'Illinois'      => 'IL',
                                                                            'Indiana'       => 'IN',
                                                                            'Iowa'          => 'IA',
                                                                            'Kansas'        => 'KS',
                                                                            'Kentucky'      => 'KY',
                                                                            'Louisiana'     => 'LA',
                                                                            'Maine'         => 'ME',
                                                                            'Maryland'      => 'MD',
                                                                            'Massachusetts' => 'MA',
                                                                            'Michigan'      => 'MI',
                                                                            'Minnesota'     => 'MN',
                                                                            'Mississippi'   => 'MS',
                                                                            'Missouri'      => 'MO',
                                                                            'Montana'       => 'MT',
                                                                            'Nebraska'      => 'NE',
                                                                            'Nevada'        => 'NV',
                                                                            'New Hampshire' => 'NH',
                                                                            'New Jersey'    => 'NJ',
                                                                            'New Mexico'    => 'NM',
                                                                            'New York'      => 'NY',
                                                                            'North Carolina' => 'NC',
                                                                            'North Dakota'  => 'ND',
                                                                            'Ohio'          => 'OH',
                                                                            'Oklahoma'      => 'OK',
                                                                            'Oregon'        => 'OR',
                                                                            'Pennsylvania'  => 'PA',
                                                                            'Rhode Island'  => 'RI',
                                                                            'South Carolina' => 'SC',
                                                                            'South Dakota'  => 'SD',
                                                                            'Tennessee'     => 'TN',
                                                                            'Texas'         => 'TX',
                                                                            'Utah'          => 'UT',
                                                                            'Vermont'       => 'VT',
                                                                            'Virginia'      => 'VA',
                                                                            'Washington'    => 'WA',
                                                                            'West Virgina'  => 'WV',
                                                                            'Wisconsin'     => 'WI',
                                                                            'Wyoming'       => 'WY');

                                                            foreach($states as $key => $value) {

                                                                echo "<option value='$value'>$key</option>";

                                                            }

                                                        ?>

                                                    </select>

                                                </div>

                                                <div class="form-group has-error has-feedback">

                                                    <label for="zip_code" class="label-control">

                                                        Zip Code:

                                                    </label>

                                                    <input type="text" class="form-control" pattern="[0-9]*" maxlength="5" required cbx-input-validation id="zip_code"/>
                                                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>

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
                                                           ng-click="paynow()" ng-model="ui.paybutton" value="<% ui.paybutton %>"/>
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

                                    <h4>Thank you for your payment.  We appreciate you're business.</h4>
                                    <p>You will see a charge on your billing statement from CUBIX-SOLUTIONS.COM in the amount of ${{$amount}}.</p>
                                    <p>We have sent an email to <% session.email %> confirming you're payment.</p>
                                    <div class="alert alert-warning">

                                    	<strong>Important</strong>
                                        <p>If you do not receive a confirmation email from us, please check your spam, bulk or junk mail folders.  If you find
                                        the email there, it was diverted by your ISP, your spam-blocking software or by filters.</p>

                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>
                </div>


            </div>

        </div>


    </div>




@stop
