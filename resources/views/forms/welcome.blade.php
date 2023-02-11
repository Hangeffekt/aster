<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analytics }}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ $analytics }}');
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta charset="UTF8">
    <meta name="robots" content="index,follow">
    <meta name='revisit-after' content='5 days' >
    <meta name='author' content='Coding: Nagy Lorant' >
    <meta name='language' content='hu' >
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="description" content="{{ $description }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- fonts start -->
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <!-- reference your copy Font Awesome here (from our CDN or by hosting yourself) -->
    <link href="fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="fontawesome/css/brands.css" rel="stylesheet">
    <link href="fontawesome/css/solid.css" rel="stylesheet">
    <!-- fonts end -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	
	<script src="/js/jquery-3.5.1.js"></script>
    <link href="/fontawesome/css/all.css" rel="stylesheet">
	<!--bootstrap-->
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<script src="/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="/css/style.css">
	<script src="/js/script.js"></script>
</head>
<body>
    <div class="header-bg">
		<div class="header-bg-light"></div>
		<div class="header-bg-dark"></div>
	</div>
    <div class="container">
        <div class="row">
            @include("include.header") 
            @include("include.nav")
            @yield('content')
        </div>
    </div>
</body>
</html>