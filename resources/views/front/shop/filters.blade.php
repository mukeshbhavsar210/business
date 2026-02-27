<h4>Filters</h4>

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
                <a href="javascript:0;" class="link">
                    <label class="form-check-label" for="sub2-{{ $sub2->id }}">
                        <input {{ (request()->get('sub2') && in_array($sub2->sub2_category_slug, explode(',', request()->get('sub2')))) ? 'checked' : '' }}
                        class="form-check-input sub2-label" type="checkbox" value="{{ $sub2->sub2_category_slug }}" id="sub2-{{ $sub2->id }}">
                        <span class="name">{{ $sub2->sub2_category_name }}</span>
                        <span class="text-muted">({{ $sub2->products_count }})</span>                            
                    </label>
                </a>
            </div>
        @endforeach
    @endif
</div>
<div class="filter-group">
    <h5>Brands</h5>            
    @if ($brands->isNotEmpty())
        @foreach ($brands as $brand)
            <div class="form-check">
                <a href="javascript:0;" class="link">
                    <label class="form-check-label" for="brand-{{ $brand->id }}">
                        <input {{ (in_array($brand->slug, $brandsArray)) ? 'checked' : '' }}
                        class="form-check-input brand-label" type="checkbox" value="{{ $brand->slug }}" id="brand-{{ $brand->id }}">
                        <span class="name">{{ Str::limit($brand->name, 20, '...') }}</span>
                        <span class="text-muted">({{ $brand->products_count }})</span>
                    </label>
                </a>
            </div>
        @endforeach
    @endif
</div>

<div class="filter-group">
    <h5 class="h5 mb-2">Price</h5>
    <input type="text" class="js-range-slider" name="my_range" value="" />
</div>

<div class="filter-group">
    <h5>Sizes</h5>
    @if($sizes->isNotEmpty())
        @foreach($sizes as $size)
            <div class="form-check">
                <a href="javascript:0;" class="link">
                    <label class="form-check-label" for="color-{{ $size->id }}">                                
                        <input {{ request()->get('size') && in_array($size->name, explode(',', request()->get('color'))) ? 'checked' : '' }}
                        class="form-check-input size-label" type="checkbox" value="{{ $size->name }}" id="color-{{ $size->id }}">
                        <span class="size-code" style="background-color: {{ $size->code }}"></span>
                        <span class="size-name">{{ $size->name }}</span>
                        <span class="text-muted">({{ $size->products_count }})</span>
                    </label>
                </a>
            </div>
        @endforeach
    @endif 
</div>

<div class="filter-group">
    <h5>Color</h5>
    @if($colors->isNotEmpty())
        @foreach($colors as $color)
            <div class="form-check">
                <a href="javascript:0;" class="link">
                    <label class="form-check-label" for="color-{{ $color->id }}">                                
                        <input {{ request()->get('color') && in_array($color->name, explode(',', request()->get('color'))) ? 'checked' : '' }}
                        class="form-check-input color-label" type="checkbox" value="{{ $color->name }}" id="color-{{ $color->id }}">                
                        <span class="color-code" style="background-color: {{ $color->code }}"></span>
                        <span class="color-name">{{ Str::limit($color->name, 20, '...') }}</span>
                        <span class="text-muted">({{ $color->products_count }})</span>
                    </label>
                </a>
            </div>
        @endforeach
    @endif
</div>

<div class="filter-group">
    <h5>Discount Range</h5>
</div>