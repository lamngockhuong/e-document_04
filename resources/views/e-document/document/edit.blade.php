@extends('e-document.layouts.template')
@section('title', $title)
@push('style')
    {!! Html::style('templates/e-document/css/upload.css') !!}
@endpush
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
            <h3 class="ad_user_name">@lang('e-document.document.edit.title')</h3>
            <div class="box_content content_user_info">
                <table class="upload-result" id="edit-document">
                    <tbody style="background-color: #fff">
                    <tr class="tr_info">
                        <td class="colum_left">
                            <div class="change_avarta_doc">
                                <a href="javascript:;" class="change_avatar">
                                    <img alt="" src="{{ asset('templates/e-document/images/bg_changeImg.jpg') }}">
                                </a>
                                {{ Form::open(['files' => true, 'method' => 'POST']) }}
                                {{ Form::file('image', ['class' => 'input_avatar', 'id' => 'image']) }}
                                <a href="javascript://" class="edit_avatar"></a>
                                {{ Form::close() }}
                            </div>
                        </td>
                        <td class="colum_right">
                            {{ Form::open(['route' => ['document-manager.update', $document->id], 'class' => 'edit-form', 'method' => 'PUT']) }}
                            <table class="tbl_info_document">
                                <tbody>
                                <tr>
                                    <td class="info-th">
                                        {!! Form::label('title', trans('e-document.document.create.upload-form.title'), [], false) !!}
                                    </td>
                                    <td>
                                        {{ Form::text('title', $document->title, ['class' => 'txt-name', 'placeholder' => trans('e-document.document.create.upload-form.title_placeholder')]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info-th">
                                        {!! Form::label('category', trans('e-document.document.create.upload-form.category')) !!}
                                    </td>
                                    <td>
                                        {{ Form::hidden('subcategories-url', route('document-manager.subcategories', ['id' => 'categoryId']), ['id' => 'subcategories-url']) }}
                                        {{ Form::select('category', $categories, $category, ['class' => 'opts-cat parent-category']) }}
                                        {{ Form::hidden('subcategory-none', trans('admin.category.none'), ['id' => 'subcategory-none', 'data-id' => config('setting.category.none')]) }}
                                        {{ Form::select('subcategory', $subCategories, $subCategory, ['class' => 'opts-cat subcategory'] + (count($subCategories) > 1 ? [] : ['disabled' => 'disabled'])) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info-th">
                                        {!! Form::label('tag', trans('e-document.document.create.upload-form.tag'), [], false) !!}
                                    </td>
                                    <td>
                                        <div class="tags" data-wmin="100" data-wmax="538">
                                            <ul class="list-tag">
                                            </ul>
                                            {{ Form::text('tag', '', ['class' => 'text-input-tag', 'data-tag' => 'true', 'placeholder' => trans('e-document.document.create.upload-form.tag_placeholder')]) }}
                                            <ul class="list-result"></ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="suggest_words">
                                            <ul></ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info-th default-head">
                                        {!! Form::label('description', trans('e-document.document.create.upload-form.description')) !!}
                                    </td>
                                    <td>
                                        {{ Form::textarea('description', $document->description, ['class' => 'txt-des', 'placeholder' => trans('e-document.document.create.upload-form.description_placeholder')]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="info-th default-head">
                                        {!! Form::label('coin', trans('e-document.document.create.upload-form.price')) !!}
                                    </td>
                                    <td>
                                        <div class="price_div">
                                            {{ Form::text('coin', $document->coin, ['list' => 'prices', 'placeholder' => trans('e-document.document.create.upload-form.price_placeholder')]) }}
                                            <datalist class="opts-set-price" id="prices">
                                                <option value="@lang('e-document.document.create.upload-form.price_0')">
                                                <option value="@lang('e-document.document.create.upload-form.price_2000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_3000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_4000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_5000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_7000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_10000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_14000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_15000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_20000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_37000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_38000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_50000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_77000')">
                                                <option value="@lang('e-document.document.create.upload-form.price_100000')">
                                            </datalist>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <p class="line_space"></p>
                                        <div class="btn-save">@lang('e-document.document.create.upload-form.btnsave')</div>
                                        <i class="note_save">@lang('e-document.document.create.upload-form.status')</i>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            {{ Form::open() }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
