@extends('layouts.default')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-8">

                <!-- Blog Posts -->
                
                @if($post_count > 0)

                    @foreach($posts as $row)

                        <div class="panel panel-default">

                    	<div class="panel-body">

                            <h1>{{$row->blog_title}}</h1>

                            <p>{{$row->blog_text}}</p>

                        </div>

                        <div class="panel-footer">

                            <i class="fa fa-clock-o"></i> {{$row->created_at->subMinutes(2)->diffForHumans()}}

                        </div>

                    </div>
                    @endforeach

                @else

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            Not Found!

                        </div>

                        <div class="panel-body">

                            <h1>No Blog Entry Found!</h1>

                        </div>

                    </div>

                @endif


            </div>

            <div class="col-md-4">

                <!-- Sidebar -->



            </div>


        </div>


    </div>

@stop