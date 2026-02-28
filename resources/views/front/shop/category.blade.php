@extends('front.layouts.app')

@section('content')
    
<div class="container">    
    <div class="row">
        @foreach($products as $product)         
            <div class="col-md-3 col-6">
                <x-product-card :product="$product" />                    
            </div>
        @endforeach

        {{ $products->withQueryString()->links() }}        
    </div>
</div>
    
@endsection

@section('customJs')
    
@endsection
