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
                
                @if ($count > 0)
                    <div class="rating">
                        <div class="rating-wrapper">                            
                            <b>{{ $product->average_rating }}</b>
                            <span class="sprites star-ico"></span>                            
                            <span class="divider">{{ $count }} {{ $count == 1 ? 'Rating' : 'Ratings' }}</span>                            
                        </div>
                    </div>
                @endif                                       
                
                <div class="price-wrapper">
                    <div class="price">
                        @if($product->discount)
                            @php
                                $discountPrice = $product->price - ($product->price * $product->discount->discount_percent / 100);
                            @endphp

                            <span class="dark">₹{{ $discountPrice }}</span>
                            <span class="mrp">MRP 
                                <del>₹{{ $product->price }}</del>
                            </span>
                            <span class="discount">{{ $product->discount->discount_percent }}% OFF</span>
                        @else
                            <div class="price">
                                <span class="dark">₹{{ $product->price }}</span>
                            </div>
                        @endif
                    </div>                                                                                                                                      
                    <p class="inclusive">Inclusive of all taxes</p>
                </div>

                <div class="part">
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
                    <div class="flex">
                        <h3 style="margin-top: 22px;">Select Size:</h3>
                        <ul class="size-list">
                            @foreach($product->sizes as $size)
                                <li>
                                    <a href="javascript:void(0);" class="size-option" data-size="{{ $size->code }}">
                                        {{ $size->code }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="part">
                    <div class="flex">
                        <h3 style="margin-top: 22px;">Select Colors:</h3>                                    
                        <ul class="size-list">
                            @foreach($product->colors as $color)
                                <li>
                                    <a href="javascript:void(0);" class="size-option" data-size="{{ $size->name }}">
                                        <span style="background-color: {{ $color->code }}; height:22px; width:22px; border-radius:100px; display:block;"></span>                                        
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="part mt-4">
                    <div class="call-action">
                        @if ($product->track_qty == 'Yes')
                            @if ($product->qty > 0)
                                <a class="btn btn-primary" id="addToCart" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                                    <span class="sprites cart-small-ico"></span>
                                    &nbsp;ADD TO BAG
                                </a>
                            @else
                                <a class="btn btn-dark" href="javascript:void(0);">
                                    <span class="sprites cart-small-ico"></span>
                                    &nbsp;OUT OF STOCK
                                </a>
                            @endif                        
                        @endif   
                        <a class="btn btn-outline-dark" onclick="addToWishlist({{ $product->id }})" href="javascript:void(0)">
                            <span class="sprites wishlist-ico-btn"></span>
                            Wishlist
                        </a>   
                    </div>
                </div>

                <div class="part">
                    <h3>Delivery Options</h3>
                    <div class="delivery-check">                        
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
                    @if ($product->compare_price > 0)
                        <span class="mrp">
                            Best Price: ₹{{ $product->compare_price }}
                        </span>                        
                    @endif  

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
                    <x-products :product="$product" :showWishlist="false"/>
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
