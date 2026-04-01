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
    "section" => null,
    "variable" => null,    
])

@if($section == 'show_products')        
    <div class="product-info">
        <h2>{{ (isset($title_limit) ? Str::limit($product->title, $title_limit, '...') : $product->title) }}</h2>
        <p class="short">{{ (isset($short_limit) ? Str::limit($product->short_description, $short_limit, '...') : $product->short_description) }}</p>
    </div>                             
           
@elseif($section == 'show_category')        
    <div class="product-info">
        <h2>{{ Str::limit($category->category_name, 27, '...') }}</h2>
    </div>      
    
@elseif($section == 'show_subcategory')    
    <div class="product-info">
        <h2>{{ Str::limit($subcategory->sub_category_title, 27, '...') }}</h2>
        {{-- <h2>{{ Str::limit($category->category_name, 27, '...') }}</h2> --}}
    </div>      
    
    <div class="price">
        <p class="text-muted"><b>{{ $category->products_count }} Products</b></p>
    </div>
          
@elseif($section == 'show_wishlist')
    @if ($wishlist->product->qty < 1)
        <div class="out-stock"><span>Out of Stock</span></div>
    @endif   

    <div class="product-info">
        <h2>{{ Str::limit($wishlist->product->title, 25, '...') }}</h2>
        <p class="short">{{ Str::limit($wishlist->product->short_description, 30, '...') }}</p>                                                                
    </div>    
                    
@elseif($section == 'show_brands')    
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
@else
    
@endif