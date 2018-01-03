@if(Session::has('message'))
    <div class="notification" data-type="{{ Session::get('alert-type', 'info') }}" data-message="{{ Session::get('message') }}"></div>
@elseif(Session::has('errors'))
    <div class="notification" data-type="error" data-message="@lang('admin.tag.message.edit-error')"></div>
@endif
