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

                            </ul>

                            <div class="actions">

                                <!-- Buttons go here -->

                            </div>

                            <div class="step-content">

                                <div class="step-pane active sample-pane" data-step="1">

                                    <!-- step 1 -->

                                    <h4>Login or Create Account</h4>

                                    <div class="alert alert-info">
                                        <p>It is recommended that you login or create an account with us. By creating an
                                            account, you will be able to check the status for your orders.</p>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="panel panel-primary">

                                            <div class="panel-heading">

                                                <h1 class="panel-title"><i class="fa fa-user"></i> Create Account</h1>

                                            </div>

                                            <div class="panel-body">


                                                {!! Form::open(['url' => 'store/create-account','id' => 'create_account']) !!}

                                                <div class="form-group">

                                                    {!! Form::label('name','Name', ['class' => 'label-control']) !!}
                                                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name'])
                                                    !!}

                                                </div>

                                                <div class="form-group">

                                                    {!! Form::label('email','Email Address', ['class' => 'label-control']) !!}
                                                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email'])
                                                    !!}

                                                </div>

                                                <div class="form-group">

                                                    {!! Form::label('password','Password', ['class' => 'label-control']) !!}
                                                    {!! Form::password('password', ['class' => 'form-control', 'id' =>
                                                    'password']) !!}

                                                </div>

                                                <div class="form-group">

                                                    {!! Form::label('confirm_password','Confirm Password', ['class' =>
                                                    'label-control']) !!}
                                                    {!! Form::password('confirm_password', ['class' => 'form-control', 'id' =>
                                                    'password_confirmation']) !!}

                                                </div>

                                                <div class="form-group">

                                                    {!! app('captcha')->display(); !!}

                                                </div>

                                                <div class="form-group">

                                                    {!! Form::button( 'Proceed to Check Out', ['class' => 'btn btn-primary',
                                                    'ng-click' => 'create_account()']) !!}

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


                                                {!! Form::open(['url' => '#','id' => 'account_login']) !!}


                                                <div class="form-group">

                                                    {!! Form::label('email','Email Address', ['class' => 'label-control']) !!}
                                                    {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email'])
                                                    !!}

                                                </div>


                                                <div class="form-group">

                                                    {!! Form::label('password','Password', ['class' => 'label-control']) !!}
                                                    {!! Form::password('password', ['class' => 'form-control', 'id' =>
                                                    'password']) !!}

                                                </div>
                                                <div class="form-group">
                                                    <p><a href="#" target="_self">Forgot your password?</a></p>
                                                    <button type="button" id="loginBtn" class="btn btn-primary">Login</button>
                                                    <button type="button" id="guestCheckoutBtn" class="btn btn-primary">Checkout
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
