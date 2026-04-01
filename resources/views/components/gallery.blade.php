@props([
    'product' => null,
    'selected_item1' => null,
    'selected_item2' => null,
    'selected_item3' => null,
    'category' => null,
    'subcategory' => null,
    'wishlist' => null,    
    'brand' => null,             
    "section" => null,
    "variable" => null,          
])

@php
    $images = ${$variable}->product->images ?? collect();
@endphp

@if($section == 'show_products')
    @php
        $rating = ${$variable}->average_rating ?? 0;
        $count  = ${$variable}->rating_count ?? 0;
    @endphp

    @if ($count > 0)
        <div class="rating-wrapper">
            <small>
                {{ ${$variable}->average_rating }}
                <svg fill="#666666" width="15px" height="15px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1915.918 737.475c-10.955-33.543-42.014-56.131-77.364-56.131h-612.029l-189.063-582.1v-.112C1026.394 65.588 995.335 43 959.984 43c-35.237 0-66.41 22.588-77.365 56.245L693.443 681.344H81.415c-35.35 0-66.41 22.588-77.365 56.131-10.955 33.544.79 70.137 29.478 91.03l495.247 359.831-189.177 582.212c-10.955 33.657 1.13 70.25 29.817 90.918 14.23 10.278 30.946 15.487 47.66 15.487 16.716 0 33.432-5.21 47.775-15.6l495.134-359.718 495.021 359.718c28.574 20.781 67.087 20.781 95.662.113 28.687-20.668 40.658-57.261 29.703-91.03l-189.176-582.1 495.36-359.83c28.574-20.894 40.433-57.487 29.364-91.03" fill-rule="evenodd"/>
                </svg> 
                <small>{{ ${$variable}->rating_count ?? 0 }}</small>
            </small>
        </div>
    @endif   

     <div class="product-slider">       
        @if (${$variable}->images && ${$variable}->images->count() > 0)
            @foreach(${$variable}->images as $image)
                <div class="slider-item">   
                    <a href="{{ ${$variable}->url }}" target="_blank" title="{{ ${$variable}->slug }}">
                        <img src="{{ asset('uploads/product/small/'.$image->image) }}">                        
                    </a>
                </div>
            @endforeach
        @else
            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
        @endif
    
        {{-- @php
            $productImage = ${$variable}->product_images->first();
        @endphp                                    
        <a href="{{ route('front.product',${$variable}->slug) }}" class="product-img" target="_blank">
            <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" class="img-fluid" alt="{{ ${$variable}->title }}" >
        </a>                                     --}}    
    </div>
@elseif($section == 'show_category')                        
    @php
        $rating = ${$variable}->average_rating ?? 0;
        $count  = ${$variable}->rating_count ?? 0;
    @endphp

    @if ($count > 0)
        <div class="rating-wrapper">
            <small>
                {{ ${$variable}->average_rating }}
                <svg fill="#666666" width="15px" height="15px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1915.918 737.475c-10.955-33.543-42.014-56.131-77.364-56.131h-612.029l-189.063-582.1v-.112C1026.394 65.588 995.335 43 959.984 43c-35.237 0-66.41 22.588-77.365 56.245L693.443 681.344H81.415c-35.35 0-66.41 22.588-77.365 56.131-10.955 33.544.79 70.137 29.478 91.03l495.247 359.831-189.177 582.212c-10.955 33.657 1.13 70.25 29.817 90.918 14.23 10.278 30.946 15.487 47.66 15.487 16.716 0 33.432-5.21 47.775-15.6l495.134-359.718 495.021 359.718c28.574 20.781 67.087 20.781 95.662.113 28.687-20.668 40.658-57.261 29.703-91.03l-189.176-582.1 495.36-359.83c28.574-20.894 40.433-57.487 29.364-91.03" fill-rule="evenodd"/>
                </svg> 
                <small>{{ ${$variable}->rating_count ?? 0 }}</small>
            </small>
        </div>
    @endif   

     <div class="product-slider">       
        @if (${$variable}->images && ${$variable}->images->count() > 0)
            @foreach(${$variable}->images as $image)
                <div class="slider-item">   
                    <a href="{{ ${$variable}->url }}" target="_blank" title="{{ ${$variable}->slug }}">
                        <img src="{{ asset('uploads/product/small/'.$image->image) }}">                        
                    </a>
                </div>
            @endforeach
        @else
            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
        @endif
    </div>
            
@elseif($section == 'show_subcategory')     
    <a href="{{ route('front.subcategory', [$subcategory->sub_category_slug]) }}" >
        @if ($subcategory->image != "")
            <img src="{{ asset('uploads/category/'.$subcategory->image) }} " alt="" class="product-img rounded">
        @else
            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
        @endif
    </a> 
   
@elseif($section == 'show_wishlist')
    <div class="product-slider">         
        @if($images->count() > 0)
            @foreach($images as $image)
                <div class="slider-item">  
                    <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="rounded" alt="{{ ${$variable}->product->title }}" >
                </div>
            @endforeach                
        @else
            <img src="{{ asset('admin-assets/img/default-150x150.png') }}" class="rounded">
        @endif           
    </div>                        
@else
    
    
@endif