@extends('auth.template')
@section('title', $title)
@section('content')
    <body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('index') }}">@lang('auth.resetpassword.logo')</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">
                @lang('auth.resetpassword.description')
            </p>
            {!! Form::open(['route' => 'password.request']) !!}
                {{ Form::hidden('token', $token) }}
                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                    {{ Form::text('email', $email or old('email'), ['class' => 'form-control', 'placeholder' => trans('auth.resetpassword.form.email')]) }}
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('auth.resetpassword.form.password')]) }}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('auth.resetpassword.form.password_confirmation')]) }}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::button(trans('auth.resetpassword.form.submit'), ['class' => 'btn btn-primary btn-block btn-flat', 'type' => 'submit']) !!}
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
