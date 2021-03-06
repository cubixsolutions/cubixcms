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


                        <div ng-cloak ng-if="cart_count == 0">
                            <h1>Shopping Cart is Empty</h1>
                            <p>You have no items in your shopping cart.</p>
                            <p>Click <a href="{{action('storeController@index')}}">here</a> to continue shopping.</p>
                        </div>

                    <div class="table-responsive" ng-cloak ng-if="cart_count > 0">
                    <table class="table table-condensed" ng-cloak ng-if="cart_count > 0">

                            <thead>

                                <tr>

                                    <th colspan="3">Product Name</th><th>Unit Price</th><th>Quantity</th><th>Subtotal</th><th>Actions</th>

                                </tr>

                            </thead>
                            <tfoot>

                                <tr>
                                    <td colspan="4"><a href="{{action('storeController@index')}}" class="btn btn-primary btn-sm">Continue Shopping</a></td><td><a href="{{action('storeController@checkout')}}" class="btn btn-primary btn-sm" {{(Cart::count() > 0)?:"disabled"}}>Checkout</a></td>
                                </tr>

                            </tfoot>
                            <tbody>

                            <tr ng-cloak ng-repeat="cartItem in cart">

                                <td colspan="3"><% cartItem.name %></td>
                                <td><% cartItem.price %></td>
                                <td>

                                    <div class="badge" style="vertical-align: middle;"><% cartItem.qty %></div>

                                    <a href="#" class="btn btn-success btn-xs" data-toggle="tooltip" title="decreases quantity" ng-if="cartItem.name"  ng-click="changeQty(cartItem.qty = cartItem.qty - 1,cartItem.rowid)"><i class="fa fa-minus"></i></a>
                                    <a href="#" class="btn btn-success btn-xs" data-toggle="tooltip" title="increases quantity" ng-if="cartItem.name" ng-click="changeQty(cartItem.qty = cartItem.qty + 1,cartItem.rowid)"><i class="fa fa-plus"></i></a>

                                </td>

                                <td><% cartItem.subtotal %></td>
                                <td>

                                    <input type="button" class="btn btn-danger btn-xs" ng-if="cartItem.name" ng-click="changeQty(0,cartItem.rowid)" value="Remove" />

                                </td>

                            </tr>

                            <tr style="border-top: 1px solid #eee;">

                                <td colspan="4"></td>
                                <td align="right">Total:</td>
                                <td><strong><% cart_total %></strong></td>
                            </tr>
                            </tbody>

                        </table>
                        </div>

                </div>

            </div>

        </div>

	</div>

</div>

@stop
