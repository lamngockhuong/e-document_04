@extends('auth.template')
@section('title', $title)
@section('content')
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <a href="{{ route('index') }}">@lang('auth.register.logo')</a>
            </div>
            <div class="register-box-body">
                <p class="login-box-msg">@lang('auth.register.description')</p>
                {!! Form::open(['route' => 'register']) !!}
                    <div class="form-group has-feedback{{ $errors->has('firstname') ? ' has-error' : '' }}">
                        {{ Form::text('firstname', old('firstname'), ['class' => 'form-control', 'placeholder' => trans('auth.register.form.firstname')]) }}
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('firstname'))
                            <span class="help-block">{{ $errors->first('firstname') }}</span>
                        @endif
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        {{ Form::text('lastname', old('lastname'), ['class' => 'form-control', 'placeholder' => trans('auth.register.form.lastname')]) }}
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('lastname'))
                            <span class="help-block">{{ $errors->first('lastname') }}</span>
                        @endif
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('username') ? ' has-error' : '' }}">
                        {{ Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => trans('auth.register.form.username')]) }}
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        @if ($errors->has('username'))
                            <span class="help-block">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                        {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('auth.register.form.email')]) }}
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('auth.register.form.password')]) }}
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('auth.register.form.password_confirmation')]) }}
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck{{ $errors->has('agree_term') ? ' has-error' : '' }}">
                                <label>
                                    {{ Form::checkbox('agree_term', old('agree_term'), false) }}
                                    @lang('auth.register.form.terms')
                                    @if ($errors->has('agree_term'))
                                        <span class="help-block">{{ $errors->first('agree_term') }}</span>
                                    @endif
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
                <a href="{{ route('login') }}">@lang('auth.register.membership')</a><br>
                <a href="{{ route('index') }}">@lang('auth.register.gotohome')</a>
            </div>
            <!-- /.form-box -->
        </div>
        <!-- /.register-box -->
    </body>
    @push('script')
        {!! Html::script('templates/admin/js/app.js') !!}
        {!! Html::script('templates/admin/plugins/iCheck/icheck.min.js') !!}
        {!! Html::script('templates/admin/js/auth.js') !!}
    @endpush
@endsection

