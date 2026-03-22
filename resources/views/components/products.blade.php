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

            @if ($product->images && $product->images->count() > 0)
                <p class="gallery-icon">
                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.5116 10.0771C18.5116 10.8157 17.8869 11.4146 17.1163 11.4146C16.3457 11.4146 15.7209 10.8157 15.7209 10.0771C15.7209 9.33841 16.3457 8.7396 17.1163 8.7396C17.8869 8.7396 18.5116 9.33841 18.5116 10.0771Z" fill="#ffffff"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.0363 5.53245C16.9766 5.39588 15.6225 5.39589 13.9129 5.39591H10.0871C8.37751 5.39589 7.02343 5.39588 5.9637 5.53245C4.87308 5.673 3.99033 5.96913 3.29418 6.63641C2.59803 7.30369 2.28908 8.14982 2.14245 9.19521C1.99997 10.211 1.99999 11.5089 2 13.1475V13.2482C1.99999 14.8868 1.99997 16.1847 2.14245 17.2005C2.28908 18.2459 2.59803 19.092 3.29418 19.7593C3.99033 20.4266 4.87307 20.7227 5.9637 20.8633C7.02344 20.9998 8.37751 20.9998 10.0871 20.9998H13.9129C15.6225 20.9998 16.9766 20.9998 18.0363 20.8633C19.1269 20.7227 20.0097 20.4266 20.7058 19.7593C21.402 19.092 21.7109 18.2459 21.8575 17.2005C22 16.1847 22 14.8868 22 13.2482V13.1476C22 11.5089 22 10.211 21.8575 9.19521C21.7109 8.14982 21.402 7.30369 20.7058 6.63641C20.0097 5.96913 19.1269 5.673 18.0363 5.53245ZM6.14963 6.858C5.21373 6.97861 4.67452 7.20479 4.28084 7.58215C3.88716 7.9595 3.65119 8.47635 3.52536 9.37343C3.42443 10.093 3.40184 10.9923 3.3968 12.1686L3.86764 11.7737C4.99175 10.8309 6.68596 10.885 7.74215 11.8974L11.7326 15.7223C12.1321 16.1053 12.7611 16.1575 13.2234 15.8461L13.5008 15.6593C14.8313 14.763 16.6314 14.8668 17.8402 15.9096L20.2479 17.9866C20.3463 17.7226 20.4206 17.4075 20.4746 17.0223C20.6032 16.106 20.6047 14.8981 20.6047 13.1979C20.6047 11.4976 20.6032 10.2897 20.4746 9.37343C20.3488 8.47635 20.1128 7.9595 19.7192 7.58215C19.3255 7.20479 18.7863 6.97861 17.8504 6.858C16.8944 6.7348 15.6343 6.73338 13.8605 6.73338H10.1395C8.36575 6.73338 7.10559 6.7348 6.14963 6.858Z" fill="#ffffff"/>
                        <path d="M17.0863 2.61039C16.2265 2.49997 15.1318 2.49998 13.7672 2.5H10.6775C9.31284 2.49998 8.21815 2.49997 7.35834 2.61039C6.46796 2.72473 5.72561 2.96835 5.13682 3.53075C4.79725 3.8551 4.56856 4.22833 4.41279 4.64928C4.91699 4.41928 5.48704 4.28374 6.12705 4.20084C7.21143 4.06037 8.597 4.06038 10.3463 4.06039H14.2612C16.0105 4.06038 17.396 4.06037 18.4804 4.20084C19.0394 4.27325 19.545 4.38581 20 4.56638C19.8454 4.17917 19.625 3.83365 19.3078 3.53075C18.719 2.96835 17.9767 2.72473 17.0863 2.61039Z" fill="#ffffff"/>
                    </svg>
                </p>
            @endif

            <div class="product-slider">
                @if($slider)
                    @if ($product->images && $product->images->count() > 0)
                        @foreach($product->images as $image)
                            <div class="slider-item">   
                                <a href="{{ route('front.product', [
                                    $product->category->category_slug,  
                                    $product->subCategory->sub_category_slug,                               
                                    $product->subSubCategory->sub_sub_category_slug,
                                    'slug' => $product->slug]) }}" target="_blank" title="{{ $product->slug }}">
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
                    <p class="show-size">Size: {{ $product->size->code ?? '' }}</p>
                </div>  

                <div class="product-info">
                    <h2>{{ Str::limit($product->title, 27, '...') }}</h2>
                    <p class="short">{{ Str::limit($product->short_description, 30, '...') }}</p>         
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
                @php
                    $discountPercent = optional($product->discount->percentage)->percentage	?? 0;
                    $discountPrice = $product->price - ($product->price * $discountPercent / 100);
                @endphp

                @if($discountPercent > 0)
                    <span class="dark">₹{{ round($discountPrice) }}</span>
                    <span class="mrp">MRP <del>₹{{ $product->price }}</del></span>
                    <span class="discount">{{ $discountPercent }}% OFF</span>
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
                <h2>{{ Str::limit($subcategory->sub_category_name, 27, '...') }}</h2>
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
            
            <a href="{{ route('front.product', $wishlist->product->slug) }}" target="_blank" class="product-img">
                @if($image)
                    <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="rounded" alt="{{ $wishlist->product->title }}">
                @else
                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" class="rounded">
                @endif
            </a>              
            
            <div class="hover-product">    
                <button onclick="wishlistToCart({{ $wishlist->id }}, {{ $wishlist->product_id }})" class="btn btn-outline-danger btn-sm" type="button">
                    <i class="fas fa-trash-alt me-2"></i> Move to Bag
                </button>
                <p class="show-size">Size: {{ $wishlist->product->size->code ?? '' }}</p>
            </div>

            <div class="product-info">
                <h2>{{ Str::limit($wishlist->product->title, 25, '...') }}</h2>
                <p class="short">{{ Str::limit($wishlist->product->short_description, 30, '...') }}</p>                                                                
            </div>

            <div class="price">
                <span class="dark">₹ {{ $wishlist->product->price }}</span>
                @if ($wishlist->product->compare_price > 0)
                    <span class="h6 text-underline">
                        <del>₹ {{ $wishlist->product->compare_price }}</del>
                    </span>
                    @php
                        $discount = round((($wishlist->product->compare_price - $wishlist->product->price) / $wishlist->product->compare_price) * 100);
                    @endphp
                    <span class="discount">{{ $discount }}% OFF</span>
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