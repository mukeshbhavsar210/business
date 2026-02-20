@extends('front.layouts.app')

@section('content')
    
<div class="container-fluid">
    <div class="row py-1">
        <div class="col-md-10 col-12">
            <div class="light-font">
                <ol class="breadcrumb primary-color">
                    <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $selectedCategory->category_name }} {{ $selectedSubCategory->sub_category_name }}</li>
                </ol>
            </div>
        </div>
        <div class="col-md-2 col-12">            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <select class="form-select" id="sortFilter">
                    <option value="latest" {{ request('sort') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>What's New</option>
                    <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularity</option>
                    <option value="discount" {{ request('sort') == 'discount' ? 'selected' : '' }}>Better Discount</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Customer Rating</option>
                </select>                    
            </div>            
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-12 sticky">
            <h6 class="h6">{{ $selectedCategory->category_name }} {{ $selectedSubCategory->sub_category_name }} -
                <span class="text-muted">{{ $products->total() }} items</span>
            </h6>            

            <div class="filter-group">
                <h5>Filters</h5>
            </div>
            <div class="filter-group">
                <div class="flex-end">
                    <h5>Categories</h5>
                    @if($filtersApplied)                    
                        <a href="{{ url()->current() }}" class="btn-link">Clear All</a>                    
                    @endif
                </div>

                @if($selectedSubCategory)                    
                    @foreach($subSubCategories as $sub2)
                        <div class="form-check">
                            <input {{ (request()->get('sub2') && in_array($sub2->sub2_category_slug, explode(',', request()->get('sub2')))) ? 'checked' : '' }}
                                class="form-check-input sub2-label" type="checkbox" value="{{ $sub2->sub2_category_slug }}" id="sub2-{{ $sub2->id }}">

                            <label class="form-check-label" for="sub2-{{ $sub2->id }}">
                                {{ $sub2->sub2_category_name }} 
                                <span class="text-muted">({{ $sub2->products_count }})</span>                            
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="filter-group">
                <h5>Brands</h5>            
                @if ($brands->isNotEmpty())
                    @foreach ($brands as $brand)
                        <div class="form-check">
                            <input {{ (in_array($brand->slug, $brandsArray)) ? 'checked' : '' }}
                                class="form-check-input brand-label" type="checkbox" value="{{ $brand->slug }}" id="brand-{{ $brand->id }}">

                            <label class="form-check-label" for="brand-{{ $brand->id }}">
                                {{ $brand->name }} <span class="text-muted">({{ $brand->products_count }})</span>
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="filter-group">
                <h5 class="h5 mb-2">Price</h5>
                <input type="text" class="js-range-slider" name="my_range" value="" />
            </div>
            
            <div class="filter-group">
                <h5>Color</h5>
                @if($colors->isNotEmpty())
                    @foreach($colors as $color)
                        <div class="form-check">
                            <input {{ request()->get('color') && in_array($color->name, explode(',', request()->get('color'))) ? 'checked' : '' }}
                                class="form-check-input color-label" type="checkbox" value="{{ $color->name }}" id="color-{{ $color->id }}">

                            <label class="form-check-label" for="color-{{ $color->id }}">                                
                                <span class="color-code" style="background-color: {{ $color->code }}"></span>
                                <span class="color-name">{{ $color->name }}</span>
                                <span class="text-muted">({{ $color->products_count }})</span>
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="filter-group">
                <h5>Discount Range</h5>
            </div>
        </div>

        <div class="col-md-10 col-12">
            <div class="row">
                @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                        @php
                            $productImage = $product->product_images->first();
                        @endphp
            
                        <div class="col-md-3 col-6">
                            <div class="product-card">                                
                                <div class="product-image-wrapper">
                                    <div class="product-slider">
                                        @if ($product->images && $product->images->count() > 0)
                                            @foreach($product->images as $image)
                                                <div class="slider-item">
                                                    <a href="{{ route('front.product',$product->slug) }}" class="product-img">
                                                        <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="img-fluid" alt="{{ $product->name }}" >
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                                        @endif
                                    </div>
                                    <div class="wishlist-btn">                                            
                                        <a onclick="addToWishlist({{ $product->id }})" class="btn w-100 btn-outline-dark" href="javascript:void(0)">
                                            <i class="far fa-heart"></i> 
                                            Wishlist
                                        </a>
                                        <p>Size:</p>                                        
                                    </div>                                       
                                </div>
                            </div>
                            <div class="product-info">
                                <h3>{{ Str::limit($product->title, 36, '...') }}</h3>
                                <div class="price mt-2">
                                    <span class="h5"><strong>₹{{ $product->price }}</strong></span>
                                    @if ($product->compare_price > 0)
                                        <span class="h6 text-underline"><del>₹{{ $product->compare_price }}</del></span>
                                    @endif
                                </div>
                            </div>                            
                            
                        </div>
                    @endforeach
                @endif
            
                <div class="col-md-12 pt-5">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('customJs')
    <script>
        $(".sub2-label").on('change', apply_category_filters);
        $(".brand-label").on('change', apply_brand_filters);
        $(".color-label").on('change', apply_color_filters);
        $("#sortFilter").on('change', apply_sort_filters);

        function apply_brand_filters(){
            var brands = [];
            $(".brand-label").each(function(){
                if ($(this).is(":checked") == true){
                    brands.push($(this).val());
                }
            });           
            var url = '{{ url()->current() }}?';
            if (brands.length > 0) {
                url += '&brand='+brands.toString();
            }            
            window.location.href = url;
        }

        function apply_color_filters(){
            var colors = [];

            $(".color-label:checked").each(function(){
                colors.push($(this).val());
            });

            var params = new URLSearchParams(window.location.search);

            if (colors.length > 0) {
                params.set('color', colors.join(','));
            } else {
                params.delete('color');
            }

            window.location.href = '{{ url()->current() }}?' + params.toString();
        }

        function apply_sort_filters() {
            var sort = $("#sortFilter").val();
            var params = new URLSearchParams();

            if (sort !== '') {
                params.set('sort', sort);
            }
            window.location.href = '{{ url()->current() }}?' + params.toString();
        }

        rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 5000,
            from: {{ ($priceMin) }},
            to: {{ ($priceMax) }},
            step: 20,
            skin: "flat",
            max_position: "+",
            prefix: "₹",
            onFinish: function(){
                apply_price_filters()
            }
        });

        var slider = $(".js-range-slider").data("ionRangeSlider");

        function apply_price_filters() {
            var slider = $(".js-range-slider").data("ionRangeSlider");

            var min = slider.result.from;
            var max = slider.result.to;

            var params = new URLSearchParams(window.location.search);

            // Set price values
            params.set('price_min', min);
            params.set('price_max', max);

            window.location.href = '{{ url()->current() }}?' + params.toString();
        }

        

        function apply_category_filters(){
            var sub2 = [];
            $(".sub2-label").each(function(){
                if ($(this).is(":checked") == true){
                    sub2.push($(this).val());
                }
            });

            var url = '{{ url()->current() }}?';

            if (sub2.length > 0) {
                url += '&sub2=' + sub2.toString();
            }
            window.location.href = url;
        }
      
        // function apply_search_filters(){            
        //     var keyword = $('#search').val();
        //     if(keyword.length > 0){
        //         url += '&search='+keyword;
        //     }            
        //     window.location.href = url;
        // }
    </script>
@endsection