@php
    $productImage = getProductImage($item->product_id)
@endphp

<div class="flex-end">
    <div class="flex">
        <div class="photo">
            @if (!empty($productImage->image))
                <img class="product" src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
            @else
                <img class="product" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
            @endif 
        </div>
        <div class="product-details-name">
            <h3>{{ $item->name }}</h3>
            <p class="m-0 text-muted">Size: {{ $item->product->size?->name ?? 'N/A' }},                                                                 
                @if($item->product->color)
                    Color: <span class="color-small" style="background:{{ $item->product->color->code }}"></span>
                @endif
            </p>
        </div>
    </div>
    <div class="next-arrow">    
        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 7L15 12L10 17" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div> 
</div>  