@extends('admin.layouts.template')
@section('title', $title)
@section('page-header')
    @component('admin.layouts.page-header')
        @slot('page_title')
            @lang('admin.tag.edit.page-header.page_title')
        @endslot
        @slot('page_description')
            @lang('admin.tag.edit.page-header.page_description')
        @endslot
        @slot('breadcrumb')
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('admin.dashboard.title')</a></li>
            <li>@lang('admin.tag.index.title')</li>
            <li class="active">@lang('admin.tag.edit.title')</li>
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.tag.edit.title'): <b>{{ $term->name }}</b></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($term, ['route' => ['tags.update', $term->id], 'method' => 'PUT', 'role' => 'form']) !!}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', trans('admin.tag.create.form.name')) }}
                            {{ Form::text('name', old('name'), ['class' => 'form-control', 'onkeyup' => 'changeToSlug();']) }}
                            @if ($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                            {{ Form::label('slug', trans('admin.tag.create.form.slug')) }}
                            {{ Form::text('slug', old('slug'), ['class' => 'form-control']) }}
                            @if ($errors->has('slug'))
                                <span class="help-block">{{ $errors->first('slug') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {{ Form::label('description', trans('admin.tag.create.form.description')) }}
                            {{ Form::textarea('description', old('description', $term->termtaxonomy->description), ['class' => 'form-control']) }}
                            @if ($errors->has('description'))
                                <span class="help-block">{{ $message }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {!! Form::button(trans('admin.tag.edit.form.submit'), ['class' => 'btn btn-success', 'type' => 'submit']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@push('script')
    {!! Html::script('templates/admin/js/app.js') !!}
    {!! Html::script('templates/admin/js/custom.js') !!}
@endpush
