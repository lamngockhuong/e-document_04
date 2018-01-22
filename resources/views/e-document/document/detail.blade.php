@extends('e-document.layouts.template')
@section('title', $title)
@section('content')
    <div class="box_content detail_content">
        <section class="doc_navicate">
            <ul>
                <li>
                    <i class="icon_nav_home"></i>
                    <a href="{{ route('public.index') }}" title="@lang('e-document.index.title')">@lang('e-document.index.title')</a>
                </li>
                @if ($category->taxonomyParent)
                    <li class="cat_nav_pa" itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">
                        <i class="icon_nav_ctn"></i>
                        <a itemprop="url" class="cat_nav_top_a" href="" title="{{ $category->taxonomyParent->term->name }}">
                            <span itemprop="title">{{ $category->taxonomyParent->term->name }}</span>
                        </a>
                    </li>
                @endif
                <li class="cat_nav_pa" itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">
                    <i class="icon_nav_ctn"></i>
                    <a itemprop="url" class="cat_nav_top_a" href="" title="{{ $category->term->name }}">
                        <span itemprop="title">{{ $category->term->name }}</span>
                    </a>
                </li>
            </ul>
        </section>
        <div class="detailLeft">
            <div class="detailInfo">
                <h1>
                    {{ $document->title }} <span class="icon i_type_doc i_type_doc3"></span>
                </h1>
                <div>
                    <span><i class="icon i_numpage"></i>{{ $document->page_count }}</span>
                    <span><i class="icon i_numview"></i>{{ $document->view_count }}</span>
                    <span><i class="icon i_numdown"></i>{{ $document->download_count }}</span>
                </div>
                <div>
                    <a rel="nofollow" href="javascript:void(0)">
                        <img title="{{ $document->user->fullname }}" src="{{ $document->user->avatar_url }}" onerror="this.src='{{ $document->user->default_avatar_url }}'">
                    </a>
                    <div class="infoUser">
                        <p>
                            <a rel="nofollow" title="{{ $document->user->fullname }}" href="">{{ $document->user->fullname }}</a>
                            <a rel="nofollow" href="javascript:void(0)" class="smsUser"><i class="icon_doc_mail"></i>@lang('e-document.document.detail.send_message')</a>
                            <a rel="nofollow" class="notifi_document btn_notifi" target="_blank" href="javascript:void(0)">@lang('e-document.document.detail.report_issue')</a>
                        </p>
                    </div>
                    <div class="detailDownload">
                        @if (count($document->favorites))
                            <a data-url="{{ route('document.addToFavorites') }}" data-id="{{ $document->id }}" data-status="1" href="javascript:void(0)" id="add-to-favorite" class="upload_earn_money">
                                <label>@lang('e-document.document.detail.remove_from_favorite')</label>
                            </a>
                        @else
                            <a data-url="{{ route('document.addToFavorites') }}" data-id="{{ $document->id }}" data-status="0" href="javascript:void(0)" id="add-to-favorite" class="upload_earn_money">
                                <label>@lang('e-document.document.detail.add_to_favorite')</label>
                            </a>
                        @endif
                        <a data-url="{{ route('document.checkDownload') }}" data-id="{{ $document->id }}" href="javascript:void(0)" class="download-button">
                            <span>@lang('e-document.document.detail.download')</span>
                            <label>{{ $document->download_count }}</label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="detailContent" id="contentDocument">
                <iframe id="frame-preview" src='https://docs.google.com/viewer?url={{ $document->documentSource }}&embedded=true' width='100%' height='100%' frameborder='0'>
                </iframe>
            </div>
            <div class="detailActionDownload ">
                <a data-url="{{ route('document.checkDownload') }}" data-id="{{ $document->id }}" href="javascript:void(0)" class="download-button">
                    <i class="icon"></i>@lang('e-document.document.detail.download') <span>({{ $document->page_count }} @lang('e-document.document.detail.page'))</span>
                </a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="detailRight">
        </div>
    </div>
    <div class="clear"></div>
@endsection
