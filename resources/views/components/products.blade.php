@props([
    'product' => null,
    'selected_item1' => null,
    'selected_item2' => null,
    'selected_item3' => null,
    'category' => null,
    'subcategory' => null,
    'wishlist' => null,
    'class' => null,   
    'brand' => null, 
    'showWishlist' => true,
    'slider' => true,
    'hover' => true,    
])

@if($product)
    <div class="product-card">
        <div class="product-image-wrapper {{ $class }}">
            @php
                $rating = $product->average_rating ?? 0;
                $count  = $product->rating_count ?? 0;
            @endphp

            @if ($count > 0)
                <div class="rating-wrapper">
                    <small>
                        {{ $product->average_rating }}
                        <svg fill="#666666" width="15px" height="15px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1915.918 737.475c-10.955-33.543-42.014-56.131-77.364-56.131h-612.029l-189.063-582.1v-.112C1026.394 65.588 995.335 43 959.984 43c-35.237 0-66.41 22.588-77.365 56.245L693.443 681.344H81.415c-35.35 0-66.41 22.588-77.365 56.131-10.955 33.544.79 70.137 29.478 91.03l495.247 359.831-189.177 582.212c-10.955 33.657 1.13 70.25 29.817 90.918 14.23 10.278 30.946 15.487 47.66 15.487 16.716 0 33.432-5.21 47.775-15.6l495.134-359.718 495.021 359.718c28.574 20.781 67.087 20.781 95.662.113 28.687-20.668 40.658-57.261 29.703-91.03l-189.176-582.1 495.36-359.83c28.574-20.894 40.433-57.487 29.364-91.03" fill-rule="evenodd"/>
                        </svg> 
                        <small>{{ $product->rating_count ?? 0 }}</small>
                    </small>
                </div>
            @endif        
            
            {{-- <div class="gallery-icon">
                <div class="color-details">
                    @if ($product->variant_images && $product->variant_images->count() > 0)
                        <div class="img-group">
                            @foreach($product->variant_images as $image)
                                <span class="ms-n3">
                                    <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="variant-image" >
                                </span>
                            @endforeach
                        </div>
                    @else
                        <ul class="size-list-small">                        
                            <div class="img-group">
                                @foreach($product->colors as $color)
                                    <li>
                                        <p class="ms-n3 show-tooltip">
                                            <span class="color" style="background-color: {{ $color->code }}"></span>
                                            <span class="tooltip" style="bottom: 27px;">{{ $color->name }}</span>
                                        </p>                                        
                                    </li>
                                @endforeach                       
                            </div>
                        </ul>
                    @endif
                </div>
            </div> --}}

            <div class="product-slider">
                @if($slider)
                    @if ($product->images && $product->images->count() > 0)
                        @foreach($product->images as $image)
                            <div class="slider-item">   
                                <a href="{{ $product->url }}" target="_blank" title="{{ $product->slug }}">
                                    <img src="{{ asset('uploads/product/small/'.$image->image) }}">
                                    {{-- <img src="{{ asset('uploads/product/small/'.$product->images->first()->image) }}" > --}}
                                </a>
                            </div>
                        @endforeach
                    @else
                        <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                    @endif
                @else
                    @php
                        $productImage = $product->product_images->first();
                    @endphp                                    
                    <a href="{{ route('front.product',$product->slug) }}" class="product-img" target="_blank">
                        <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" class="img-fluid" alt="{{ $product->title }}" >
                    </a>                                    
                @endif
            </div>            
            
            @if($hover)
                <div class="product-info">
                    <h2>{{ Str::limit($product->title, 27, '...') }}</h2>
                    <p class="short">{{ Str::limit($product->short_description, 30, '...') }}</p>         
                </div>

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
                    
                    {{-- <div class="size-wrapper">
                        <p class="tiny-font mt-1">Sizes:</p>
                        <ul class="size-list-small">                        
                            @foreach($product->sizes as $size)
                                <li>
                                    <a href="javascript:void(0);" class="size-option show-tooltip">
                                        <span>{{ $size->code }}</span>
                                        <span class="tooltip" style="bottom: 27px;">{{ $size->name }}</span>
                                    </a>
                                </li>
                            @endforeach                       
                        </ul>
                    </div> --}}
                </div>  
            @else
                <div class="product-info">
                    <div class="flex-end">
                        <h2>{{ Str::limit($product->title, 27, '...') }}</h2>
                        @if (Auth::check())
                            <a onclick="addToWishlist({{ $product->id }})" href="javascript:void(0)">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="none" viewBox="0 0 24 24" style="font-size: 20px;" stroke="none"><g clip-path="url(#header_icon_wishlist_svg__a)"><path stroke="#303030" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20S3 14.91 3 8.727c0-1.093.375-2.152 1.06-2.997a4.672 4.672 0 0 1 2.702-1.638 4.639 4.639 0 0 1 3.118.463A4.71 4.71 0 0 1 12 6.909a4.71 4.71 0 0 1 2.12-2.354 4.639 4.639 0 0 1 3.118-.463 4.672 4.672 0 0 1 2.701 1.638A4.756 4.756 0 0 1 21 8.727C21 14.91 12 20 12 20Z"></path></g><defs><clipPath id="header_icon_wishlist_svg__a"><path fill="#fff" d="M0 0h24v24H0z"></path></clipPath></defs></svg>
                            </a>
                        @else
                            <a href="#" data-bs-toggle="modal" data-bs-target="#login">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="none" viewBox="0 0 24 24" style="font-size: 20px;" stroke="none"><g clip-path="url(#header_icon_wishlist_svg__a)"><path stroke="#303030" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 20S3 14.91 3 8.727c0-1.093.375-2.152 1.06-2.997a4.672 4.672 0 0 1 2.702-1.638 4.639 4.639 0 0 1 3.118.463A4.71 4.71 0 0 1 12 6.909a4.71 4.71 0 0 1 2.12-2.354 4.639 4.639 0 0 1 3.118-.463 4.672 4.672 0 0 1 2.701 1.638A4.756 4.756 0 0 1 21 8.727C21 14.91 12 20 12 20Z"></path></g><defs><clipPath id="header_icon_wishlist_svg__a"><path fill="#fff" d="M0 0h24v24H0z"></path></clipPath></defs></svg>
                            </a>
                        @endif
                    </div>
                    
                    <p class="short">{{ Str::limit($product->short_description, 30, '...') }}</p>         
                </div>                
            @endif            

            <div class="price">                
                @if($product->discount_percent > 0)
                    <span class="dark">₹{{ round($product->discount_price) }}</span>
                    <span class="mrp"><del>₹{{ $product->price }}</del></span>
                    <span class="discount">({{ $product->discount_percent }}% OFF)</span>
                @else
                    <span class="dark">₹{{ number_format($product->price, 2) }}</span>
                @endif
            </div>  
        </div>
    </div> 

@elseif($subcategory)    
    <div class="product-card">
        <div class="product-image-wrapper {{ $class }}">    
            <a href="{{ route('front.subcategory', [$subcategory->sub_category_slug]) }}" >
                @if ($subcategory->image != "")
                    <img src="{{ asset('uploads/category/'.$subcategory->image) }} " alt="" class="product-img rounded">
                @else
                    <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                @endif
            </a>

            <div class="hover-product">   
                {{-- <a href="{{ route('front.shop', [$item1->category_slug, $item2->sub_category_slug]) }}">
                    Shop Now
                </a>                  --}}
                <a href="{{ route('front.subcategory', [$subcategory->sub_category_slug]) }}" class="btn btn-primary">Shop Now</a>
            </div>

            <div class="product-info">
                <h2>{{ Str::limit($subcategory->sub_category_title, 27, '...') }}</h2>
                {{-- <h2>{{ Str::limit($category->category_name, 27, '...') }}</h2> --}}
            </div>      
            
            <div class="price">
                <p class="text-muted"><b>{{ $category->products_count }} Products</b></p>
            </div>

            {{-- @elseif($category)        
            <a href="{{ route('front.category', [$category->category_slug]) }}" >
                @if ($category->image != "")
                    <img src="{{ asset('uploads/category/'.$category->image) }} " alt="" class="product-img rounded">
                @else
                    <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                @endif
            </a>

            <div class="hover-product">                    
                <a href="{{ route('front.category', [$category->category_slug]) }}" class="btn btn-primary">Shop Now</a>                
            </div>

            <div class="product-info">
                <h2>{{ Str::limit($category->category_name, 27, '...') }}</h2>
            </div>      
            
            <div class="price">
                <p class="text-muted"><b>{{ $category->products_count }} Products</b></p>
            </div> --}}
        </div>
    </div>

@elseif($wishlist)
    <div class="product-card">
        <div class="product-image-wrapper {{ $class }}">   
            @if ($wishlist->product->qty < 1)
                <div class="out-stock"><span>Out of Stock</span></div>
            @endif   

            @php
                $image = $wishlist->product->images->first();
            @endphp

            {{-- <button onclick="removeProduct({{ $wishlist->product_id }})" class="remove-wishlst-item" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="#282C3F" fill-rule="nonzero" d="M15.854 8.146a.495.495 0 0 0-.703 0L12 11.296l-3.15-3.15a.495.495 0 0 0-.704 0 .495.495 0 0 0 0 .703L11.297 12l-3.15 3.15a.5.5 0 1 0 .35.85.485.485 0 0 0 .349-.146l3.15-3.15 3.151 3.15a.5.5 0 0 0 .35.147.479.479 0 0 0 .35-.147.495.495 0 0 0 0-.703L12.702 12l3.15-3.15a.495.495 0 0 0 0-.704z"></path></svg>
            </button> --}}
            
            <a href="{{ $wishlist->product->url }}" target="_blank" class="product-img">
                @if($image)
                    <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="rounded" alt="{{ $wishlist->product->title }}">
                @else
                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" class="rounded">
                @endif
            </a>            
            
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

            <div class="product-info">
                <h2>{{ Str::limit($wishlist->product->title, 25, '...') }}</h2>
                <p class="short">{{ Str::limit($wishlist->product->short_description, 30, '...') }}</p>                                                                
            </div>

            <div class="price">                
                @if($wishlist->product->discount_percent > 0)
                    <span class="dark">₹{{ round($wishlist->product->discount_price) }}</span>
                    <span class="mrp"><del>₹{{ $wishlist->product->price }}</del></span>
                    <span class="discount">({{ $wishlist->product->discount_percent }}% OFF)</span>
                @else
                    <span class="dark">₹{{ number_format($wishlist->product->price, 2) }}</span>
                @endif
            </div>
        </div>
    </div>

@elseif($brand)        
    @if($slider)
        <a href="{{ route('front.shop') }}?brand={{ $brand->slug }}" class="brand-details">
            <div class="photo">
                <img src="{{ asset('uploads/brands/' . $brand->logo) }}" class="logo">
                <img src="{{ asset('uploads/brands/' . $brand->model) }}" class="model">
            </div>
            <div class="details">
                <p class="title">{{ $brand->description }}</p>
                <p class="discount">{{ $brand->discount }}</p>
            </div>
        </a>
    @endif        
@endif