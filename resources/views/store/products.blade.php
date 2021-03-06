@extends("../layouts.default")

@section("head")

<meta name="_token" content="{{ csrf_token() }}" />
	
@stop

@section("content")

<div class="container">
	
	<div class="row">

		<div class="col-md-12">

			<div class="panel panel-default store_panel">

				<div class="panel-heading">

					<strong><a href="#" target="_self" back-button><span class="fa fa-arrow-circle-left"></span> Section: </strong> {{$category}}</a>

				</div>

                <div class="panel-body">

                    <div class="row">

                        @if($products->count() > 0)

                            @foreach($products as $product)

                                <div class="col-md-4">

                                    <div class="panel panel-default store-panel data-mh="product-panel">

                                        <div class="panel-body">

                                            <div class="thumbnail noborder">

                                                <img src="/_assets/store/{{$product->image}}" alt="{{$product->product}}" width="150" height="150" />

                                                <div class="caption">

                                                    <p><a href="/store/view/{{$product->id}}" target="_self"><h3>{{$product->product}}</h3></a></p>
                                                    <p>SKU: <code>{{$product->sku}}</code></p>

                                                </div>

                                            </div>


                                        </div>

                                        <div class="panel-footer">

                                            @if($product->price != "")
                                                <p><span class="product_cost">${{$product->price}}</span></p>
                                                @if($product->type->product_type == "Product")

                                                    <!-- addToCart Form -->

                                                    {!! Form::open(['url'	=> '/store/add-cart','id'	=> 'addToCart_form']) !!}

                                                    <!-- addCartLink Button -->
                                                    <div class="form-group">

                                                        <a class="btn btn-success" ng-click="update({{$product->id}})"><i class="fa fa-shopping-cart"> </i> Add to Cart</a>
                                                        <a class="btn btn-primary" title="{{$product->product}}" product_id="{{$product->id}}" data-placement="top" data-toggle="popover" data-content="{{$product->description}}"><i class="fa fa-exclamation-circle"></i> More Info</a>

                                                    </div>

                                                    {!! Form::close() !!}

                                                @else

                                                    <a href="/services/book-technician" class="btn btn-primary panel-block">Book Technician</a>

                                                @endif

                                            @else

                                                <p><span class="product_cost">Call</span></p>
                                                <a href="/contact-us" target="_self" class="btn btn-info btn-block">Call us for a free consultation</a>

                                            @endif


                                        </div>

                                    </div>


                                </div>

                            @endforeach
                        @else

                            <div class="col-md-12">

                                <h1>There are no products in this category yet.  Please try back later.</h1>

                            </div>
                        @endif

                    </div>

                </div>

                @if($products->hasMorePages())

                    <div class="panel-footer">

					<!-- Renders pagination -->

                    {!! $products->render() !!}

				    </div>

                @endif

			</div>


		</div>

		
	</div>


</div>

@stop

@section('footer')

    <script src="/_scripts/plugins/threedots/jquery.threedots.js"></script>

@stop