<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>FlatLab - Flat & Responsive Bootstrap Admin Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('/') }}admin/flatlib/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ URL::asset('/') }}admin/flatlib/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="{{ URL::asset('/') }}admin/flatlib/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ URL::asset('/') }}admin/flatlib/css/style.css" rel="stylesheet">
    <link href="{{ URL::asset('/') }}admin/flatlib/css/style-responsive.css" rel="stylesheet" />

    <script data-main="{{ URL::asset('/') }}admin/js/main" src="{{ URL::asset('/') }}admin/js/require.js"></script>

</head>

<body class="login-body">

<div class="container">

    <form class="form-signin" action="index.html">
        <h2 class="form-signin-heading">小一农货后台管理</h2>
        <div class="login-wrap">
            <input type="text" class="form-control form-item" name="account" placeholder="账号" autofocus>
            <input type="password" class="form-control form-item" name="password" placeholder="密码">
            <button class="btn btn-lg btn-login btn-block form-submit" type="button">登录</button>
        </div>
    </form>

</div>

<script>
    require(['app/auth'] , function (auth) {
        auth.login();
    })
</script>

</body>
</html>