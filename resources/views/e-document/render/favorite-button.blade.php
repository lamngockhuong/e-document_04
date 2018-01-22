@if (count($document->favorites))
    <a data-url="{{ route('document.addToFavorites') }}" data-id="{{ $document->id }}" data-status="1" href="javascript:void(0)" id="add-to-favorite" class="upload_earn_money">
        <label>@lang('e-document.document.detail.remove_from_favorite')</label>
    </a>
@else
    <a data-url="{{ route('document.addToFavorites') }}" data-id="{{ $document->id }}" data-status="0" href="javascript:void(0)" id="add-to-favorite" class="upload_earn_money">
        <label>@lang('e-document.document.detail.add_to_favorite')</label>
    </a>
@endif
