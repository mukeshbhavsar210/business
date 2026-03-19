@extends('front.layouts.app')

@section('title', 'Online Fashion Shopping for Men and Women')

@section('content')
    
<div class="container">    
    <div class="row">
        <h2>Sub Categories</h2>
        @foreach($products as $product)         
            <div class="col-md-3 col-6">
                <x-products :product="$product" :selected_item1="$selected_item1" :selected_item2="$selected_item2" :selected_item3="$selected_item3" :slider="true" :hover="true"/>
            </div>
        @endforeach

        {{ $products->withQueryString()->links() }}    
    </div>
</div>
@endsection

@section('customJs')
    
@endsection