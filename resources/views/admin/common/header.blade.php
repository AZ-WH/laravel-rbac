<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>{{ $_title }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('/') }}admin/flatlib/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ URL::asset('/') }}admin/flatlib/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="{{ URL::asset('/') }}admin/flatlib/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ URL::asset('/') }}admin/css/uploader.css">
    <link rel="stylesheet" href="{{ URL::asset('/') }}admin/css/app.css">

    <!-- Custom styles for this template -->
    <link href="{{ URL::asset('/') }}admin/flatlib/css/style.css" rel="stylesheet">
    <link href="{{ URL::asset('/') }}admin/flatlib/css/style-responsive.css" rel="stylesheet" />

    <link href="{{ URL::asset('/') }}admin/js/libs/layer/skin/default/layer.css" rel="stylesheet">

    <script data-main="{{ URL::asset('/') }}admin/js/main" src="{{ URL::asset('/') }}admin/js/require.js"></script>

    <script src="{{ URL::asset('/') }}admin/js/libs/jquery-3.1.1.min.js"></script>
</head>

<body class="full-width">


<section id="container" class="">
    <!--header start-->
    <header class="header white-bg">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!--logo start-->
            <a href="index.html" class="logo" >LARAVEL<span>RBAC</span></a>
            <!--logo end-->
           @include('admin.common.menu')

            <div class="top-nav ">
                <ul class="nav pull-right top-menu">

                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            {{--<img alt="" src="img/avatar1_small.jpg">--}}
                            <span class="username" id="userinfo">username</span>
                            <b class="caret"></b>
                        </a>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
            </div>

        </div>

    </header>
    <!--header end-->

    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">

            <div class="row" style="margin: 0">