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
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">@lang('admin.category.index.title')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <th style="text-align:center">@lang('admin.category.index.table.name')</th>
                            <th style="text-align:center">@lang('admin.category.index.table.description')</th>
                            <th style="text-align:center">@lang('admin.category.index.table.slug')</th>
                            <th style="text-align:center">@lang('admin.category.index.table.action')</th>
                        </tr>
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->termtaxonomy->description }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td style="width: 135px" align="center">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="badge bg-light-blue"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="{{ route('categories.destroy', $category->id) }}" class="badge bg-red"><i class="fa fa-trash-o"></i> Delete</a>
                                    </td>
                                </tr>
                                @if (count($category->termtaxonomy->childs) > 0)
                                    @foreach($category->termtaxonomy->childs as $child)
                                        <tr>
                                            <td>{{ $child->name }}</td>
                                            <td>{{ $child->description }}</td>
                                            <td>{{ $child->slug }}</td>
                                            <td style="width: 135px" align="center">
                                                <a href="{{ route('categories.edit', $child->id) }}" class="badge bg-light-blue"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="{{ route('categories.destroy', $child->id) }}" class="badge bg-red"><i class="fa fa-trash-o"></i> Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
                @endif
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@push('script')
    {!! Html::script('templates/admin/js/app.js') !!}
@endpush
