<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', '')</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
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
    <script>
        function reurl() {

            //window.location.reload();
             url = location.href; //把当前页面的地址赋给变量 url

             var times = url.split("?"); //分切变量 url 分隔符号为 "?"

             if (times[1] != 1) { //如果?后的值不等于1表示没有刷新

             url += "?1"; //把变量 url 的值加入 ?1

             self.location.replace(url); //刷新页面

             }
            if(times[1] = 1)
             {

             }
        }
    </script>
</head>
<body onload="reurl()">
    @yield('content')
</body>
</html>
