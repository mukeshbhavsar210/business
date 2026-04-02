@extends('front.layouts.app')

@section('title', 'Online Fashion Shopping for Men and Women')

@section('content')
    
<div class="container">    
    <h4>Category: {{ ucfirst($selected_category) }}</h4>

    <div class="row mt-3">
        @foreach($categories as $category)         
            <div class="col-md-2 col-6">
                    <div class="product-card">
                        <div class="product-image-wrapper">                                                                                        
                            <x-products :category="$category" section="show_category" :title_limit="20" :short_limit="7" />
                            <x-hover section="show_category" section="show_subcategory" variable="category"  /> 
                        </div>
                    </div>
                </div> 
        @endforeach

        {{ $categories->withQueryString()->links() }}    
    </div>
</div>
@endsection

@section('customJs')
    
@endsection