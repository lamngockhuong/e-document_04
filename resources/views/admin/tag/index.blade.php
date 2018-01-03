@extends('admin.layouts.template')
@section('title', $title)
@section('page-header')
    @component('admin.layouts.page-header')
        @slot('page_title')
            @lang('admin.tag.index.page-header.page_title')
        @endslot
        @slot('page_description')
            @lang('admin.tag.index.page-header.page_description')
        @endslot
        @slot('breadcrumb')
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('admin.dashboard.title')</a></li>
            <li class="active">@lang('admin.tag.index.title')</li>
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group margin">
                <a class="btn btn-block btn-success" href="{{ route('tags.create') }}"><i class="fa fa-plus"></i> Add</a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.tag.index.title')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered tag-table">
                        <tr>
                            <th>@lang('admin.tag.index.table.name')</th>
                            <th>@lang('admin.tag.index.table.description')</th>
                            <th>@lang('admin.tag.index.table.slug')</th>
                            <th>@lang('admin.tag.index.table.action')</th>
                        </tr>
                        @if (count($tags))
                            @foreach ($tags as $tag)
                                <tr>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->termtaxonomy->description }}</td>
                                    <td>{{ $tag->slug }}</td>
                                    <td>
                                        <a href="{{ route('tags.edit', $tag->id) }}" class="badge bg-light-blue"><i class="fa fa-edit"></i> @lang('admin.tag.index.table.edit')</a>
                                        {!! Form::open(['route' => ['tags.destroy', 'id' => $tag->id]]) !!}
                                            {{ method_field('DELETE') }}
                                            {!! Form::button('<i class="fa fa-trash"></i> ' . trans('admin.tag.index.table.delete'),
                                                [
                                                    'class' => 'badge bg-red delete-button',
                                                    'type' => 'submit',
                                                    'data-mes-confirm' => trans('admin.tag.index.table.delete-confirm', ['name' => $tag->name]),
                                                ])
                                            !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" align="center">@lang('admin.tag.index.table.no-record')</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <!-- /.box-body -->
                @if (count($tags) && $tags->lastPage() > 1)
                    <div class="box-footer clearfix">
                        {{ $tags->render('admin.pagination.custom') }}
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
    {!! Html::script('templates/admin/js/tag.js') !!}
@endpush
