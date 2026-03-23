<div class="filter-group">
    <h5>{{ $title }}</h5>

    @php
        $selected = request()->get($type) ? explode(',', request()->get($type)) : [];
    @endphp

    <div class="{{ $items->count() > 5 ? 'filter-scroll' : '' }}">
        @if($items->isNotEmpty())
            @foreach($items as $item)
                <div class="form-check">
                    <label class="form-check-label" for="{{ $type }}-{{ $item->id }}">
                        <input class="form-check-input {{ $type }}-label" type="checkbox"
                            name="{{ $type }}[]" value="{{ $item->$valueField }}" id="{{ $type }}-{{ $item->id }}"
                            {{ in_array($item->$valueField, $selected) ? 'checked' : '' }} >

                        @if($showColor && isset($item->code))
                            <span class="color-code" style="background-color: {{ $item->code }}"></span>
                        @endif

                        <span class="{{ $nameClass ?? $type.'-name' }}">
                            {{ (isset($limit)
                                ? Str::limit($item->$labelField, $limit, '...')
                                : $item->$labelField) . ($showPercent ? '%' : '') }}
                        </span>

                        @if(isset($item->products_count))
                            <span class="text-muted">({{ $item->products_count }})</span>
                        @endif
                    </label>
                </div>
            @endforeach
        @endif
    </div>
</div>