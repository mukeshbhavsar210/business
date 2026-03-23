@extends('front.layouts.app')

@section('title', 'Online Fashion Shopping for Men and Women')

@section('content')
    
<div class="container">    
    <h2>Category</h2>
    <div class="row mt-3">
        @foreach($products as $product)         
            <div class="col-md-3 col-6">
                <x-products :product="$product" :slider="true" :hover="true"/>
            </div>
        @endforeach

        {{ $products->withQueryString()->links() }}    
    </div>
</div>
@endsection

@section('customJs')
    
@endsection