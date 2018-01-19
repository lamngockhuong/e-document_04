@extends('e-document.layouts.template')
@section('title', $title)
@section('content')
    <div class="ad_user"></div>
    <div class="ad_user_menu">
        <div class="ad_user_parent_top">
            <h3 class="ad_user_name">{{ auth()->user()->fullname }}</h3>
            <a class="ad_user_messeger" href="">
                <i class="icon_doc_mail filter"></i> @lang('e-document.message.title')
            </a>
        </div>
    </div>
    <div class="ad_user_content">
        <div class="ad_user_side_left left_info">
            <div class="ad_user_avatar_small">
                <img src="{{ auth()->user()->avatar_url }}" alt="avatar" onerror="this.src='{{ auth()->user()->default_avatar_url }}'">
                <div class="clear"></div>
            </div>
            <div class="ad_user_menu_left">
                <ul>
                    <li>
                        <a href="#" class="icon_tq">@lang('e-document.document.overview.title')</a>
                    </li>
                    <li>
                        <a href="{{ route('document-manager.index') }}" class="icon_qltl active_tabU">@lang('e-document.document.index.title')</a>
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
        <div class="ad_user_side_right right_info ">
            <h3 class="ad_user_name">@lang('e-document.document.index.title')</h3>
            <div class="content_user_info bg_none">
                <div class="top_doc_type">
                    <ul>
                        <li{!! $status == config('setting.document.status.approved') ? ' class="active_man"' : '' !!}>
                            <a for="man_radio" href="{{ route('document-manager.index', 'status=' . config('setting.document.status.approved')) }}">
                                <i class="icon_type_radio"></i>
                                <span>@lang('e-document.document.index.approved')<em> ({{ $approvedCount }})</em></span>
                            </a>
                        </li>
                        <li{!! $status == config('setting.document.status.incomplete') ? ' class="active_man"' : '' !!}>
                            <a for="man_radio" href="{{ route('document-manager.index', 'status=' . config('setting.document.status.incomplete')) }}">
                                <i class="icon_type_radio"></i>
                                <span><i class="warn warning"></i>@lang('e-document.document.index.incomplete')<em> ({{ $incompleteCount }})</em></span>
                            </a>
                        </li>
                        <li{!! $status == config('setting.document.status.unapproved') ? ' class="active_man"' : '' !!}>
                            <a for="man_radio" href="{{ route('document-manager.index', 'status=' . config('setting.document.status.unapproved')) }}">
                                <i class="icon_type_radio"></i>
                                <span>@lang('e-document.document.index.unapproved')<em> ({{ $unapprovedCount }})</em></span>
                            </a>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="mn_list_view_more">
                    <div class="list_doc_man">
                        @foreach($documents as $document)
                            <div class="doc_list_cnt list_cnt_small list div_del">
                                <i class="icon_type_doc"></i>
                                <span class="doc_man_date">@lang('e-document.document.index.date', ['date' => $document->upload_date])</span>
                                <a class="doc_cnt_img" href="{{ $document->detail_url }}" title="{{ $document->title }}">
                                    <img src="{{ $document->image_url }}" alt="{{ $document->title }}" onerror="this.src='{{ $document->default_image_url }}'">
                                </a>
                                <div class="left_item_doc">
                                    <a class="doc_title_cnt" title="{{ $document->title }}" href="{{ $document->detail_url }}">
                                        {{ $document->title }}
                                    </a>
                                    <ul class="nav_doc_man">
                                        @if (isset($document->termTaxonomys[0]))
                                            @if ($document->termTaxonomys[0]->taxonomyParent)
                                                <li>
                                                    <a href="">{{ $document->termTaxonomys[0]->taxonomyParent->term->name }}</a>
                                                    <i class="icon_nav_ctn"></i>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="">{{ $document->termTaxonomys[0]->term->name }}</a>
                                                <i class="icon_nav_ctn"></i>
                                            </li>
                                        @endif
                                    </ul>
                                    <ul class="doc_tk_cnt">
                                        <li>
                                            <i class="icon_doc"></i>{{ $document->page_count }}
                                        </li>
                                        <li>
                                            <i class="icon_view"></i>{{ $document->view_count }}
                                        </li>
                                        <li>
                                            <i class="icon_down"></i>{{ $document->download_count }}
                                        </li>
                                        <li>
                                            <span class="cl_price">{{ $document->price }}</span>
                                        </li>
                                    </ul>
                                    <div class="doc_man_hover">
                                        {!! Form::open(['route' => ['document-manager.destroy', 'id' => $document->id], 'id' => 'delete-document-' . $document->id, 'style' => 'display: none']) !!}
                                            {{ method_field('DELETE') }}
                                        {!! Form::close() !!}
                                        <a class="man_doc_del icon" href="{{ route('document-manager.destroy', $document->id) }}"  onclick="event.preventDefault(); document.getElementById('delete-document-' + {{ $document->id }}).submit();">
                                            @lang('e-document.document.index.delete')
                                        </a>
                                        <a class="man_doc_edit icon" href="{{ route('document-manager.edit', $document->id) }}">@lang('e-document.document.index.edit')</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="clear"></div>
                        @if (count($documents) && $documents->lastPage() > 1)
                            {{ $documents->render('e-document.pagination.custom') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
