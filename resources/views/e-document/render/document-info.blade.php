<tr class="tr_uploadNotifi success">
    <td colspan="2">
        @lang('e-document.document.create.document-info.upload_success')
    </td>
</tr>
<tr class="tr_infoDoc_success">
    <td>
        <a target="_blank" href="{{ $document->source }}"><img src="{{ $document->image }}" onerror="this.src='{{ asset('templates/e-document/images/user_small.png') }}'"></a>
    </td>
    <td>
        <div>
            <h3>
                <a target="_blank" href="{{ $document->source }}">{{ $document->title }}</a>
            </h3>
            <p>
                <b>@lang('e-document.document.create.document-info.category'):</b>
                @if ($category->termTaxonomy->taxonomyParent)
                    <a href="#" target="_blank">{{ $category->termTaxonomy->taxonomyParent->term->name }}</a>
                    <span> » </span>
                @endif
                <a href="#" target="_blank">{{ $category->name }}</a>
            </p>
            <p><b>@lang('e-document.document.create.document-info.description'): </b>{{ $document->description }}</p>
            <p><b>@lang('e-document.document.create.document-info.tag'):</b></p>
            <p><b>@lang('e-document.document.create.document-info.price'):</b> {{ $document->coin }} @lang('e-document.document.create.document-info.price_symbol')</p>
        </div>
    </td>
</tr>
