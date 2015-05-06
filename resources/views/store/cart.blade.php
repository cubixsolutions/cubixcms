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


                        <div ng-if="cart_count == 0">
                            <h1>Shopping Cart is Empty</h1>
                            <p>You have no items in your shopping cart.</p>
                            <p>Click <a href="#">here</a> to continue shopping.</p>
                        </div>

                        <table class="table table-responsive table-condensed" ng-if="cart_count > 0">

                            <thead>

                                <tr>

                                    <th colspan="3">Product Name</th><th>Unit Price</th><th>Quantity</th><th>Subtotal</th><th>Actions</th>

                                </tr>

                            </thead>
                            <tfoot>

                                <tr>
                                    <td colspan="4"><a class="btn btn-primary btn-sm">Continue Shopping</a></td><td><a class="btn btn-primary btn-sm" ng-click="update()" {{(Cart::count() > 0)?:"disabled"}}>Update Shopping Cart</a></td>
                                </tr>

                            </tfoot>
                            <tbody>

                            <tr ng-repeat="cartItem in cart">

                                <td colspan="3"><% cartItem.name %></td>
                                <td><% cartItem.price %></td>
                                <td>

                                    <% cartItem.qty %>

                                </td>

                                <td><% cartItem.subtotal %></td>
                                <td>

                                    <input type="button" class="btn btn-danger btn-xs" ng-click="remove(cartItem.rowid, $index)" value="Remove" />

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

@stop
