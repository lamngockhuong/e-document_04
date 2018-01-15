@extends('e-document.layouts.template')
@section('title', $title)
@section('content')
    <div id="wapper">
        <div class="doc_main_content line_ngang" id="dtm">
            <h3 class="title_h3"></h3>
            <div class="doc_item_cnt">
                @foreach($documents as $document)
                    <div class="doc_list_cnt"{{ ($loop->index + 1) % config('setting.document.doc_list_cnt_end_div') == 0 ? ' style=margin-right:0' : '' }}>
                        <a class="doc_cnt_img" href="" target="_blank" title="{{ $document->title }}">
                            <img alt="{{ $document->title }}" src="{{ $document->imageUrl }}"
                                 onerror="this.src='{{ $document->defaultImageUrl }}'">
                        </a>
                        <a class="doc_title_cnt" href="" title="{{ $document->title }}" target="_blank">
                            <i class="icon i_type_doc i_type_doc{{ config('setting.document.type.' . $document->file_type, '') }}"></i>{{ $document->title }}
                        </a>
                        <a rel="nofollow" class="doc_author_cnt doc_name_author" href=""
                           title="{{ $document->user->getFullname() }}">{{ $document->user->getFullname() }}</a>
                        <ul class="doc_tk_cnt">
                            <li><i class="icon_doc"></i>{{ $document->page_count }}</li>
                            <li><i class="icon_view"></i>{{ $document->view_count }}</li>
                            <li><i class="icon_down"></i>{{ $document->download_count }}</li>
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
@endsection
