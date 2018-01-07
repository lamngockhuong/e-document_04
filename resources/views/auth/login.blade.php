@extends('auth.template')
@section('title', $title)
@section('content')
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ route('index') }}">@lang('auth.register.logo')</a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">@lang('auth.login.description')</p>
                {!! Form::open(['route' => 'login']) !!}
                    <div class="form-group has-feedback{{ $errors->has('username') ? ' has-error' : '' }}">
                        {{ Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => trans('auth.login.form.username')]) }}
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('username'))
                            <span class="help-block">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('auth.login.form.password')]) }}
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    {{ Form::checkbox('remember', old('remember'), false) }}
                                    @lang('auth.login.form.remember')
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            {!! Form::button(trans('auth.login.form.submit'), ['class' => 'btn btn-primary btn-block btn-flat', 'type' => 'submit']) !!}
                        </div>
                        <!-- /.col -->
                    </div>
                {!! Form::close() !!}
                <a href="{{ route('password.request') }}">@lang('auth.login.forget_link')</a><br>
                <a href="{{ route('register') }}" class="text-center">@lang('auth.login.register_link')</a><br>
                <a href="{{ route('index') }}">@lang('auth.register.gotohome')</a>
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
