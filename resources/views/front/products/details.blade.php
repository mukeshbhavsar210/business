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

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 col-12 sticky">
             @if(request()->filled('variant') && $selectedVariant && $selectedVariant->image)                    
                <div class="col-md-12 col-12">
                    <img class="w-100 h-100" src="{{ asset('uploads/product/large/'.$selectedVariant->image) }}" alt="Variant Image">
                </div>
            @else
                @if ($product->product_images && $product->product_images->count())
                    <div class="product-gallery">
                        <div class="slider-nav">
                            @foreach($product->product_images as $productImage)
                                <div class="thumb">
                                    <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" alt="Product Image">
                                </div>
                            @endforeach
                        </div>

                        <div class="slider-for">
                            @foreach($product->product_images as $productImage)
                                <div class="main-image">
                                    <img src="{{ asset('uploads/product/large/'.$productImage->image) }}" alt="Product Image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
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
                        <div class="details-price">
                            @if($product->discount_percent > 0)
                                <span class="dark">₹{{ round($product->discount_price) }}</span>
                                <span class="mrp"><del>₹{{ $product->price }}</del></span>
                                <span class="discount">{{ $product->discount_percent }}% OFF</span>
                            @else
                                <span class="dark">₹{{ number_format($product->price, 2) }}</span>
                            @endif                     
                        </div>                       
                        <p class="inclusive">Inclusive of all taxes</p>
                    </div>
                    <div class="rating-right">
                        <p class="star-position"><span class="sprites rating-star2-ico"></span></p>
                        <p>{{ number_format($averageRating,1) }} |</p>
                        <p>{{ $totalRatings >= 1000 ? round($totalRatings / 1000, 1).'k' : $totalRatings }}</p>                        
                    </div>
                </div>
                
                @if($product->variants->count() > 0)
                    <div class="part">
                        <h3>More Colors</h3>
                        <ul class="variant">
                            @if($product->images->first())
                                <li>
                                    <a href="{{ route('front.product', [
                                            $product->category->category_slug,  
                                            $product->subCategory->sub_category_slug,                               
                                            $product->subSubCategory->sub_sub_category_slug,
                                            'slug' => $product->slug]) }}" 
                                            class="variant-btn {{ request('variant') ? '' : 'active' }}">
                                        <img src="{{ asset('uploads/product/small/'.$product->images->first()->image) }}" >
                                    </a>
                                </li>
                            @endif
                            @foreach ($product->variants as $variant)
                                @if($variant->image)
                                    <li id="variant-image-row-{{ $variant->id }}">                                
                                        <a href="{{ route('front.product', [
                                                    $product->category->category_slug,  
                                                    $product->subCategory->sub_category_slug,                               
                                                    $product->subSubCategory->sub_sub_category_slug,
                                                    'slug' => $product->slug, 'variant' => $variant->id]) }}" 
                                                    class="variant-btn {{ request('variant') == $variant->id ? 'active' : '' }}">
                                            <input type="hidden" name="existing_variant_images[]" value="{{ $variant->id }}">
                                            <img src="{{ asset('uploads/product/small/'.$variant->image) }}"  />
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                            </ul> 
                        @else
                            @if($product->colors->isNotEmpty())
                                <div class="part">
                                    <div class="flex">
                                        <h3 style="margin-top: 17px;">Colors:</h3>                                    
                                        <ul class="color-list">
                                            @foreach($product->colors as $color)
                                                <li>
                                                    <a href="javascript:void(0);" class="color-option show-tooltip" data-color="{{ $color->id }}">
                                                        <span class="color" style="background-color: {{ $color->code }}"></span>
                                                        <span class="tooltip" style="bottom: 37px;">{{ $color->name }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        @endif                                    
                
                @if($product->sizes->isNotEmpty())
                    <div class="part mb-3">
                        <div class="flex">
                            <h3 style="margin-top: 22px;">Size:</h3>
                            <ul class="size-list">
                                @foreach($product->sizes as $size)
                                    <li>
                                        <a href="javascript:void(0);" class="size-option show-tooltip" data-size="{{ $size->id }}">
                                            {{ $size->code }}
                                            <span class="tooltip" style="bottom: 47px;">{{ $size->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                
                <div class="part">
                    <div class="call-action">
                        @if ($product->track_qty == 'Yes')
                            @if ($product->qty > 0)
                                <a class="btn btn-primary add-to-cart-btn" id="addToCart" href="javascript:void(0);" onclick="addToCart({{ $product->id }}, this)" data-has-sizes="{{ $product->sizes->isNotEmpty() ? 1 : 0 }}">
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
                        </a>   
                    </div>
                </div>

                <div class="accordion details-accordion" id="accordionExample">
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapseOne" 
                                    aria-expanded="false" 
                                    aria-controls="collapseOne">
                                
                                <div class="icon-wrapper">
                                    <div class="icon-left">
                                        <span class="sprites list-icon"></span>
                                    </div>
                                    <div class="title-right">
                                        <h5>Product Description</h5>
                                        <p>Manufacture, Care and Fit</p>
                                    </div>
                                </div>                                
                            </button>
                        </div>

                        <div id="collapseOne" 
                            class="accordion-collapse collapse" 
                            aria-labelledby="headingOne" 
                            data-bs-parent="#accordionExample">

                            <div class="accordion-body">                                
                                @if ($product->discount_price > 0)
                                    <span class="mrp">
                                        Best Price: ₹{{ $product->discount_price }}
                                    </span>                        
                                @endif  
                                                                                            
                                {{ $coupon }}
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <div class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" 
                                    type="button" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#collapseTwo" 
                                    aria-expanded="false" 
                                    aria-controls="collapseTwo">

                                <div class="icon-wrapper">
                                    <div class="icon-left">
                                        <span class="sprites exchange-icon"></span>
                                    </div>
                                    <div class="title-right">
                                        <h5>15 DAY RETURNS</h5>
                                        <p>Know about return & exchange policy</p>
                                    </div>
                                </div>                                
                            </button>
                        </div>

                        <div id="collapseTwo" 
                            class="accordion-collapse collapse" 
                            aria-labelledby="headingTwo" 
                            data-bs-parent="#accordionExample">

                            <div class="accordion-body">
                                @if($product->is_returnable)
                                    <p>Easy {{ $product->return_days }} returns and exchanges</p>
                                @else
                                    <p>Non-returnable product</p>
                                @endif                                                                                                                            
                            </div>
                        </div>
                    </div>
                </div>

                <div class="original-products">
                    <div class="details">
                        <div class="icon">
                            <span class="sprites original-icon1"></span>
                        </div>
                        <p>100% Genuie<br /> Product</p>
                    </div>
                    <div class="details">
                        <div class="icon">
                            <span class="sprites original-icon1"></span>
                        </div>
                        <p>100% Secure <br />Payment</p>
                    </div>
                    <div class="details">
                        <div class="icon">
                            <span class="sprites original-icon1"></span>
                        </div>
                        <p>Easy Returns & <br /> Instant Refunds</p>
                    </div>
                </div>
                
                <div class="part">
                    @if($totalReviews > 0)
                        <p class="flex">
                            <span class="sprites thumb-icon"></span>
                            <span class="text-muted"><b>{{ $percentage }}%</b> of verified buyers recommend this product</span>                            
                        </p>
                    @else
                        <p>No reviews yet</p>
                    @endif
                    
                    <div class="rating-breakdown">
                        <div class="total-numbers">
                            <div class="title">
                                <h4>{{ number_format($averageRating,1) }} </h4>
                                <span class="sprites green-star-icon"></span>
                            </div>                            
                            <p>{{ $totalRatings >= 1000 ? round($totalRatings / 1000, 1).'k' : $totalRatings }} ratings</p>
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
                                <div class="rating-count">({{ $count }})</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="accordion details-accordion" id="accordionRatings">
                        <div class="accordion-item">
                            <div class="accordion-header" id="ratingsDetails">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapseRatings" aria-expanded="false" aria-controls="collapseRatings">
                                    
                                    <div class="icon-wrapper">
                                        <div class="icon-left">
                                            <span class="sprites reviews-icon"></span>
                                        </div>
                                        <div class="title-right">
                                            <h5>Customer Reviews ({{ $totalReviews }})</h5>
                                            <p>Product Code: {{ $product->id }}</p>                                              
                                        </div>
                                    </div>                                
                                </button>
                            </div>

                            <div id="collapseRatings" class="accordion-collapse collapse" aria-labelledby="ratingsDetails" data-bs-parent="#accordionRatings">
                                <div class="accordion-body">                                
                                    <div class="rating-customers">                                        
                                        @foreach($reviews as $review)
                                            <div class="repeate">
                                                <div class="left">
                                                    @if($review->rating == 1)
                                                        <span class="star-show one_two">{{ $review->rating }} ★</span>    
                                                    @elseif($review->rating == 2)
                                                        <span class="star-show one_two">{{ $review->rating }} ★</span>
                                                    @elseif($review->rating == 3)
                                                        <span class="star-show three">{{ $review->rating }} ★</span>
                                                    @elseif($review->rating == 4 || $review->rating == 5)
                                                        <span class="star-show four_five">{{ $review->rating }} ★</span>
                                                    @endif                                                    
                                                </div>
                                                <div class="right">                            
                                                    <p>{{ $review->review }}</p>
                                                    <p class="customer">
                                                        {{ $review->user->name ?? 'Guest' }}
                                                        | {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y')}}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                
                                        @if($totalReviews > 2)
                                            <a href="{{ route('product.reviews', $product->id) }}" class="link">View all {{ $count }} reviews </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
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
