@extends('front.layouts.app')

@section('content')
    
<div class="container-fluid">
    <div class="carousal mt-4 mb-3">
        Carousal Gallery
    </div>

    <div class="row">
        @if ($products->isNotEmpty())
            @foreach ($products as $product)
                @php
                    $productImage = $product->product_images->first();
                @endphp    
                <div class="col-md-3">
                    <a href="{{ route('front.product',$product->slug) }}" class="product-img">
                        @if (!empty($productImage->image))
                            <img class="card-img-top" src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                        @else
                            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                        @endif
                    </a>
                    <a class="h6 link" href="{{ route('front.product',$product->slug) }}">{{ $product->title }}</a>                                            
                </div>
            @endforeach
        @endif
    
        <div class="col-md-12 pt-5">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
</div>
    
@endsection

@section('customJs')
    
@endsection
