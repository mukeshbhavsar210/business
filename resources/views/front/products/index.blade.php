@extends('front.layouts.app')

@section('title', $product->title . ' - ' .$product->short_description . ' | Category: ' . $product->category->category_name . ' | '  . config('app.name'))
@section('meta_description', Str::limit($product->short_description, 155))
@section('meta_keywords', $product->title)

@section('content')

<div class="container">
    <div class="light-font">
        @include('front/layouts/breadcrumb')        
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-12 sticky">
            <div class="row">
                @if(request()->filled('variant') && $selectedVariant && $selectedVariant->image)                    
                    <div class="col-md-12 col-12">
                        <img class="w-100 h-100" src="{{ asset('uploads/product/large/'.$selectedVariant->image) }}" alt="Variant Image">
                    </div>
                @else                    
                    @if ($product->product_images && $product->product_images->count())
                        @foreach ($product->product_images as $productImage)
                            <div class="col-md-6 col-12">
                                <img class="w-100 h-100" src="{{ asset('uploads/product/large/'.$productImage->image) }}" alt="Product Image">
                            </div>
                        @endforeach
                    @endif
                @endif                          
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="product-details-wrapper">
                <h1>{{ $product->title }}</h1>
                <p class="tag">{{ $product->short_description }}</p>

                @php
                    $rating = $product->average_rating ?? 0;
                    $count  = $product->rating_count ?? 0;
                @endphp

                <div class="rating">
                    @php
                        $rating = $product->average_rating ?? 0;
                        $count  = $product->rating_count ?? 0;
                    @endphp
                    
                    @if ($count > 0)
                        <div class="rating-wrapper">
                            <small>
                                <b>{{ $product->average_rating }}</b>
                                <svg fill="#666666" width="14px" height="14px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1915.918 737.475c-10.955-33.543-42.014-56.131-77.364-56.131h-612.029l-189.063-582.1v-.112C1026.394 65.588 995.335 43 959.984 43c-35.237 0-66.41 22.588-77.365 56.245L693.443 681.344H81.415c-35.35 0-66.41 22.588-77.365 56.131-10.955 33.544.79 70.137 29.478 91.03l495.247 359.831-189.177 582.212c-10.955 33.657 1.13 70.25 29.817 90.918 14.23 10.278 30.946 15.487 47.66 15.487 16.716 0 33.432-5.21 47.775-15.6l495.134-359.718 495.021 359.718c28.574 20.781 67.087 20.781 95.662.113 28.687-20.668 40.658-57.261 29.703-91.03l-189.176-582.1 495.36-359.83c28.574-20.894 40.433-57.487 29.364-91.03" fill-rule="evenodd"/>
                                </svg> 
                                <span class="divider">{{ $count }} {{ $count == 1 ? 'Rating' : 'Ratings' }}</span>
                            </small>
                        </div>
                    @endif                       
                </div>
                
                <div class="price-wrapper">
                    <div class="price">
                        <span class="dark">₹{{ $product->price }}</span>
                        @if ($product->compare_price > 0)
                            <span class="mrp">MRP 
                                <del>₹{{ $product->compare_price }}</del>
                            </span>
                            @php
                                $discount = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
                            @endphp
                            <span class="discount">({{ $discount }} OFF)</span>
                        @endif           
                    </div>                                                                                                                                      
                    <p class="inclusive">Inclusive of all taxes</p>
                </div>

                <div class="part mt-1">
                    <h3>More Colors</h3>
                    <ul class="variant">
                        @if($product->images->first())
                            <li>
                                <a href="{{ route('front.product', ['slug' => $product->slug]) }}" class="variant-btn {{ request('variant') ? '' : 'active' }}">
                                    <img src="{{ asset('uploads/product/small/'.$product->images->first()->image) }}" >
                                </a>
                            </li>
                        @endif
                        @foreach ($product->variants as $variant)
                            @if($variant->image)
                                <li id="variant-image-row-{{ $variant->id }}">                                
                                    <a href="{{ route('front.product', ['slug' => $product->slug, 'variant' => $variant->id]) }}" class="variant-btn {{ request('variant') == $variant->id ? 'active' : '' }}">
                                        <input type="hidden" name="existing_variant_images[]" value="{{ $variant->id }}">
                                        <img src="{{ asset('uploads/product/small/'.$variant->image) }}"  />
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul> 
                </div>                

                <div class="part">
                    <h3>Select Size</h3>
                    @if($sizes->isNotEmpty())
                        <ul class="size-list">
                            @foreach($sizes as $size)
                                <li>
                                    <a href="javascript:void(0);" class="size-option" data-size="{{ $size->code }}">
                                        {{ $size->code }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="part">
                    <div class="call-action">
                        @if ($product->track_qty == 'Yes')
                            @if ($product->qty > 0)
                                <a class="btn btn-primary" id="addToCart" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                                    <svg width="27px" height="27px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.74181 20.5545C4.94143 22 7.17414 22 11.6395 22H12.3607C16.8261 22 19.0589 22 20.2585 20.5545M3.74181 20.5545C2.54219 19.1091 2.95365 16.9146 3.77657 12.5257C4.36179 9.40452 4.65441 7.84393 5.7653 6.92196M3.74181 20.5545C3.74181 20.5545 3.74181 20.5545 3.74181 20.5545ZM20.2585 20.5545C21.4581 19.1091 21.0466 16.9146 20.2237 12.5257C19.6385 9.40452 19.3459 7.84393 18.235 6.92196M20.2585 20.5545C20.2585 20.5545 20.2585 20.5545 20.2585 20.5545ZM18.235 6.92196C17.1241 6 15.5363 6 12.3607 6H11.6395C8.46398 6 6.8762 6 5.7653 6.92196M18.235 6.92196C18.235 6.92196 18.235 6.92196 18.235 6.92196ZM5.7653 6.92196C5.7653 6.92196 5.7653 6.92196 5.7653 6.92196Z" stroke="#ffffff" stroke-width="1.5"/>
                                        <path d="M10 14.3C10.5207 14.7686 10.8126 15.0314 11.3333 15.5L14 12.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 6V5C9 3.34315 10.3431 2 12 2C13.6569 2 15 3.34315 15 5V6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    &nbsp;ADD TO BAG
                                </a>
                            @else
                                <a class="btn btn-dark" href="javascript:void(0);">
                                    <svg width="27px" height="27px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.74181 20.5545C4.94143 22 7.17414 22 11.6395 22H12.3607C16.8261 22 19.0589 22 20.2585 20.5545M3.74181 20.5545C2.54219 19.1091 2.95365 16.9146 3.77657 12.5257C4.36179 9.40452 4.65441 7.84393 5.7653 6.92196M3.74181 20.5545C3.74181 20.5545 3.74181 20.5545 3.74181 20.5545ZM20.2585 20.5545C21.4581 19.1091 21.0466 16.9146 20.2237 12.5257C19.6385 9.40452 19.3459 7.84393 18.235 6.92196M20.2585 20.5545C20.2585 20.5545 20.2585 20.5545 20.2585 20.5545ZM18.235 6.92196C17.1241 6 15.5363 6 12.3607 6H11.6395C8.46398 6 6.8762 6 5.7653 6.92196M18.235 6.92196C18.235 6.92196 18.235 6.92196 18.235 6.92196ZM5.7653 6.92196C5.7653 6.92196 5.7653 6.92196 5.7653 6.92196Z" stroke="#ffffff" stroke-width="1.5"/>
                                        <path d="M10 14.3C10.5207 14.7686 10.8126 15.0314 11.3333 15.5L14 12.5" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 6V5C9 3.34315 10.3431 2 12 2C13.6569 2 15 3.34315 15 5V6" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    &nbsp;OUT OF STOCK
                                </a>
                            @endif                        
                        @endif   
                        <a class="btn btn-outline-dark" onclick="addToWishlist({{ $product->id }})" href="javascript:void(0)">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.74181 20.5545C4.94143 22 7.17414 22 11.6395 22H12.3607C16.8261 22 19.0589 22 20.2585 20.5545M3.74181 20.5545C2.54219 19.1091 2.95365 16.9146 3.77657 12.5257C4.36179 9.40452 4.65441 7.84393 5.7653 6.92196M3.74181 20.5545C3.74181 20.5545 3.74181 20.5545 3.74181 20.5545ZM20.2585 20.5545C21.4581 19.1091 21.0466 16.9146 20.2237 12.5257C19.6385 9.40452 19.3459 7.84393 18.235 6.92196M20.2585 20.5545C20.2585 20.5545 20.2585 20.5545 20.2585 20.5545ZM18.235 6.92196C17.1241 6 15.5363 6 12.3607 6H11.6395C8.46398 6 6.8762 6 5.7653 6.92196M18.235 6.92196C18.235 6.92196 18.235 6.92196 18.235 6.92196ZM5.7653 6.92196C5.7653 6.92196 5.7653 6.92196 5.7653 6.92196Z" stroke="#000000" stroke-width="1.5"/>
                                <path d="M12 12.1913L11.4813 12.7331C11.7713 13.0108 12.2287 13.0108 12.5187 12.7331L12 12.1913ZM11.0429 15.8656L10.5992 16.4703L11.0429 15.8656ZM12.9571 15.8656L12.5135 15.2609L12.9571 15.8656ZM12 16.3276L12 17.0776L12 16.3276ZM11.4865 15.2609C11.0686 14.9542 10.6081 14.5712 10.2595 14.1681C9.89122 13.7423 9.75 13.4113 9.75 13.1967H8.25C8.25 13.9666 8.6912 14.6479 9.1249 15.1493C9.57819 15.6735 10.1391 16.1327 10.5992 16.4703L11.4865 15.2609ZM9.75 13.1967C9.75 12.6207 10.0126 12.37 10.2419 12.2896C10.4922 12.2019 10.9558 12.2299 11.4813 12.7331L12.5187 11.6496C11.6943 10.8603 10.6579 10.5543 9.74566 10.8741C8.81245 11.2012 8.25 12.0995 8.25 13.1967H9.75ZM13.4008 16.4703C13.8609 16.1327 14.4218 15.6735 14.8751 15.1493C15.3088 14.6479 15.75 13.9666 15.75 13.1967H14.25C14.25 13.4113 14.1088 13.7423 13.7405 14.1681C13.3919 14.5713 12.9314 14.9542 12.5135 15.2609L13.4008 16.4703ZM15.75 13.1967C15.75 12.0995 15.1875 11.2012 14.2543 10.8741C13.3421 10.5543 12.3057 10.8603 11.4813 11.6496L12.5187 12.7331C13.0442 12.2299 13.5078 12.2019 13.7581 12.2896C13.9874 12.37 14.25 12.6207 14.25 13.1967H15.75ZM10.5992 16.4703C10.9678 16.7407 11.3816 17.0775 12 17.0776L12 15.5776C11.9756 15.5776 11.9605 15.5775 11.9061 15.5488C11.8202 15.5034 11.7128 15.4269 11.4865 15.2609L10.5992 16.4703ZM12.5135 15.2609C12.2872 15.4269 12.1798 15.5034 12.0939 15.5488C12.0395 15.5775 12.0244 15.5776 12 15.5776L12 17.0776C12.6184 17.0776 13.0322 16.7407 13.4008 16.4703L12.5135 15.2609Z" fill="#000000"/>
                                <path d="M9 6V5C9 3.34315 10.3431 2 12 2C13.6569 2 15 3.34315 15 5V6" stroke="#000000" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            Wishlist
                        </a>   
                    </div>
                </div>

                <div class="part">
                    <h3>Delivery Options</h3>
                    <div class="delivery-check">
                        <p>Please enter PIN code to check delivery time & Pay on Delivery Availability</p>
                        @if($product->delivery_min_days)
                            <p>{{ $product->delivery_min_days }}</p>
                            <p>{{ $product->delivery_max_days }}</p>
                        @endif
                    </div>
                    <ul>
                        <li>100% Original Products</li>
                        <li>Pay on delivery might be available</li>
                        @if($product->is_returnable)
                            <li>Easy {{ $product->return_days }} returns and exchanges</li>
                        @else
                            <li>Non-returnable product</li>
                        @endif                       
                    </ul>
                </div>

                <div class="part">
                    <h3>BEST OFFERS</h3>
                    Best Price: Rs. 374

                    {{-- Coupon code: MYNTRASAVE
                    Coupon Discount: 30% off (Your total saving: Rs. 425)
                    Applicable on: Orders above Rs. 750 (only on first purchase)

                    View Eligible Products
                    7.5% Assured Cashback on Flipkart Axis Bank & SBI Credit Cards.
                    Flat 7.5% Cashback on Flipkart Axis Bank & SBI Credit Cards on a min spend of ₹100
                    Terms & Condition --}}
                </div>
                
                <div class="part">
                    <div class="product-details">
                        <h3>Product Details</h3>
                        {!! $product->description !!}
                    </div>
                </div>

                <div class="part">
                    <h3>Specifications</h3>
                </div>

                <div class="part">
                    <h3>Ratings</h3> 
                    <div class="rating-breakdown">
                        <div class="total-numbers">
                            <div class="title">
                                <h4>{{ number_format($averageRating,1) }} </h4>
                                <span class="star">
                                    <svg fill="#666666" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1915.918 737.475c-10.955-33.543-42.014-56.131-77.364-56.131h-612.029l-189.063-582.1v-.112C1026.394 65.588 995.335 43 959.984 43c-35.237 0-66.41 22.588-77.365 56.245L693.443 681.344H81.415c-35.35 0-66.41 22.588-77.365 56.131-10.955 33.544.79 70.137 29.478 91.03l495.247 359.831-189.177 582.212c-10.955 33.657 1.13 70.25 29.817 90.918 14.23 10.278 30.946 15.487 47.66 15.487 16.716 0 33.432-5.21 47.775-15.6l495.134-359.718 495.021 359.718c28.574 20.781 67.087 20.781 95.662.113 28.687-20.668 40.658-57.261 29.703-91.03l-189.176-582.1 495.36-359.83c28.574-20.894 40.433-57.487 29.364-91.03" fill-rule="evenodd"/>
                                    </svg> 
                                </span>
                            </div>                            
                            <p>{{ $totalRatings >= 1000 ? round($totalRatings / 1000, 1).'k' : $totalRatings }} Verified Buyers</p>
                        </div>
                        <div class="breakdown">
                        @foreach($ratings as $star => $count)
                            @php
                                $percentage = $totalRatings > 0 ? ($count / $totalRatings) * 100 : 0;
                                if($star >= 4){
                                    $color = 'green';
                                } elseif($star == 3){
                                    $color = 'yellow';
                                } else {
                                    $color = 'red';
                                }
                            @endphp

                            <div class="rating-row">
                                <div class="rating-label">{{ $star }} ★</div>
                                <div class="rating-bar">
                                    <div class="rating-fill {{ $color }}" style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="rating-count">{{ $count }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                
                    <div class="rating-customers">
                        <p><b>Customer Reviews ({{ $totalReviews }})</b></p>

                        @foreach($reviews as $review)
                            <div class="repeate">
                                <div class="left">
                                    <span class="star">{{ $review->rating }} ★</span>
                                </div>
                                <div class="right">                            
                                    <p>{{ $review->review }}</p>
                                    <p class="customer">
                                        <b>{{ $review->user->name ?? 'Guest' }}</b>
                                        | {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y')}}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                
                        @if($totalReviews > 2)
                            <a href="{{ route('product.reviews', $product->id) }}" class="link">View all {{ $count }} reviews </a>
                        @endif

                        <div class="product-code">
                            Product Code: {{ $product->id }}                            
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    @if($relatedProducts)
        <div class="similar-products">
            <h3>SIMILAR PRODUCTS</h3>
            @foreach($relatedProducts as $product)    
                <div class="col-md-2 col-6">
                    <x-product-card :product="$product" :showWishlist="false"/>
                </div>
            @endforeach       
        </div>
    @endif
</div>    

@endsection

@section('customJs')
<script>
    let selectedColor = '';
    let selectedSize = '';

    $(document).on('click', '.color-option', function(){
        $('.color-option').removeClass('active');
        $(this).addClass('active');

        selectedColor = $(this).data('color');
    });    

    $(document).on('click', '.size-option', function(){
        $('.size-option').removeClass('active');
        $(this).addClass('active');

        selectedSize = $(this).data('size');
    });
</script>
@endsection
