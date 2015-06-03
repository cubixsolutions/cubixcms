<!doctype html>
<html ng-app="cubixcms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta-info')

    <title>{{$title}} - {{$slogan}}</title>

    <link href='/_css/bootstrap.css' rel="stylesheet">
    <link href='/_css/themes/flatly/bootstrap.min.css' rel="stylesheet">
    <link href="/_css/font-awesome.css" rel="stylesheet">
    <link href="/_css/ionicons.css" rel="stylesheet">
    <link href="/_css/fuelux.css" rel="stylesheet">
    <link href='/_css/style.css' rel="stylesheet">

    <script src='/_scripts/jquery-1.11.3.js'></script>
    <script src='/_scripts/bootstrap.js'></script>
    <script src="/_scripts/fuelux.js"></script>
    <script src="/_scripts/plugins/bootstrap-growl/bootstrap-growl-2.0.0.js"></script>
    <script src="/_scripts/TweenMax.js"></script>
    <script src="/_scripts/TimelineMax.js"></script>
    <script src="/_scripts/angular.js"></script>

    <script src="/_scripts/jquery.matchHeight.js"></script>
    <script src="/_scripts/plugins/threedots/jquery.threedots.js"></script>
    <script src='/_scripts/cubixcms.js'></script>

    @yield("head")


    <script src="//use.typekit.net/oor4dui.js"></script>
    <script>try {
            Typekit.load();
        } catch (e) {
        }</script>


</head>

<body class="fuelux" ng-controller="shoppingCart" loadCart>
<nav class="navbar navbar-default navbar-fixed-top">

    <div class="container-fluid">

        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#cubixcms-navbar-collapse-1">

                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>

            <a class="navbar-brand" href="#">Cubix Solutions</a>

        </div>
        <!-- end of navbar-header -->

        <!-- Collect the nav links for toggling -->

        <div class="collapse navbar-collapse" id="cubixcms-navbar-collapse-1">

            <ul class="nav navbar-nav">

                <li class="active"><a href="/page/home">Home</a></li>
                <li><a href="/store/">Services</a></li>
                <li><a href="/page/portfolio">Portfolio</a></li>
                <li><a href="/page/about-us">About Us</a></li>

            </ul>

            @yield("navbar_links")

            @if(Auth::check())
                <p class="navbar-text pull-right">
                    <a href="/my-account/logout" class="navbar-link"><i class="fa fa-sign-out"></i> Logout</a>
                </p>
            @endif
            <p class="navbar-text pull-right">
                <a href="/store/view-cart" class="navbar-link"><i class="fa fa-shopping-cart"></i> View Cart</a> <span
                        id="cart_count" class="badge" ng-cloak><% cart_count %></span>
            </p>

        </div>

    </div>
    <!-- end container fluid -->

</nav>
<!-- end navbar -->

<div class="page-wrapper">

    @yield("content")

    <div class="content-divider"></div>

    @include('layouts.partials.footer')

</div>

@yield('footer')

</body>
</html>