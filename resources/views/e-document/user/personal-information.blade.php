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
                            <a href="javascript:void(0)" class="icon_edit_title filter icon" onclick="editUser(this)">
                                @lang('e-document.user.personal_information.btn_change')
                            </a>
                        </h4>
                        <div class="user_result">
                            <h3 class="ad_user_name edit_name">{{ auth()->user()->firstname }}</h3>
                        </div>
                        <div class="user_no_result">
                            {{ Form::open() }}
                                <span class="ip_name_edit">
                                    {{ Form::text('firstname', auth()->user()->firstname, ['class' => 'edit_ip_name']) }}
                                </span>
                                {{ Form::button(trans('e-document.user.personal_information.btn_save'), [
                                    'class' => 'smt_edit_info',
                                    'onclick' => 'changeUserInformation()',
                                    ])
                                }}
                                <a href="javascript:void(0)" class="smt_exit" onclick="exitUser(this)">
                                    @lang('e-document.user.personal_information.btn_cancel')
                                </a>
                            {{ Form::close() }}
                        </div>
                    </div>  
                    <div class="line_array"></div>
                    <div class="edit_from_user">
                        <h4 class="title_user_info">
                            @lang('e-document.user.personal_information.last_name')
                            <a href="javascript:void(0)" class="icon_edit_title filter icon" onclick="editUser(this)">
                                @lang('e-document.user.personal_information.btn_change')
                            </a>
                        </h4>
                        <div class="user_result">
                            <h3 class="ad_user_name edit_name">{{ auth()->user()->lastname }}</h3>
                        </div>
                        <div class="user_no_result">
                            {{ Form::open() }}
                                <span class="ip_name_edit">
                                    {{ Form::text('lastname', auth()->user()->lastname, ['class' => 'edit_ip_name']) }}
                                </span>
                                {{ Form::button(trans('e-document.user.personal_information.btn_save'), [
                                    'class' => 'smt_edit_info',
                                    'onclick' => 'changeUserInformation()',
                                    ])
                                }}
                                <a href="javascript:void(0)" class="smt_exit" onclick="exitUser(this)">
                                    @lang('e-document.user.personal_information.btn_cancel')
                                </a>
                            {{ Form::close() }}
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
                            <a href="javascript:void(0)" class="icon_edit_info filter icon" onclick="editUser(this)">
                                @lang('e-document.user.personal_information.btn_change')
                            </a>
                        </h4>
                        <div class="user_result">
                            <p>
                                <span class="edit_info_left">@lang('e-document.user.personal_information.oldpassword')</span>
                                <span class="equal_info_right">****************</span>
                            </p>
                        </div>
                        <div class="user_no_result">
                            {{ Form::open(['method' => 'PUT', 'route' => 'user.change_password']) }}
                                <p>
                                    <span class="edit_info_left">@lang('e-document.user.personal_information.oldpassword')</span>
                                    <span class="equal_info_right">
                                        {{ Form::password('oldpassword', ['class' => 'user_address_edit', 'id' => 'oldpassword']) }}
                                    </span>
                                </p>
                                <p>
                                    <span class="edit_info_left">@lang('e-document.user.personal_information.password')</span>
                                    <span class="equal_info_right">
                                        {{ Form::password('password', ['class' => 'user_address_edit', 'id' => 'password']) }}
                                    </span>
                                </p>
                                <p>
                                    <span class="edit_info_left">@lang('e-document.user.personal_information.password_confirmation')</span>
                                    <span class="equal_info_right">
                                        {{ Form::password('password_confirmation', ['class' => 'user_address_edit', 'id' => 'password_confirmation']) }}
                                    </span>
                                </p>
                                {{ Form::button(trans('e-document.user.personal_information.btn_change'), [
                                    'class' => 'smt_edit_info smt_info',
                                    'onclick' => 'changePassword(this)',
                                    ])
                                }}
                                <a href="javascript:void(0)" class="smt_exit" onclick="exitUser(this)">
                                    @lang('e-document.user.personal_information.btn_cancel')
                                </a>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        /* personal information */

        function editUser(self) {
            $(self).parents('.edit_from_user').find('.user_result').hide();
            $(self).parents('.edit_from_user').find('.user_no_result').show();
        }

        function exitUser(self) {
            $(self).parents('.edit_from_user').find('.user_result').show();
            $(self).parents('.edit_from_user').find('.user_no_result').hide();
        }

        function changeUserInformation() {

        }

        function changePassword(self) {
            var form = $(self).parents('.user_no_result').find('form');
            var oldpassword = form.find('#oldpassword').val();
            var password = form.find('#password').val();
            var password_confirmation = form.find('#password_confirmation').val();

            if (password !== password_confirmation) {
                alert(Lang.get('e-document.user.personal_information.message.password_not_match'));
                return;
            }

            var url = form.attr('action');
            $.ajax({
                url: url,
                type:'POST',
                dataType: 'json',
                data: form.serialize(),
                success: function (data) {
                    form.find('#password').val('');
                    form.find('#password_confirmation').val('');
                    $('.info_user_cnt .alert').remove();
                    if(data.status == 200){
                        $('.info_user_cnt').prepend('<div class="alert alert_success">' + Lang.get('') + '</div>');
                    } else {

                    }
                },
                error: function (data) {
                    $('.info_user_cnt .alert').remove();
                    if(data.status == 422) {
                        var error = data.responseJSON;
                        var errors = error.errors;
                        $('.info_user_cnt').prepend('<div class="alert alert_warning">' + error.message + '</div>');
                        $.each(errors, function (key, value) {
                            $('.info_user_cnt .alert').append('<br>' + value);
                        });
                    } else {
                        // Error
                        // Incorrect credentials
                        $('#upload-result .tr_uploadNotifi').remove();
                        $('#upload-result ').prepend('<tr class="tr_uploadNotifi error"><td colspan="2"><span><i class="icon"></i>  Incorrect credentials. Please try again.</span></td></tr>');
                    }
                }
            });
        }
    </script>
@endsection
