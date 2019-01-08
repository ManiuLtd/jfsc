<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', '')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="@yield('meta_description', '富连网物联网智能家居会员服务')">
    <meta name="author" content="@yield('meta_author', '富连网物联网')">
    <meta name="keywords" content="富连网, 富连网物联网, 物联网, 会员服务,智能家居,家居">
    @yield('meta')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{ asset('js/modernizr.js')}}"></script>
    <script src="{{ asset('js/jquery.min.js')}}"></script>

</head>
<body class="login" >
    @yield('content')
</body>
</html>
