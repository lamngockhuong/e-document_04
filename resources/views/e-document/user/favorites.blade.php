@extends('e-document.layouts.template')
@section('title', $title)
@section('content')
    <div class="ad_user"></div>
    <div class="ad_user_menu">
        <div class="ad_user_menu_right">
            <ul class="ad_ul_menu_right">
                <li><a class="active_u" href="">@lang('e-document.user.favorites.title') (1)</a></li>
            </ul>
        </div>
    </div>
    <div class="ad_user_content">
        <div class="ad_user_side_left">
            <div class="ad_user_avatar">
                <img alt="" src="{{ asset('templates/e-document/images/user_small.png') }}">
                {{ Form::open(['files' => true, 'method' => 'POST']) }}
                    <a class="ad_user_over_avatar transition0-5 edit_avatar" href="javascript:void(0)">
                        {{ Form::file('image', ['class' => 'input_avatar', 'id' => 'image']) }}
                        <i class="icon_upload_picture"></i>
                        <span>@lang('e-document.user.favorites.upload_a_photo')</span>
                    </a>
                {{ Form::close() }}
                <div class="clear"></div>
            </div>
            <h3 class="ad_user_name">{{ auth()->user()->fullname }}</h3>
            <div class="clear"></div>
            <div class="ad_user_menu_left">
                <ul>
                    <li>
                        <a href="{{ route('user.favorites') }}" class="icon_tq active_tabU">@lang('e-document.document.overview.title')</a>
                    </li>
                    <li>
                        <a href="{{ route('document-manager.index') }}" class="icon_qltl">@lang('e-document.document.index.title')</a>
                    </li>
                    <li>
                        <a href="#" class="icon_qltc">@lang('e-document.document.financial.title')</a>
                    </li>
                    <li>
                        <a href="#" class="icon_ttcn">@lang('e-document.document.personal.title')</a>
                    </li>
                    <li>
                        <a href="#" class="icon_tk">@lang('e-document.document.statistic.title')</a>
                    </li>
                </ul>
            </div>
            <div class="ad_user_image"><i class="icon_image_h"></i></div>
        </div>
        <div class="ad_user_side_right">
            <form id="formdoc">
                <div class="doc_item_cnt ">
                    @foreach ($documents as $document)
                        <div class="doc_list_cnt list_cnt_small item_user">
                            <i class="icon i_type_doc i_type_doc{{ config('setting.document.type.' . $document->file_type, '') }}"></i>
                            <a class="doc_cnt_img" href="{{ $document->detail_url }}" title="{{ $document->title }}">
                                <img src=""  onerror="this.src='{{ $document->default_image_url }}'" alt="{{ $document->title }}">
                            </a>
                            <a class="doc_title_cnt" href="{{ $document->detail_url }}">{{ $document->title }}</a>
                            <ul class="doc_tk_cnt">
                                <li><i class="icon_doc"></i>{{ $document->page_count }}</li>
                                <li><i class="icon_view"></i>{{ $document->view_count }}</li>
                                <li><i class="icon_down"></i>{{ $document->download_count }}</li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
@endsection
