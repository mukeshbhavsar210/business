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
        </div>
    </div>
    <div class="next-arrow">    
        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10 7L15 12L10 17" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div> 
</div> 

@if(ucfirst($status) == 'Delivered')
    <div class="exchange-text">
        <p class="icon">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><circle cx="8" cy="8" r="8" fill="url(#paint0_linear_4639_7258)"></circle><path d="M5.0625 8.0625L7.3125 10.3125L11.4375 6.1875" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><defs><linearGradient id="paint0_linear_4639_7258" x1="4.29253e-10" y1="4.74074" x2="16.003" y2="4.56133" gradientUnits="userSpaceOnUse">
                <stop stop-color="#666666"></stop>
                <stop offset="1" stop-color="#666666"></stop>
            </linearGradient></defs>
            </svg>
        </p>
        <p class="tiny-font">Exchange/Return window closed on Sun, <b>2 Mar</b> 2025</p>
    </div>
@endif