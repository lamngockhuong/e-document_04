@extends('admin.layouts.template')
@section('title', trans('admin.error.404.title'))
@section('page-header')
    @component('admin.layouts.page-header')
        @slot('page_title')
            @lang('admin.error.404.page-header.page_title')
        @endslot
        @slot('page_description')
            @lang('admin.error.404.page-header.page_description')
        @endslot
        @slot('breadcrumb')
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> @lang('admin.dashboard.title')</a></li>
            <li class="active">@lang('admin.error.404.title')</li>
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> @lang('admin.error.404.warning')</h3>
            <p>
                @lang('admin.error.404.message', ['url' => route('admin.index')])
            </p>
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
@endsection
@push('script')
    {!! Html::script('templates/admin/js/app.js') !!}
@endpush
