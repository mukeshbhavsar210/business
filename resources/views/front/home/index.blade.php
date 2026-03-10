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
                        <x-product-card :category="$category" :slider="true" :hover="true" />
                    </div>
                @endforeach
            @endif
        </div>
    </div>    
@endsection