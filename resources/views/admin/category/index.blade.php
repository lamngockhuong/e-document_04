@extends('admin.layouts.template')
@section('title', $title)
@section('page-header')
    @component('admin.layouts.page-header')
        @slot('page_title')
            @lang('admin.category.index.page-header.page_title')
        @endslot
        @slot('page_description')
            @lang('admin.category.index.page-header.page_description')
        @endslot
        @slot('breadcrumb')
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('admin.dashboard.title')</a></li>
            <li class="active">@lang('admin.category.index.title')</li>
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group margin">
                <a class="btn btn-block btn-success" href="{{ route('categories.create') }}"><i class="fa fa-plus"></i> Add</a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.category.index.title')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered category-table">
                        <tr>
                            <th>@lang('admin.category.index.table.name')</th>
                            <th>@lang('admin.category.index.table.description')</th>
                            <th>@lang('admin.category.index.table.slug')</th>
                            <th>@lang('admin.category.index.table.parent')</th>
                            <th>@lang('admin.category.index.table.action')</th>
                        </tr>
                        @if (count($categories))
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->termTaxonomy->description }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ is_null($category->termTaxonomy->taxonomyParent) ? '---' : $category->termTaxonomy->taxonomyParent->term->name }}</td>
                                    <td>
                                        <a href="{{ route('tags.edit', $category->id) }}" class="badge bg-light-blue"><i class="fa fa-edit"></i> @lang('admin.category.index.table.edit')</a>
                                        {!! Form::open(['route' => ['categories.destroy', 'id' => $category->id]]) !!}
                                            {{ method_field('DELETE') }}
                                            {!! Form::button('<i class="fa fa-trash"></i> ' . trans('admin.category.index.table.delete'),
                                                [
                                                    'class' => 'badge bg-red delete-button',
                                                    'type' => 'submit',
                                                    'data-mes-confirm' => trans('admin.category.index.table.delete-confirm', ['name' => $category->name]),
                                                ])
                                            !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" align="center">@lang('admin.category.index.table.no-record')</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <!-- /.box-body -->
                @if (count($categories) && $categories->lastPage() > 1)
                    <div class="box-footer clearfix">
                        {{ $categories->render('admin.pagination.custom') }}
                    </div>
                    <!-- /.box-footer -->
                @endif
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@push('script')
    {!! Html::script('templates/admin/js/app.js') !!}
    {!! Html::script('templates/admin/js/custom.js') !!}
@endpush
