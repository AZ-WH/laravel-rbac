<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no, email=no"/>
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">

    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>

    {{--<link rel="stylesheet" href="{{ URL::asset('/') }}web/css/font-awesome.min.css">--}}
    <link rel="stylesheet" href="{{ URL::asset('/') }}web/css/icon.css">
    <link rel="stylesheet" href="{{ URL::asset('/') }}web/css/dropload.css">
    <link rel="stylesheet" href="{{ URL::asset('/') }}web/js/libs/layer/mobile/need/layer.css">

    @foreach($_css as $css)
        <link rel="stylesheet" href="{{ URL::asset('/') }}web/css/{{ $css }}">
    @endforeach
    {{--<link rel="stylesheet" href="{{ URL::asset('/') }}web/css/comfirm.css">--}}
    {{--<link rel="stylesheet" href="{{ URL::asset('/') }}web/css/info.css">--}}
    {{--<link rel="stylesheet" href="{{ URL::asset('/') }}web/css/order.css">--}}
    {{--<link rel="stylesheet" href="{{ URL::asset('/') }}web/css/cart.css">--}}
    {{--<link rel="stylesheet" href="{{ URL::asset('/') }}web/css/address.css">--}}

    <script data-main="{{ URL::asset('/') }}web/js/main" src="{{ URL::asset('/') }}web/js/require.js"></script>
    <title>{{ $_title }}</title>
</head>
<body>
