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


@if($section == 'show_products')
     
@elseif($section == 'show_category')
            
@elseif($section == 'show_subcategory')     
    <a href="{{ route('front.subcategory', [$subcategory->sub_category_slug]) }}" >
        @if ($subcategory->image != "")
            <img src="{{ asset('uploads/category/'.$subcategory->image) }} " alt="" class="product-img rounded">
        @else
            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
        @endif
    </a> 
    @elseif($section == 'show_wishlist')
                          
@else
    
    
@endif