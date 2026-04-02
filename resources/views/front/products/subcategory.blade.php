@extends('front.layouts.app')

@section('title', 'Online Fashion Shopping for Men and Women')

@section('content')
    
<div class="container">    
    <div class="row">
        <h4 class="mb-3">Sub Category</h4>

        @foreach($subcategories as $subcategory)                     
            <x-products :subcategory="$subcategory" :class_desktop="2" :class_mobile="6" :title_limit="20" :short_limit="7" :slider="true" :hover="true"/>            
        @endforeach

        {{ $subcategories->withQueryString()->links() }}    
    </div>
</div>
@endsection

@section('customJs')
    
@endsection