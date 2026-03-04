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
    <div>></div> 
</div>  