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
                                    @if ($order->status == 'confirmed')
                                        <div class="status confirmed">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FFFFFF" fill-rule="nonzero" d="M19.173 7.059l-7.232-4a.469.469 0 0 0-.454 0l-7.232 4A.503.503 0 0 0 4 7.5v9c0 .185.098.355.255.441l7.232 4a.469.469 0 0 0 .454 0l7.232-4a.503.503 0 0 0 .256-.441v-9a.503.503 0 0 0-.256-.441zm-7.459-2.992L17.922 7.5 15.33 8.933 9.123 5.5l2.591-1.433zm-.482 15.6L4.964 16.2V8.334l6.268 3.466v7.866zm.482-8.734L5.507 7.5l2.591-1.433L14.305 9.5l-2.59 1.433zm6.75 5.267l-6.268 3.466V11.8l6.268-3.466V16.2z"></path></svg>
                                            </div>
                                            <div class="name">
                                                <p><b>Confirmed</b></p>
                                                <p class="date">On {{ \Carbon\Carbon::parse($order->shipped_date)->format('D, d M Y') }}</p>
                                            </div>
                                        </div>
                                    @elseif ($order->status == 'shipped')
                                        <div class="status shipped">
                                            <div class="icon"></div>
                                            <div class="name">
                                                <p><b>Shipped</b></p>
                                                <p class="date">On {{ \Carbon\Carbon::parse($order->shipped_date)->format('D, d M Y') }}</p>
                                            </div>
                                        </div>
                                    @elseif ($order->status == 'delivered')
                                        <div class="status delivered">
                                            <div class="icon">
                                                <div class="delivery-tick"></div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FFFFFF" fill-rule="nonzero" d="M19.173 7.059l-7.232-4a.469.469 0 0 0-.454 0l-7.232 4A.503.503 0 0 0 4 7.5v9c0 .185.098.355.255.441l7.232 4a.469.469 0 0 0 .454 0l7.232-4a.503.503 0 0 0 .256-.441v-9a.503.503 0 0 0-.256-.441zm-7.459-2.992L17.922 7.5 15.33 8.933 9.123 5.5l2.591-1.433zm-.482 15.6L4.964 16.2V8.334l6.268 3.466v7.866zm.482-8.734L5.507 7.5l2.591-1.433L14.305 9.5l-2.59 1.433zm6.75 5.267l-6.268 3.466V11.8l6.268-3.466V16.2z"></path></svg>
                                            </div>
                                            <div class="name">
                                                <p><b>Delivered</b></p>
                                                <p class="date">On {{ \Carbon\Carbon::parse($order->created_date)->format('D, d M Y') }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="status cancelled">
                                            <div class="icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="#282C3F" fill-rule="nonzero" d="M15.854 8.146a.495.495 0 0 0-.703 0L12 11.296l-3.15-3.15a.495.495 0 0 0-.704 0 .495.495 0 0 0 0 .703L11.297 12l-3.15 3.15a.5.5 0 1 0 .35.85.485.485 0 0 0 .349-.146l3.15-3.15 3.151 3.15a.5.5 0 0 0 .35.147.479.479 0 0 0 .35-.147.495.495 0 0 0 0-.703L12.702 12l3.15-3.15a.495.495 0 0 0 0-.704z"></path></svg>
                                            </div>
                                            <div class="name">
                                                <p><b>Cancelled</b></p>
                                                <p class="date">On {{ \Carbon\Carbon::parse($order->created_date)->format('D, d M Y') }}</p>
                                            </div>
                                        </div>
                                    @endif                                                                            

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

                                            @if ($order->status == 'confirmed')
                                                <div class="group flex p-3">
                                                    <a href="{{ route('account.order.cancel.form',$order->id) }}" class="btn btn-outline-dark w-50">Cancel</a>
                                                    <a href="#" class="btn btn-outline-dark w-50">Track</a>
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        @if ($order->status == 'delivered')
                                            <div class="gaps">
                                                <p class="text-muted">Exchange/Return window closed on Sun, 2 Mar 2025</p>                                            
                                            </div>
                                            <div class="ratings">
                                                <div class="rating-rateBox"><div class="myRating-inline"><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div></div></div>
                                                <p class="text-muted">Rate & Review to win MynCash!</p>
                                            </div>
                                        @endif
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