<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('e-document/layout.title')</title>
    <meta name="description" content="e-document"/>
    {!! Html::style('templates/e-document/css/index.css') !!}
    {!! Html::style('templates/e-document/css/main.css') !!}
    {!! Html::style('templates/e-document/js/ajax/jquery.qtip.css') !!}
    {!! Html::style('templates/e-document/js/ajax/jquery.ajax.css') !!}
    {!! Html::script('templates/e-document/js/index.js') !!}
</head>
<body>
    @include('e-document.layouts.header')
    @yield('content')
    @include('e-document.layouts.footer')
    {!! Html::script('templates/e-document/js/ajax/bootbox.min.js') !!}
    {!! Html::script('templates/e-document/js/ajax/jquery.qtip.js') !!}
    {!! Html::script('templates/e-document/js/ajax/jquery.ajax.js') !!}
    {!! Html::script('templates/e-document/js/customize.js') !!}
</body>
</html>
