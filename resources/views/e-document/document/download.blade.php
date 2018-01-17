@extends('e-document.layouts.template')
@section('title', $title)
@section('content')
    <div class="box_content detail_download">
        <div class="top_download">
            <div class="info">
                <h1>{{ $document->title }}</h1>
                <ul class="doc_tk_cnt">
                    <li><i class="icon_doc"></i>{{ $document->page_count }}</li>
                    <li><i class="icon_view"></i>{{ $document->view_count }}</li>
                    <li><i class="icon_down"></i>{{ $document->download_count }}</li>
                </ul>
                <p><a class="doc_author_cnt doc_name_author" href="">{{ $document->user->fullname }}</a></p>
                <p class="line_action countDown">@lang('e-document.document.download.show_download_later') <label id="count-down"></label>@lang('e-document.document.download.second')</p>
                <p class="line_action hidden">
                    <a class="btn btn_download" data-url="{{ route('document.checkDownload') }}" data-id="{{ $document->id }}" href="javascript:void(0)" class="download-button">@lang('e-document.document.detail.download')</a>
                </p>
                <p class="line"></p>
                <label>@lang('e-document.document.download.share_to_download')</label>
                <div class="social">
                    <div class="fb-like" data-href="{{ $document->documentUrl }}"
                         data-layout="button_count" data-action="like" data-size="small" data-show-faces="true"
                         data-share="true"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
@endsection
