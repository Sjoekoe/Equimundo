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
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="wrapper">
    @include('layout.partials._admin_nav')
    <div id="page-wrapper" class="gray-bg">
        @include('layout.partials.nav')

        @if (isset($pageTitle))
            @include('layout.partials._page_title')
        @endif

        <div class="wrapper wrapper-content animated fadeInRight">
            @yield('content')
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    var user_id = {{ auth()->user()->id() }}
</script>
<script>
    var algolia_id = '{{ env('ALGOLIA_APP_ID') }}'
    var algolia_app_id = '{{ env('ALGOLIA_ADMIN_API_KEY') }}'
    var pusher = '{{ env('PUSHER_KEY') }}';
</script>
@include('layout.partials._info')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdn.jsdelivr.net/typeahead.js/0.11.1/typeahead.jquery.min.js"></script>
<script src="/js/all.js"></script>
<script src="/js/app.js"></script>
@yield('footer')
</body>
</html>
