@extends('front.layouts.app')

@section('title', 'Product Reviews')

@section('content')

<div class="container">
    <div class="light-font">
        <ol class="breadcrumb primary-color mb-0">
            <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>           
            <li class="breadcrumb-item">{{ $product->title }}</li>
        </ol>
    </div>

    <div class="product-details-wrapper">
        <div class="row">
            <div class="col-md-4 col-12">
                @if($product->product_images->isNotEmpty())                    
                    <img src="{{ asset('uploads/product/large/'.$product->product_images->first()->image) }}" alt="Image">                    
                @endif
                <h1>{{ $product->title }}</h1>
                <p class="tag">{{ $product->short_description }}</p>
            </div>        
            <div class="col-md-8 col-12">                
                <h3>Ratings</h3> 
                <div class="part">
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
                </div>
                <h3>All Reviews for {{ $product->name }}</h3>

                @foreach($reviews as $review)
                    <div class="review-box">
                        <div class="name">
                            <strong>{{ $review->user->name ?? 'Guest' }}</strong>
                            <p class="star">{{ str_repeat('★', $review->rating) }}</p>
                        </div>
                        <p>{{ $review->review }}</p>
                        <p class="date">{{ $review->created_at }}</p>
                    </div>
                @endforeach

                {{ $reviews->links() }}                
            </div>
        </div>
    </div>
</div>