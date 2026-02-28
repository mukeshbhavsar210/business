@extends('front.layouts.app')

@section('content')
    <div class="container">
        <div class="section-title">
            <h2>Shop By Category</h2>
        </div>
        <div class="row">
            @if (getCategories()->isNotEmpty())
                @foreach (getCategories() as $category)
                    <div class="col-md-3 col-6">
                        <div class="product-card-home">
                            <a href="{{ route('front.category.shop', [$category->category_slug]) }}" >                            
                                @if ($category->image != "")
                                    <img src="{{ asset('uploads/category/'.$category->image) }} " alt="" class="img-fluid">
                                @endif
                            
                                <div class="product-card-home-body">
                                    <h5>{{$category->category_name}}</h5>
                                    <p>{{ $category->products_count }} Products</p>
                                    <a href="#" class="btn btn-outline-dark btn-sm">Shop Now</a>
                                </div>                                                        
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    
@endsection