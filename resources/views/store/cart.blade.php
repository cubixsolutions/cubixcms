@extends('../layouts.default')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">

                    <div class="panel-title">

                        Shopping Cart

                    </div>

                </div>

                <div class="panel-body">


                        <table class="table table-responsive table-condensed">

                            <thead>

                                <tr>

                                    <th>Product Name</th><th>Unit Price</th><th>Quantity</th><th>Subtotal</th>

                                </tr>

                            </thead>
                            <tfoot>

                                <tr>
                                    <td colspan="3"><a class="btn btn-primary btn-sm">Continue Shopping</a></td><td><a class="btn btn-primary btn-sm" {{(Cart::count() > 0)?:"disabled"}}>Update Shopping Cart</a></td>
                                </tr>
                            </tfoot>
                            <tbody>

                            @if(Cart::count() > 0)
                                @foreach($cart as $row)

                                    <tr>

                                        <td>$row->product</td>
                                        <td>$row->qty</td>
                                        <td>$row->price</td>

                                    </tr>

                                @endforeach
                            @else

                                <td><i>Cart is Empty</i></td>

                            @endif

                            </tbody>

                        </table>



                </div>

            </div>

        </div>

	</div>

</div>

@stop
