@extends('layouts.default')

@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <h1>Welcome to Cubix Solutions</h1>

                <p style="color: #ffffff">We are a family-owned company based in New Mexico who has a love for everything computers which include PC Repair, Networking, Web Development, Brand Development, Search Engine Optimization (SEO), Web Hosting, and much more.</p>
                <p style="color: #ffffff">Our founder, Sean Pollock, has extensive experience in computes dating back to the late 80's when he purchased his first computer and began his journey learning to program using a language called GW Basic and then went on to C and C++ and then Delphi and now he spends most of his time putting his programing skills to use developing web sites and web apps using any and all technologies at his disposal such as PHP, JavaScript, MySQL, and many many frameworks such as CodeIgniter, Laravel, WordPress, and the list goes on and on.  Sean also has a degree in Information Technology with an emphasis in Web Development.</p>
                <p style="color: #ffffff"></p>

                <div class="cbx-banner">


                    <ul class="banner-controls">



                    </ul>

                    <div class="slide title">

                        <div class="media">

                            <div class="media-body">

                                <img src="/_assets/cubix-solutions_logo.svg" />

                            </div>

                        </div>

                    </div>

                    @foreach($categories as $row)

                        <div class="slide">

                            <div class="media">

                                <div class="media-left">

                                    <img class="media-object" src="/_assets/store/{{$row->image}}" />

                                </div>

                                <div class="media-body">

                                    <h1 class="media-heading">{{$row->category}}</h1>
                                    <p>{{$row->description}}</p>

                                </div>

                            </div>

                        </div>

                    @endforeach



                </div>

                <h1>Recent Posts</h1>

            </div>
        </div>
    </div>

@stop