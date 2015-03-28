@extends("../layouts.default")

@section("content")

<div class="container">
	
	<div class="row">

		<div class="col-md-12">

			<div class="panel panel-default store_panel">
				
				<div class="panel-heading">
					
					<div class="panel-title">Categories</div>

				</div>

				<div class="panel-body">
					
					<div class="alert alert-info">
					
						<p>Thank you for visiting our store and we hope you find all you are looking for.</p>

					</div>

					<div class="row">

					@foreach($categories as $category)

							<div class="col-md-4">

								<div class="panel panel-default store-panel data-mh="category-panel">
									<div class="panel-body">
                                        <div class="thumbnail store-panel noborder">

                                            <img src="/_assets/store/{{$category->image}}" width="150" height="150" alt="{{$category->category}}" />
                                            <div class="caption">

                                                <h3>{{$category->category}}</h3>
                                                <p>{{$category->description}}</p>

                                            </div>

                                        </div>

                                        <a href="/store/category/{{$category->slug}}" target="_self" class="btn btn-primary">Shop</a>

									</div>

								</div>
							
							</div>

					@endforeach

				</div>

				</div>

			</div>
		


		</div>

	</div>


</div>

@stop
