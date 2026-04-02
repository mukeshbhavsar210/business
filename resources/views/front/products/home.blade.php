@extends('front.layouts.app')

@section('title', 'Online Fashion Shopping for Men and Women')

@section('content')
    <div class="container-fluid">
        <h2 class="home-title">Global Brands</h2>        
        <div class="brand-slider">
            @foreach(getBrands() as $brand)                
                <div class="brand-item">
                    <x-products :brand="$brand" section="show_brands" :slider="true" :hover="true" />
                </div>
            @endforeach
        </div>

        <h2 class="home-title mt-5">Shop By Category</h2>                
        <div class="row">
            @foreach(getCategories() as $category)                
                @foreach($category->subCategories as $subCategory)    
                    <div class="col-md-2 col-6">
                        <div class="product-card">
                            <div class="product-image-wrapper">                                
                                <x-products :category="$category" :subcategory="$subCategory" section="show_subcategory" variable="subcategory" :title_limit="27" :short_limit="30"/>
                                <x-hover section="show_category" section="show_subcategory" variable="subcategory"  /> 
                            </div>
                        </div>
                    </div>                    
                    {{-- {{ $subCategory->sub_category_name }} --}}
                @endforeach
            @endforeach          
        </div>
    </div>    
@endsection