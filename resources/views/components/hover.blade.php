@props([
    'product' => null,
    'selected_item1' => null,
    'selected_item2' => null,
    'selected_item3' => null,
    'category' => null,
    'subcategory' => null,
    'wishlist' => null,
    'class' => null,   
    "section" => null,    
    "variable" => null,    
])

@if($section == 'show_products')   
    <div class="hover-product">
        @if (Auth::check())
            <a onclick="addToWishlist({{ $product->id }})" class="btn btn-outline" href="javascript:void(0)">
                <span class="sprites wishlist-ico-btn"></span>
                Wishlist
            </a>
        @else
            <a class="btn btn-outline" href="#" data-bs-toggle="modal" data-bs-target="#login">
                <span class="sprites wishlist-ico-btn"></span>
                Wishlist
            </a>
        @endif
    </div>                

@elseif($section == 'show_category')
     <div class="hover-product">                    
        <a href="{{ route('front.category', [$category->category_slug]) }}" class="btn btn-primary">Shop Now</a>                
    </div>

    <div class="product-info">
        <h2>{{ Str::limit($subcategory->sub_category_title, 27, '...') }}</h2>
        {{-- <h2>{{ Str::limit($category->category_name, 27, '...') }}</h2> --}}
    </div>      
    
    <div class="price">
        <p class="text-muted"><b>{{ $category->products_count }} Products</b></p>
    </div>
@elseif($section == 'show_subcategory')
    <div class="hover-product">   
        <a href="" class="btn btn-primary">Shop Now</a>
        {{-- <a href="{{ route('front.subcategory', [${$variable}->sub_category_slug]) }}" class="btn btn-primary">Shop Now</a> --}}
    </div>
@elseif($section == 'show_wishlist')
     <div class="hover-product">    
        <button 
            class="btn btn-outline-danger btn-sm move-to-cart"
            data-wishlist-id="{{ $wishlist->id }}"
            data-product-id="{{ $wishlist->product_id }}"
            data-size-id="{{ optional($wishlist->product->sizes->first())->id }}"
            data-color-id="{{ optional($wishlist->product->colors->first())->id }}"
            type="button">
            Move to Bag
        </button>                
        <p class="show-size">
            @if(optional($wishlist->product->sizes->first())->code)
                Size: {{ optional($wishlist->product->sizes->first())->code ?? 'N/A' }} |    
            @endif

            @if(optional($wishlist->product->colors->first())->name)
                Color: {{ optional($wishlist->product->colors->first())->name ?? 'N/A' }}   
            @endif
        </p>
    </div>
@endif