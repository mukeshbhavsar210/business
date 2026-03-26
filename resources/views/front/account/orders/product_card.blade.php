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
            <h3>{{ $item->product->title }}</h3>
            <p>{{ $item->product->short_description }}</p>
            
            <p class="m-0 text-muted tiny-font">
                @if($item->size)
                    Size: <b>{{ $item->size }}</b>,
                @endif                
                
                @if($item->color)
                    Color: <b>{{ $item->color }}</b>
                @endif
            </p>

            @if(ucfirst($status) == 'Delivered')
                <div class="exchange-text">
                    <span class="sprites tick-icon"></span>                    
                    <p class="tiny-font">Exchange/Return window closed on Sun, <b>2 Mar</b> 2025</p>
                </div>
            @endif
        </div>
    </div>
    <div class="next-arrow"> 
        <span class="sprites"></span>
    </div> 
</div> 