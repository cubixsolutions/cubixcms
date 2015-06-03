@extends('../layouts/default')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Web Payment Access
                </div>
            	<div class="panel-body">
            	   <div class="alert alert-info">

            	   	<strong>Important!</strong> Please enter the web payment identifier that you received in the email we sent you in the input field below.

              	   </div>

                    <div class="row">

                        <div class="col-md-6">

                            <form action="<% session.url %>" id="webpayment_access" method="get" ng-controller="webpaymentController">

                                <div class="form-group">

                                    <label for="webpayment_access" class="label-control">Web Payment Identifier:</label>
                                    <input type="text" class="form-control" ng-model="session.url"/>
                                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}" />

                                </div>

                                <div class="form-group">

                                    <input type="submit" class="btn btn-primary" ng-click="webpaymentSubmit()" value="Submit" />

                                </div>

                            </form>


                        </div>

                    </div>

            	</div>
            </div>


        </div>


    </div>



</div>

@stop