@extends('../layouts.default')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="panel panel-default">

                    <div class="panel-heading">

                        <div class="panel-title">

                            Checkout

                        </div>

                    </div>

                    <div class="panel-body">

                        <div class="wizard" data-initialize="wizard" id="checkout_wizard">

                            <ul class="steps">

                                <li data-step="1" data-name="account-login" class="active"><span class="badge">1</span>Account Login<span class="chevron"></span></li>
                                <li data-step="2" data-name="checkout"><span class="badge">2</span>Checkout<span class="chevron"></span></li>
                                <li data-step="3" data-name="Billing"><span class="badge">3</span>Billing<span class="chevron"></span></li>
                                <li data-step="4" data-name="Complete"><span class="badge">4</span>Complete<span class="chevron"></span></li>

                            </ul>

                            <div class="actions">

                                <!-- Buttons go here -->

                            </div>

                            <div class="step-content">

                                <div class="step-pane active sample-pane" data-step="1">

                                    <!-- step 1 -->

                                    <h4>Login or Create Account</h4>

                                    <div class="alert alert-info">
                                        <p>In order to complete the order you must create an account with us.  If you do not wish to create an account at this time you may checkout as guest
                                         and an account will be created for you.  For more information on why you should have an account, please visit the member's page.</p>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="panel panel-primary">

                                            <div class="panel-heading">

                                                <h1 class="panel-title"><i class="fa fa-user"></i> Create Account</h1>

                                            </div>

                                            <div class="panel-body">

                                                <div class="alert alert-danger" ng-cloak ng-if="session.error">

                                                	<strong>Error!</strong><br />
                                                    <div ng-repeat="(key, value) in session.error">

                                                        <% value %>

                                                    </div>

                                                </div>

                                                <form name="createAccountForm" novalidate rc-submit="create_account()">

                                                <div class="form-group" ng-class="{'has-error': rc.createAccountForm.needsAttention(createAccountForm.name)}">

                                                    <label class="label-control">Name</label>
                                                    <input type="text" class="form-control" name="name" required ng-model="session.name" />
                                                    <span class="help-block" ng-show="createAccountForm.name.$error.required">Required</span>

                                                </div>

                                                <div class="form-group" ng-class="{'has-error': rc.createAccountForm.needsAttention(createAccountForm.email)}">

                                                    <label class="label-control">Email</label>
                                                    <input type="text" class="form-control" name="email" required ng-model="session.email" />
                                                    <span class="help-block" ng-show="createAccountForm.email.$error.required">Required</span>

                                                </div>

                                                <div class="form-group" ng-class="{'has-error': rc.createAccountForm.needsAttention(createAccountForm.password)}">

                                                    <label class="label-control">Password</label>
                                                    <input type="password" class="form-control" name="password" required ng-model="session.password" />
                                                    <span class="help-block" ng-show="createAccountForm.password.$error.required">Required</span>

                                                </div>

                                                <div class="form-group" ng-class="{'has-error': rc.createAccountForm.needsAttention(createdAccountForm.password_confirmation)}">

                                                    <label class="label-control">Confirm Password</label>
                                                    <input type="password" class="form-control" name="password_confirmation" required ng-model="session.password_confirmation" />
                                                    <span class="help-block" ng-show="createAccountForm.password_confirmation.$error.required">Required</span>

                                                </div>

                                                <div class="form-group">

                                                    {!! Form::button( 'Proceed to Check Out', ['type' => 'submit','class' => 'btn btn-primary']) !!}

                                                </div>

                                                <!-- Username Form Input -->

                                                {!! Form::close() !!}

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="panel panel-primary">

                                            <div class="panel-heading">

                                                <h1 class="panel-title"><i class="fa fa-sign-in"></i> Log In</h1>

                                            </div>

                                            <div class="panel-body">

                                                <div class="alert alert-danger" ng-cloak ng-if="session.login.error">

                                                    <strong>Error!</strong><br />
                                                    <div ng-repeat="(key, value) in session.login.error">

                                                        <% value %>

                                                    </div>

                                                </div>

                                                <form name="LoginForm" novalidate rc-submit="login()">


                                                    <div class="form-group" ng-class="{'has-error': rc.LoginForm.needsAttention(LoginForm.email)}">

                                                        <label class="label-control">Email Address</label>
                                                        <input type="text" class="form-control" name="email" required ng-model="session.login.email" />
                                                        <span class="help-block" ng-show="LoginForm.email.$error.required">Required</span>

                                                    </div>


                                                    <div class="form-group" ng-class="{'has-error': rc.LoginForm.needsAttention(LoginForm.password)}">

                                                        <label class="label-control">Password</label>
                                                        <input type="password" class="form-control" name="password" required ng-model="session.login.password" />
                                                        <span class="help-block" ng-show="LoginForm.password.$error.required">Required</span>

                                                    </div>

                                                <div class="form-group">
                                                    <p><a href="#" target="_self">Forgot your password?</a></p>
                                                    <button type="submit" id="loginBtn" class="btn btn-primary">Login</button>
                                                    <button type="button" id="guestCheckoutBtn" class="btn btn-primary" ng-click="guest_checkout()">Checkout
                                                        as Guest
                                                    </button>
                                                </div>

                                                {!! Form::close() !!}


                                            </div>


                                        </div>

                                    </div>

                                </div>

                                <div class="step-pane" data-step="2">

                                    <!-- step 2 -->
                                    <div class="row">

                                        <div class="col-md-8">

                                            <div class="alert alert-info">

                                                <strong>Summary:</strong>
                                                <p>Please check your order before continueing.</p>

                                            </div>

                                        </div>

                                        <div class="col-md-4">



                                        </div>



                                    </div>

                                </div>

                                <div class="step-pane" data-step="3">

                                    <!-- step 3 -->


                                </div>

                            </div>



                        </div>

                    </div>

                </div>

            </div>

        </div>


    </div>

@stop
