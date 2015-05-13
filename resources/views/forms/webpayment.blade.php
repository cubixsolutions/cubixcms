@extends('../layouts.default')

@section('head')

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

@stop

@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">

                    Web Payment Form

                </div>

            	<div class="panel-body" ng-controller="webpaymentController">


                      <form action="webpayment/create" method="post" id="webpayment_form">

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
                                  <input type="text" class="form-control" id="name" />

                              </div>

                              <div class="form-group">

                                  <label for="billing_address" class="label-control">

                                        Billing Address 1:

                                  </label>

                                  <input type="text" class="form-control" id="billing_address" placeholder="Street address as shown on billing statement" />

                              </div>

                              <div class="form-group">

                                  <label for="billing_address_2" class="label-control">

                                    Billing Address 2:

                                  </label>

                                  <input type="text" class="form-control" id="billing_address_2" placeholder="Apartment or Suite #"/>

                              </div>

                              <div class="form-group">

                                  <label for="city" class="label-control">

                                      City:

                                  </label>

                                  <input type="text" class="form-control" id="city" />

                              </div>

                              <div class="form-group">

                                  <label for="state" class="label-control">

                                      State:

                                  </label>

                                  <input type="text" class="form-control" id="state" />


                              </div>

                              <div class="form-group">

                                  <label for="zip_code" class="label-control">

                                      Zip Code:

                                  </label>

                                  <input type="text" class="form-control" id="zip_code" />


                              </div>

                          </div>

                          <div class="col-md-6">

                              <!-- TODO: Credit Card Fields go here -->
                              <div class="form-group">

                                  <label for="credit_card" class="label-control">

                                      Credit Card Number (No Dashes):

                                  </label>

                                  <input type="text" class="form-control" id="credit_card" />

                              </div>

                              <div class="form-group">

                                  <div class="row">
                                  <div class="col-md-6">

                                      <label for="exp-month" class="label-control">Month:</label>
                                      <input type="text" class="form-control" id="exp-month" />

                                  </div>

                                  <div class="col-md-6">

                                      <label for="exp-year" class="label-control">Year:</label>
                                      <input type="text" class="form-control" id="exp-year" />

                                  </div>
                                  </div>

                              </div>

                              <div class="form-group">

                                  <label for="cvc" class="label-control">CVC:</label>
                                  <input type="text" class="form-control" id="cvc" />

                              </div>

                              <div class="form-group">

                                  <label for="amount" class="label-control">

                                      Amount:

                                  </label>

                                  <input type="text" class="form-control" id="amount" />

                              </div>

                              <div class="form-group">

                                  <input type="button" class="btn btn-primary btn-lg" ng-click="paynow()" value="Pay Now"/>
                                  <input type="hidden" name="_token" value="{{csrf_token()}}" />

                              </div>

                          </div>

                          </div>

                      </form>

                </div>

            </div>



        </div>

    </div>



</div>




@stop
