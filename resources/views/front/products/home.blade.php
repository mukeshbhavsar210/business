@extends('front.layouts.app')

@section('title', 'Online Fashion Shopping for Men and Women')

@section('content')
    <div class="container">        
        <h2 class="home-title">Shop By Category</h2>
        
        <div class="row">
            @foreach(getCategories() as $category)                
                @foreach($category->subCategories as $subCategory)    
                    <div class="col-md-2 col-6">                   
                        <x-products 
                            :category="$category" 
                            :subcategory="$subCategory"
                            :slider="true" 
                            :hover="true" 
                        />
                    </div>
                    {{-- {{ $subCategory->sub_category_name }} --}}
                @endforeach
            @endforeach

            {{-- @foreach(getCategories() as $category)                
                @foreach($category->subCategories as $subCategory)                       
                        {{ $subCategory->sub_category_name }}                    
                    @foreach($subCategory->subSubCategories as $subSubCategory)                        
                        {{ $subSubCategory->sub_sub_category_name }}                        
                    @endforeach
                @endforeach
            @endforeach --}}

            {{-- @if (getCategories()->isNotEmpty())
                @foreach (getCategories() as $category)                
                    <div class="col-md-2 col-6">
                        <x-products :category="$category" :slider="true" :hover="true" />
                    </div>
                @endforeach
            @endif --}}
        </div>
    </div>    
@endsection