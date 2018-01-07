<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - @lang('admin.header.title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {!! Html::style('templates/admin/css/app.css') !!}
    {!! Html::style('templates/admin/css/AdminLTE.min.css') !!}
    {!! Html::style('templates/admin/css/skins/_all-skins.min.css') !!}
    {!! Html::style('templates/admin/css/custom.css') !!}
    {!! Html::style('templates/admin/plugins/iCheck/square/blue.css') !!}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
@yield('content')
@stack('script')
</html>
