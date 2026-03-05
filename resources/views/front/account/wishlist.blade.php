@extends('front.layouts.app')

@section('content')

<div class="container">                
    <h5 class="h5 mb-4 mt-3">
        My Wishlist
        <span class="text-muted">- {{ $wishlist->count() }} items</span>
    </h5>
    
    @include('front.account.common.message')

    <div class="row">
        @if ($wishlist->isNotEmpty())
            @foreach ($wishlist as $value)
                <div class="col-md-3 col-6">
                    <div class="product-card m-0">                                
                        <div class="product-image-wrapper">                                    
                            @if ($value->product->qty < 1)
                                <div class="out-stock"><span>Out of Stock</span></div>
                            @endif                                    
                            
                            <div class="product-slider">
                                @php
                                    $image = $value->product->images->first();
                                @endphp

                                @if ($value->product->images && $value->product->images->count() > 0)
                                    @foreach($value->product->images as $image)
                                        <div class="slider-item">
                                            <a href="{{ route('front.product', $value->product->slug) }}" target="_blank" class="product-img">
                                                @if($image)
                                                    <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="img-fluid" alt="{{ $value->product->title }}">
                                                @else
                                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" class="img-fluid">
                                                @endif
                                            </a>     
                                        </div>
                                    @endforeach                                            
                                @else
                                    <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" class="product-img" />
                                @endif                                       
                            </div>            
                                    
                            <div class="hover-product">      
                                <button onclick="removeProduct({{ $value->product_id }})" class="btn btn-outline-danger btn-sm" type="button">
                                    <i class="fas fa-trash-alt me-2"></i> Remove
                                </button>
                                <p class="show-size">Size: {{ $value->product->size->code ?? '' }}</p>
                            </div>

                            <div class="product-info">
                                <h2>{{ Str::limit($value->product->title, 25, '...') }}</h2>
                                <p class="short">{{ Str::limit($value->product->short_description, 30, '...') }}</p>                                                                
                            </div>

                            <div class="price">
                                <span class="dark">₹ {{ $value->product->price }}</span>
                                @if ($value->product->compare_price > 0)
                                    <span class="h6 text-underline">
                                        <del>₹ {{ $value->product->compare_price }}</del>
                                    </span>
                                    @php
                                        $discount = round((($value->product->compare_price - $value->product->price) / $value->product->compare_price) * 100);
                                    @endphp
                                    <span class="discount">{{ $discount }}% OFF</span>
                                @endif                                        
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row">
                <div class="col-md-7 mx-auto">
                    <div class="card">
                        <div class="card-body text-center p-5">
                            <h3 class="mb-2">Your Wishlist is Empty</h3>
                            <p>Add items that you like to your wishlist. <br />Review them anytime and easily move them to the bag.</p>

                            <a href="{{ route('front.home') }}" class="btn btn-primary mt-3">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@section('customJs')
    <script>
       function removeProduct(id){            
    $.ajax({
        url: '{{ route("account.removeProductFromWishlist") }}',
        type: 'POST',
        data: {
            id: id,
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response){

            var toastEl = document.getElementById('wishlistToast');

            if(response.status === true){

                // Remove item visually
                $("#wishlist-item-" + id).fadeOut(300, function(){
                    $(this).remove();
                });

                // Update wishlist count badge (if exists)
                $(".wishlist-count").text(response.wishlistCount);

                // Success toast
                toastEl.classList.remove('bg-danger');
                toastEl.classList.add('bg-success');

            } else {

                toastEl.classList.remove('bg-success');
                toastEl.classList.add('bg-danger');
            }

            $("#wishlistToastBody").text(response.message);

            var toast = new bootstrap.Toast(toastEl);
            toast.show();

            setTimeout(function(){
                location.reload();
            }, 1000);
        }
    });
}
    </script>
@endsection
