@extends('front.layouts.app')

@section('content')

<div class="container">
    <div class="light-font">
        @include('front/layouts/breadcrumb')        
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-7 col-12">
            <div class="row">
                @if(request()->filled('variant') && $selectedVariant && $selectedVariant->image)
                    {{-- Show ONLY selected variant image --}}
                    <div class="col-md-6 col-12">
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
        <div class="col-md-5 col-12">
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
                                <small class="fas fa-star"></small>
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
                            <span class="discount">({{ $discount }}% OFF)</span>
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
                        <ul class="size-select">
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
                                <a class="btn btn-primary" href="javascript:void(0);" onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-cart"></i> &nbsp;ADD TO BAG
                                </a>
                            @else
                                <a class="btn btn-dark" href="javascript:void(0);">
                                    <i class="fa fa-shopping-cart"></i> &nbsp;OUT OF STOCK
                                </a>
                            @endif                        
                        @endif   
                        <a class="btn btn-outline-dark" onclick="addToWishlist({{ $product->id }})" href="javascript:void(0)">
                            <i class="far fa-heart"></i> 
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
                            <p>Easy {{ $product->return_days }} days returns and exchanges</p>
                        @else
                            <p>Non-returnable product</p>
                        @endif                       
                    </ul>
                </div>

                <div class="part">
                    <h3>BEST OFFERS</h3>
                    Best Price: Rs. 374

                    Coupon code: MYNTRASAVE
                    Coupon Discount: 30% off (Your total saving: Rs. 425)
                    Applicable on: Orders above Rs. 750 (only on first purchase)

                    View Eligible Products
                    7.5% Assured Cashback on Flipkart Axis Bank & SBI Credit Cards.
                    Flat 7.5% Cashback on Flipkart Axis Bank & SBI Credit Cards on a min spend of ₹100
                    Terms & Condition
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
                                <span class="star">★</span>
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
                                    <p class="customer">{{ $review->user->name ?? 'Guest' }} | {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y')}}</p>
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

    <div class="similar-products">
        <h3>SIMILAR PRODUCTS</h3>
        @foreach($relatedProducts as $product)    
            <div class="col-md-2 col-6">
                <x-product-card :product="$product" :showWishlist="false"/>
            </div>
        @endforeach       
    </div>
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
