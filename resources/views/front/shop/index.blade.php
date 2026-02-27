@extends('front.layouts.app')

@section('content')
    
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-12">
            <div class="light-font">
                <ol class="breadcrumb primary-color">
                    <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $selectedCategory->category_name }} {{ $selectedSubCategory->sub_category_name }}</li>
                </ol>
            </div>
        </div>

        <div class="col-md-10 col-12">
            <div class="row">
                <div class="col-md-10 col-12">
                    <h6 class="h6">
                        <b>{{ $selectedCategory->category_name }} {{ $selectedSubCategory->sub_category_name }}</b> -
                        <span class="text-muted">{{ $products->total() }} items</span>
                    </h6>                    
                </div>

                <div class="col-md-2 col-12">
                    <div class="d-flex justify-content-between align-items-center">
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-12 sticky">
           @include('front.shop.filters')
        </div>

        <div class="col-md-10 col-12">
            <div class="row">
                @foreach($products as $product)         
                    <div class="col-md-3 col-6">
                        <x-product-card :product="$product" />                    
                    </div>
                @endforeach
            </div>
            <div class="col-md-12 pt-5">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('customJs')
    <script>

        $('.form-check-input').on('change', function () {
            let url = new URL(window.location.href);
            let params = url.searchParams;

            let type = $(this).data('type');
            let value = $(this).val();

            // Get existing values
            let existing = params.get(type);
            let values = existing ? existing.split(',') : [];

            if (this.checked) {
                if (!values.includes(value)) {
                    values.push(value);
                }
            } else {
                values = values.filter(v => v !== value);
            }

            if (values.length > 0) {
                params.set(type, values.join(','));
            } else {
                params.delete(type);
            }

            window.location.href = url.toString();
        });



        $(".sub2-label").on('change', apply_category_filters);
        $(".brand-label").on('change', apply_brand_filters);
        $(".color-label").on('change', apply_color_filters);
        $(".size-label").on('change', apply_size_filters);
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

        function apply_size_filters(){
            var sizes = [];

            $(".size-label:checked").each(function(){
                sizes.push($(this).val());
            });

            var params = new URLSearchParams(window.location.search);

            if (sizes.length > 0) {
                params.set('size', sizes.join(','));
            } else {
                params.delete('size');
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