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
    'limit' => null, 
    'title_limit' => null,
    'class_desktop' => null,
    'class_mobile' => null,
    "section" => null,
    "variable" => null,
    'showWishlist' => true,    
])

@if($section == 'show_products')        
    <div class="price">
        @if($product->discount_percent > 0)
            <span class="dark">₹{{ round($product->discount_price) }}</span>
            <span class="mrp"><del>₹{{ $product->price }}</del></span>
            <span class="discount">({{ $product->discount_percent }}% OFF)</span>
        @else
            <span class="dark">₹{{ number_format($product->price, 2) }}</span>
        @endif
    </div>  
           
@elseif($section == 'show_category')        
    <div class="price">
        <p class="text-muted"><b>{{ $category->products_count }} Products</b></p>
    </div>           
@elseif($section == 'show_subcategory')    
    <div class="price">
        <p class="text-muted"><b>{{ $category->products_count }} Products</b></p>
    </div>
          
@elseif($section == 'show_wishlist')
    <div class="price">                
        @if($wishlist->product->discount_percent > 0)
            <span class="dark">₹{{ round($wishlist->product->discount_price) }}</span>
            <span class="mrp"><del>₹{{ $wishlist->product->price }}</del></span>
            <span class="discount">({{ $wishlist->product->discount_percent }}% OFF)</span>
        @else
            <span class="dark">₹{{ number_format($wishlist->product->price, 2) }}</span>
        @endif
    </div>              
@else
    
@endif