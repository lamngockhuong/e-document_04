<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - @lang('e-document.header.title')</title>
    <meta name="description" content="e-document"/>
    {!! Html::style('templates/e-document/css/app.css') !!}
    {!! Html::style('templates/e-document/css/index.css') !!}
    {!! Html::style('templates/e-document/css/style.css') !!}
    {!! Html::style('templates/e-document/css/detail.css') !!}
    @stack('style')
    {!! Html::script('templates/e-document/js/app.js') !!}
</head>
<body>
    @include('e-document.layouts.header')
    <div id="container">
        @yield('content')
    </div>
    <div class="clear"></div>
    <div id="fb-root"></div>
    @include('e-document.layouts.footer')
</body>
</html>
