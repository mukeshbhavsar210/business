@extends('front.layouts.app')

@section('title', 'Online Fashion Shopping for Men and Women')

@section('content')
    <div class="container">
        <div class="section-title">
            <h2>Shop By Category</h2>
        </div>
        <div class="row">
            @if (getCategories()->isNotEmpty())
                @foreach (getCategories() as $category)
                    <div class="col-md-3 col-6">
                        <x-product-card :category="$category" />
                    </div>
                @endforeach
            @endif

            {{-- @if (getCategories()->isNotEmpty())
                @foreach (getCategories() as $product)
                    <div class="col-md-3 col-6">
                        <div class="product-card-home">
                            <a href="{{ route('front.category.shop', [$product->category_slug]) }}" >                            
                                @if ($product->image != "")
                                    <img src="{{ asset('uploads/category/'.$product->image) }} " alt="" class="img-fluid">
                                @endif
                            
                                <div class="product-card-home-body">
                                    <h5>{{$product->category_name}}</h5>
                                    <p>{{ $product->products_count }} Products</p>
                                    <a href="#" class="btn btn-outline-dark btn-sm">Shop Now</a>
                                </div>                                                        
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif --}}
        </div>
    </div>    
@endsection