@extends('admin.layouts.template')
@section('title', $title)
@push('style')
	<!-- iCheck for checkboxes and radio inputs -->
	{!! Html::style('templates/admin/plugins/iCheck/all.css') !!}
@endpush
@section('page-header')
    @component('admin.layouts.page-header')
        @slot('page_title')
            @lang('admin.user.create.page-header.page_title')
        @endslot
        @slot('page_description')
            @lang('admin.user.create.page-header.page_description')
        @endslot
        @slot('breadcrumb')
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('admin.dashboard.title')</a></li>
            <li><a href="{{ route('users.index') }}">@lang('admin.user.index.title')</a></li>
            <li class="active">@lang('admin.user.create.title')</li>
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.user.create.title')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['route' => 'users.store', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true]) !!}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            {{ Form::label('username', trans('admin.user.create.form.username'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
                            	{{ Form::text('username', old('username'), ['class' => 'form-control']) }}
                            	@if ($errors->has('username'))
                                	<span class="help-block">{{ $errors->first('username') }}</span>
                            	@endif
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', trans('admin.user.create.form.email'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
	                            {{ Form::text('email', old('email'), ['class' => 'form-control']) }}
	                            @if ($errors->has('email'))
	                                <span class="help-block">{{ $errors->first('email') }}</span>
	                            @endif
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            {{ Form::label('firstname', trans('admin.user.create.form.firstname'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
	                            {{ Form::text('firstname', old('firstname'), ['class' => 'form-control']) }}
	                            @if ($errors->has('firstname'))
	                                <span class="help-block">{{ $errors->first('firstname') }}</span>
	                            @endif
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            {{ Form::label('lastname', trans('admin.user.create.form.lastname'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
	                            {{ Form::text('lastname', old('lastname'), ['class' => 'form-control']) }}
	                            @if ($errors->has('lastname'))
	                                <span class="help-block">{{ $errors->first('lastname') }}</span>
	                            @endif
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{ Form::label('password', trans('admin.user.create.form.password'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
	                            {{ Form::password('password', ['class' => 'form-control']) }}
	                            @if ($errors->has('password'))
	                                <span class="help-block">{{ $errors->first('password') }}</span>
	                            @endif
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('wallet') ? ' has-error' : '' }}">
                            {{ Form::label('wallet', trans('admin.user.create.form.wallet'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-2">
	                            {{ Form::number('wallet', old('wallet', config('setting.users_default.wallet')), ['class' => 'form-control']) }}
	                            @if ($errors->has('wallet'))
	                                <span class="help-block">{{ $errors->first('wallet') }}</span>
	                            @endif
                        	</div>
                        	<div class="col-sm-1">
                        		@lang('admin.user.create.form.wallet_coin')
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('free_download') ? ' has-error' : '' }}">
                            {{ Form::label('free_download', trans('admin.user.create.form.free_download'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-2">
	                            {{ Form::number('free_download', old('free_download', config('setting.users_default.free_download')), ['class' => 'form-control']) }}
	                            @if ($errors->has('free_download'))
	                                <span class="help-block">{{ $errors->first('free_download') }}</span>
	                            @endif
                        	</div>
                        	<div class="col-sm-1">
                        		@lang('admin.user.create.form.free_download_times')
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            {{ Form::label('role', trans('admin.user.create.form.role'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-3">
	                            {{ Form::select('role', [], null, ['class' => 'form-control']) }}
	                            @if ($errors->has('role'))
	                                <span class="help-block">{{ $errors->first('role') }}</span>
	                            @endif
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                            {{ Form::label('avatar', trans('admin.user.create.form.avatar'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-3">
                            	{{ Form::file('avatar', ['class' => 'form-control']) }}
	                            @if ($errors->has('avatar'))
	                                <span class="help-block">{{ $errors->first('avatar') }}</span>
	                            @endif
                        	</div>
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            {{ Form::label('status', trans('admin.user.create.form.status'), ['class' => 'col-sm-2 control-label']) }}
                            <div class="col-sm-10">
	                            {{ Form::checkbox('status', old('status'), config('setting.users_default.status'), ['class' => 'flat-red']) }}
	                            @if ($errors->has('status'))
	                                <span class="help-block">{{ $errors->first('status') }}</span>
	                            @endif
                        	</div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {!! Form::button(trans('admin.user.create.form.submit'), ['class' => 'btn btn-success pull-right', 'type' => 'submit']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@push('script')
    {!! Html::script('templates/admin/js/app.js') !!}
    {!! Html::script('templates/admin/plugins/iCheck/icheck.min.js') !!}
    {!! Html::script('templates/admin/js/custom.js') !!}
@endpush
