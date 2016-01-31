<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Equimundo</title>

    <link href="/css/app.css" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="container" class="effect mainnav-lg">
    @include('layout.partials.nav')
    <div class="boxed">
        <div id="content-container">
            @yield('content')
        </div>
        <div id="mainnav-container">
            <div id="mainnav">
                <div id="mainnav-menu-wrap">
                    <div class="nano">
                        <div class="nano-content" tabindex="0">
                            <ul id="mainnav-menu" class="list-group">
                                <li class="{{ Active::route('admin.dashboard', 'active-link') }}">
                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="fa fa-dashboard"></i>
                                        <span class="menu-title">
                                            <strong>Dashboard</strong>
                                        </span>
                                    </a>
                                </li>
                                <li class="{{ Active::route('admin.users', 'active-link') }}">
                                    <a href="{{ route('admin.users') }}">
                                        <i class="fa fa-users"></i>
                                        <span class="menu-title">
                                            <strong>Users</strong>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="/js/all.js"></script>
@yield('footer')
</body>
</html>
