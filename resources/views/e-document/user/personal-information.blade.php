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
                        <a href="{{ route('user.favorites') }}" class="icon_tq">@lang('e-document.document.overview.title')</a>
                    </li>
                    <li>
                        <a href="{{ route('document-manager.index') }}" class="icon_qltl">@lang('e-document.document.index.title')</a>
                    </li>
                    <li>
                        <a href="#" class="icon_qltc">@lang('e-document.document.financial.title')</a>
                    </li>
                    <li>
                        <a href="{{ route('user.personal_information') }}" class="icon_ttcn active_tabU">@lang('e-document.document.personal.title')</a>
                    </li>
                    <li>
                        <a href="#" class="icon_tk">@lang('e-document.document.statistic.title')</a>
                    </li>
                </ul>
            </div>
            <div class="ad_user_image"><i class="icon_image_h"></i></div>
        </div>
        <div class="ad_user_side_right right_info ">
            <h3 class="ad_user_name">@lang('e-document.document.personal.title')</h3>
            <div class="content_user_info">
                <div class="info_user_cnt">
                    <div class="edit_from_user">
                        <h4 class="title_user_info">
                            @lang('e-document.user.personal_information.first_name')
                            <a href="javascript:;" class="icon_edit_title filter icon" onclick="edit_user(this); return">@lang('e-document.user.personal_information.btn_change')</a>
                        </h4>
                        <div class="user_result">
                            <h3 class="ad_user_name edit_name">{{ auth()->user()->firstname }}</h3>
                        </div>
                        <div class="user_no_result">
                            {{ Form::open(['method' => 'POST', 'name' => 'fr_name', 'class' => 'fr_name']) }}
                                <span class="ip_name_edit">
                                    {{ Form::text('txtUsername', auth()->user()->firstname, ['class' => 'edit_ip_name']) }}
                                    <input name="txtUsername" value="Lâm Ngọc Khương" class="edit_ip_name" onkeydown="CountLeft(this.form.txtUsername,this.form.cmt_disabled,0)" onkeyup="CountLeft(this.form.txtUsername,this.form.cmt_disabled,0)">
                                    <em><input disabled="disabled" name="cmt_disabled" class="number_cmt">/30</em>
                                </span>
                            {{ Form::close() }}
                            <form method="POST" name="fr_name" class="fr_name" action="">
                                <span class="ip_name_edit">
                                    <input name="txtUsername" value="Lâm Ngọc Khương" class="edit_ip_name" onkeydown="CountLeft(this.form.txtUsername,this.form.cmt_disabled,0)" onkeyup="CountLeft(this.form.txtUsername,this.form.cmt_disabled,0)">
                                    <em><input disabled="disabled" name="cmt_disabled" class="number_cmt">/30</em>
                                </span>
                                <button type="submit" name="frm_name" onclick="return Checklenght()" class="smt_edit_info" value="frm_name">
                                    @lang('e-document.user.personal_information.btn_change')
                                </button>
                                <a href="javascript:;" class="smt_exit" onclick="exit_user(this); return">
                                    @lang('e-document.user.personal_information.btn_cancel')
                                </a>
                            </form>
                        </div>
                        <h4 class="title_user_info">@lang('e-document.user.personal_information.last_name')</h4>
                        <div class="user_result">
                            <h3 class="ad_user_name edit_name">{{ auth()->user()->lastname }}</h3>
                        </div>
                        <div class="user_no_result">
                            <form method="POST" name="fr_name" class="fr_name" action="">
                                <span class="ip_name_edit">
                                    <input name="txtUsername" value="Lâm Ngọc Khương" class="edit_ip_name" onkeydown="CountLeft(this.form.txtUsername,this.form.cmt_disabled,0)" onkeyup="CountLeft(this.form.txtUsername,this.form.cmt_disabled,0)">
                                    <em><input disabled="disabled" name="cmt_disabled" class="number_cmt">/30</em>
                                </span>
                                <button type="submit" name="frm_name" onclick="return Checklenght()" class="smt_edit_info" value="frm_name">@lang('e-document.user.personal_information.btn_save')</button>
                                <a href="javascript:;" class="smt_exit" onclick="exit_user(this); return">@lang('e-document.user.personal_information.btn_cancel')</a>
                            </form>
                        </div>
                    </div>
                    <div class="line_array"></div>
                    <div class="edit_from_user">
                        <h4 class="title_user_info">@lang('e-document.user.personal_information.information')</h4>
                        <div class="user_result">
                            <p>
                                <span class="edit_info_left">@lang('e-document.user.personal_information.username')</span>
                                <span class="equal_info_right">{{ auth()->user()->username }}</span>
                            </p>
                            <p>
                                <span class="edit_info_left">@lang('e-document.user.personal_information.email')</span>
                                <span class="equal_info_right">{{ auth()->user()->email }}</span>
                            </p>
                            <p>
                                <span class="edit_info_left">@lang('e-document.user.personal_information.free_download')</span>
                                <span class="equal_info_right">{{ auth()->user()->free_download }}</span>
                            </p>
                            <p>
                                <span class="edit_info_left">@lang('e-document.user.personal_information.status')</span>
                                <span class="equal_info_right">{{ auth()->user()->status }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="line_array"></div>
                    <div class="edit_from_user">
                        <h4 class="title_user_info">
                            @lang('e-document.user.personal_information.security')
                            <a href="javascript:void(0)" class="icon_edit_info filter icon" onclick="edit_user(this); return">
                                @lang('e-document.user.personal_information.btn_change')
                            </a>
                        </h4>
                        <p>
                            <span class="edit_info_left">@lang('e-document.user.personal_information.password')</span>
                            <span class="equal_info_right">****************</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
