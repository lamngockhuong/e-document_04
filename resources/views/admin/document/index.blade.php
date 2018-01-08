@extends('admin.layouts.template')
@section('title', $title)
@section('page-header')
    @component('admin.layouts.page-header')
        @slot('page_title')
            @lang('admin.document.index.page-header.page_title')
        @endslot
        @slot('page_description')
            @lang('admin.document.index.page-header.page_description')
        @endslot
        @slot('breadcrumb')
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('admin.dashboard.title')</a></li>
            <li class="active">@lang('admin.document.index.title')</li>
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group margin">
                <a class="btn btn-block btn-success" href="{{ route('documents.create') }}"><i class="fa fa-plus"></i> Add</a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.document.index.title')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered document-table">
                        <tr>
                            <th>@lang('admin.document.index.table.title')</th>
                            <th>@lang('admin.document.index.table.image')</th>
                            <th>@lang('admin.document.index.table.category')</th>
                            <th>@lang('admin.document.index.table.user')</th>
                            <th>@lang('admin.document.index.table.document_status')</th>
                            <th>@lang('admin.document.index.table.comment_status')</th>
                            <th>@lang('admin.document.index.table.view_count')</th>
                            <th>@lang('admin.document.index.table.download_count')</th>
                            <th>@lang('admin.document.index.table.action')</th>
                        </tr>
                        @forelse ($documents as $document)
                            <tr>
                                <td><a href="{{ route('documents.edit', $document->id) }}">{{ $document->title }}</a></td>
                                <td>
                                    <img src="{{ asset(config('setting.avatar_folder') . '/' . $document->image) }}" width="100" height="100" />
                                </td>
                                <td>
                                    @foreach ($document->termTaxonomys as $termTaxonomy)
                                        <a href="{{ route('categories.edit', $termTaxonomy->term->id) }}">
                                            <span class="badge bg-green">{{ $termTaxonomy->term->name }}</span>
                                        </a>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $document->user->id) }}">{{ $document->user->username }}</a>
                                </td>
                                <td>{{ $document->document_status }}</td>
                                <td>{{ $document->comment_status }}</td>
                                <td>{{ $document->view_count }}</td>
                                <td>{{ $document->download_count }}</td>
                                <td>
                                    <a href="{{ route('documents.edit', $document->id) }}" class="badge bg-light-blue"><i class="fa fa-edit"></i> @lang('admin.document.index.table.edit')</a>
                                    {!! Form::open(['route' => ['documents.destroy', 'id' => $document->id]]) !!}
                                        {{ method_field('DELETE') }}
                                        {!! Form::button('<i class="fa fa-trash"></i> ' . trans('admin.document.index.table.delete'),
                                            [
                                                'class' => 'badge bg-red delete-button',
                                                'type' => 'submit',
                                                'data-mes-confirm' => trans('admin.document.index.table.delete-confirm', ['name' => $document->title]),
                                            ])
                                        !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" align="center">@lang('admin.document.index.table.no-record')</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
                <!-- /.box-body -->
                @if (count($documents) && $documents->lastPage() > 1)
                    <div class="box-footer clearfix">
                        {{ $documents->render('admin.pagination.custom') }}
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
