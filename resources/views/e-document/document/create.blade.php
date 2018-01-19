@extends('e-document.layouts.template')
@section('title', $title)
@push('style')
    {!! Html::style('templates/e-document/css/upload.css') !!}
@endpush
@section('content')
    <div class="main-upload">
        <h2>@lang('e-document.document.create.main_title')</h2>
        <h4>@lang('e-document.document.create.main_description')</h4>
        <div class="main-wrap" id="mainWrap">
            <h1>@lang('e-document.document.create.box_title')</h1>
            <div class="large-btn-upload" id="btnUpload">
                <a href="javascript:void(0)">@lang('e-document.document.create.upload')</a>
            </div>
            <p>@lang('e-document.document.create.box_description')</p>
            <p><span>@lang('e-document.document.create.box_tip')</span></p>
        </div>
        {{ Form::open(['url' => '', 'class' => 'hidden', 'id' => 'upload-form']) }}
            {{ Form::hidden('id', '', ['id' => 'file-id']) }}
            {{ Form::file('docs', ['id' => 'fileupload', 'data-url' => route('document-manager.upload')]) }}
        {{ Form::close() }}
        <table class="upload-result" id="upload-result">
        </table>
    </div>
@endsection
