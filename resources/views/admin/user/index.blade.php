@extends('admin.layouts.template')
@section('title', $title)
@section('page-header')
    @component('admin.layouts.page-header')
        @slot('page_title')
            @lang('admin.user.index.page-header.page_title')
        @endslot
        @slot('page_description')
            @lang('admin.user.index.page-header.page_description')
        @endslot
        @slot('breadcrumb')
            <li class="active">@lang('admin.user.index.title')</li>
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group margin">
                <a class="btn btn-block btn-success" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Add</a>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin.user.index.title')</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered user-table">
                        <tr>
                            <th>@lang('admin.user.index.table.username')</th>
                            <th>@lang('admin.user.index.table.email')</th>
                            <th>@lang('admin.user.index.table.firstname')</th>
                            <th>@lang('admin.user.index.table.lastname')</th>
                            <th>@lang('admin.user.index.table.action')</th>
                        </tr>
                        @if (count($users))
                            @foreach ($users as $user)
                                <tr>
                                    <td><a href="{{ route('users.edit', $user->id) }}">{{ $user->username }}</a></td>
                                    <td><a href="{{ route('users.edit', $user->id) }}">{{ $user->email }}</a></td>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->lastname }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="badge bg-light-blue"><i class="fa fa-edit"></i> @lang('admin.user.index.table.edit')</a>
                                        {!! Form::open(['route' => ['users.destroy', 'id' => $user->id]]) !!}
                                            {{ method_field('DELETE') }}
                                            {!! Form::button('<i class="fa fa-trash"></i> ' . trans('admin.tag.index.table.delete'),
                                                [
                                                    'class' => 'badge bg-red delete-button',
                                                    'type' => 'submit',
                                                    'data-mes-confirm' => trans('admin.user.index.table.delete-confirm', ['name' => $user->username]),
                                                ])
                                            !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" align="center">@lang('admin.user.index.table.no-record')</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <!-- /.box-body -->
                @if (count($users) && $users->lastPage() > 1)
                    <div class="box-footer clearfix">
                        {{ $users->render('admin.pagination.custom') }}
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
