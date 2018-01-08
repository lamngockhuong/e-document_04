@extends('admin.layouts.template')
@section('title', $title)
@section('page-header')
    @component('admin.layouts.page-header')
        @slot('page_title')
            @lang('admin.category.edit.page-header.page_title')
        @endslot
        @slot('page_description')
            @lang('admin.category.edit.page-header.page_description')
        @endslot
        @slot('breadcrumb')
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('admin.dashboard.title')</a></li>
            <li>@lang('admin.category.index.title')</li>
            <li class="active">@lang('admin.category.edit.title')</li>
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.category.edit.title')</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::model($term, ['route' => ['categories.update', $term->id], 'role' => 'form', 'method' => 'PUT', 'id' => 'category-form']) !!}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', trans('admin.category.edit.form.name')) }}
                            {{ Form::text('name', old('name'), ['class' => 'form-control', 'onkeyup' => 'changeToSlug();']) }}
                            @if ($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                            {{ Form::label('slug', trans('admin.category.edit.form.slug')) }}
                            {{ Form::text('slug', old('slug'), ['class' => 'form-control']) }}
                            @if ($errors->has('slug'))
                                <span class="help-block">{{ $errors->first('slug') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            {{ Form::label('category', trans('admin.category.edit.form.category')) }}
                            {{ Form::select('category', $categories, old('category', $term->termTaxonomy->parent), ['class' => 'form-control']) }}
                            @if ($errors->has('category'))
                                <span class="help-block">{{ $errors->first('category') }}</span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {{ Form::label('description', trans('admin.category.edit.form.description')) }}
                            {{ Form::textarea('description', old('description', $term->termTaxonomy->description), ['class' => 'form-control']) }}
                            @if ($errors->has('description'))
                                <span class="help-block">{{ $message }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {!! Form::button(trans('admin.category.edit.form.submit'), ['class' => 'btn btn-success', 'type' => 'submit']) !!}
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
