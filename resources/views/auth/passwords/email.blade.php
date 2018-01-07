@extends('auth.template')
@section('title', $title)
@section('content')
    <body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('index') }}">@lang('auth.forgotpassword.logo')</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">
                @lang('auth.forgotpassword.description')
            </p>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            {!! Form::open(['route' => 'password.email']) !!}
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('auth.forgotpassword.form.email')]) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-12">
                    {!! Form::button(trans('auth.forgotpassword.form.submit'), ['class' => 'btn btn-primary btn-block btn-flat', 'type' => 'submit']) !!}
                </div>
                <!-- /.col -->
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    </body>
    @push('script')
        {!! Html::script('templates/admin/js/app.js') !!}
        {!! Html::script('templates/admin/plugins/iCheck/icheck.min.js') !!}
        {!! Html::script('templates/admin/js/auth.js') !!}
    @endpush
@endsection
