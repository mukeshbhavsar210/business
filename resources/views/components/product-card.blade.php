@props([
    'product',
    'showWishlist' => true
])

<div class="product-card">                                
    <div class="product-image-wrapper">
        @php
            $rating = $product->average_rating ?? 0;
            $count  = $product->rating_count ?? 0;
        @endphp
        
        @if ($count > 0)
            <div class="rating-wrapper">
                <small>
                    {{ $product->average_rating }}
                    <small class="fas fa-star"></small> 
                    <small>{{ $product->rating_count ?? 0 }}</small>
                </small>
            </div>
        @endif        

        @if ($product->images && $product->images->count() > 0)
            <p class="gallery-icon">Gallery</p>
        @endif

        <div class="product-slider">
            @php
                $productImage = $product->product_images->first();
            @endphp

            @if ($product->images && $product->images->count() > 0)
                @foreach($product->images as $image)
                    <div class="slider-item">
                        <a href="{{ route('front.product',$product->slug) }}" class="product-img" target="_blank">
                            <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="img-fluid" alt="{{ $product->title }}" >
                        </a>
                    </div>
                @endforeach
            @else
                <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
            @endif            
        </div>
        
        <div class="hover-product">
            @if (Auth::check())
                <a onclick="addToWishlist({{ $product->id }})" class="btn btn-outline" href="javascript:void(0)">
                    <i class="far fa-heart"></i> Wishlist
                </a>
            @else
                <a class="btn btn-outline" href="#" data-bs-toggle="modal" data-bs-target="#login">
                    <i class="far fa-heart"></i> Wishlist
                </a>
            @endif                        
            <p class="show-size">Size: {{ $product->size->code ?? '' }}</p>
        </div>  

        <div class="product-info">
            <h2>{{ Str::limit($product->title, 25, '...') }}</h2>
            <p class="short">{{ Str::limit($product->short_description, 30, '...') }}</p>         
        </div>

        <div class="price">
            <span class="dark">₹{{ $product->price }}</span>
            @if ($product->compare_price > 0)
                <span class="text-underline">
                    <del>₹{{ $product->compare_price }}</del>
                </span>
                @php
                    $discount = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
                @endphp
                <span class="discount">{{ $discount }}% OFF</span>
            @endif           
        </div>            
    </div>
</div>