@extends('front.layouts.app')

@section('content')
    <div class="container-small">
        <div class="small-title">
            <h4>Account</h4>
            <p>{{ $userDetails->name }}</p>
        </div>
        
        <div class="row">            
            <div class="col-md-3 col-12">                
                @include('front.account.common.sidebar')  
            </div>
            <div class="col-md-9 col-12">
                <div class="details-accounts">
                    <div class="row">            
                        <div class="col-md-6 col-12">
                            <h3>All Orders</h3>
                            <p>From anytime</p>
                        </div>
                        <div class="col-md-6 col-12">1</div>
                    </div>
                    
                    <div class="order-history">
                        @if ($orders->isNotEmpty())
                            @foreach ($orders as $order)
                                <div class="individual">                                                                            
                                    <div class="status">
                                        <div class="icon-status"></div>
                                        <div>
                                            @if ($order->status == 'pending')
                                                <span class="pending">Pending</span>
                                            @elseif ($order->status == 'shipped')
                                                <span class="shipped">Shipped</span>
                                            @elseif ($order->status == 'delivered')
                                                <span class="delivered">Delivered</span>
                                            @else
                                                <span class="cancelled">Cancelled</span>
                                            @endif
                                            <p class="date">On {{ \Carbon\Carbon::parse($order->shipped_date)->format('D, d M Y') }}</p>
                                        </div>
                                    </div>

                                    <div class="product-details">
                                        @foreach($order->items as $item)                                                    
                                            @php
                                                $productImage = getProductImage($item->product_id)
                                            @endphp

                                            <a href="{{ route('account.orderDetail',$order->id) }}" class="product-details-link">
                                                <div class="flex-end">
                                                    <div class="flex">
                                                        <div class="photo">
                                                            @if (!empty($productImage->image))
                                                                <img class="product" src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                                            @else
                                                                <img class="product" src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                                                            @endif 
                                                        </div>
                                                        <div class="product-details-name">
                                                            <h3>{{ $item->name }}</h3>
                                                            <p class="m-0 text-muted">Size: {{ $item->product->size?->name ?? 'N/A' }},                                                                 
                                                                @if($item->product->color)
                                                                    Color: <span class="color-small" style="background:{{ $item->product->color->code }}"></span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>></div> 
                                                </div>                                                
                                            </a>
                                        @endforeach
                                            
                                        <div class="gaps">
                                            <p class="text-muted">Exchange/Return window closed on Sun, 2 Mar 2025</p>                                            
                                        </div>
                                        <div class="ratings">
                                            <div class="rating-rateBox"><div class="myRating-inline"><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div></div></div>
                                            <p class="text-muted">Rate & Review to win MynCash!</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                                Orders not found                                    
                        @endif                                                
                    </div>
                </div>       
            </div>
        </div>
    </div>
@endsection