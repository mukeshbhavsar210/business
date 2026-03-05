@extends('front.layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container-small">
    <div class="small-title">
        <h4>Account</h4>        
        <p>{{ currentUserName() }}</p>
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            <div class="sticky">
                @include('front.account.common.sidebar')
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="orders-details">                   
                <div class="showcase">
                    <div class="product">
                        @foreach ($orderItems as $item)                        
                            @php
                                $productImage = getProductImage($item->product_id)
                            @endphp

                            <div class="card-repeate">
                                <div class="product-image">
                                    <a href="#" class="product-page">
                                        @if (!empty($productImage->image))
                                            <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                        @else
                                            <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                                        @endif
                                    </a>
                                </div>                        
                                
                                <h3 class="product-title">{{ $item->name }}</h3>
                                <p>
                                    Size: {{ $item->product->size?->code ?? 'N/A' }},                                                                 
                                    @if($item->product->color)
                                        Color: <span class="color-small" style="background:{{ $item->product->color->code }}"></span>
                                    @endif
                                </p>
                            </div>              
                        @endforeach                       
                    </div>
                                                     
                    @if ($order->status == 'pending')
                        <div class="delivery-status pending">
                            <div class="icon-left"></div>
                            <div class="status">
                                <h4>Pending</h4>
                                <p class="date">On {{ \Carbon\Carbon::parse($order->created_at)->format('D, d M Y') }}</p>
                            </div>
                        </div>
                    @elseif ($order->status == 'shipped')
                        <div class="delivery-status shipped">
                            <div class="icon-left"></div>
                            <div class="status">
                                <h4>Shipped</h4>
                                <p class="date">On {{ \Carbon\Carbon::parse($order->created_at)->format('D, d M Y') }}</p>
                            </div>
                        </div>
                    @elseif ($order->status == 'delivered')
                        <div class="delivery-status delivered">
                            <div class="icon-left"></div>
                            <div class="status">
                                <h4>Delivered</h4>
                                <p class="date">On {{ \Carbon\Carbon::parse($order->created_at)->format('D, d M Y') }}</p>
                            </div>
                        </div>
                    @elseif ($order->status == 'cancelled')
                        <div class="delivery-status cancelled">
                            <div class="icon-left"></div>
                            <div class="status">
                                <h4>Cancelled</h4>
                                <p class="date">On {{ \Carbon\Carbon::parse($order->created_at)->format('D, d M Y') }}</p>
                            </div>
                        </div>
                    @endif                    
                </div>
                
                {{-- <time>
                    @if (!empty($order->shipped_date))
                        {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, y')}}
                    @else
                        n/a
                    @endif
                </time> --}}
                
                @if ($order->status == 'delivered' || $order->status == 'confirmed')
                    <div class="gray-back">

                        @if ($order->status == 'delivered')
                            <div class="wrapper">
                                <p>Exchange/Return window closed on Sun, 2 Mar 2025</p>
                            </div>

                            <div class="wrapper">
                                <h5 class="mb-2">Rate this product</h5>
                                <div class="row">
                                    @foreach ($orderItems as $item)                        
                                        @php
                                            $productImage = getProductImage($item->product_id)
                                        @endphp

                                        <div class="col-md-2 col-6">
                                            <div class="rating-products">
                                                @if (!empty($productImage->image))
                                                    <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" >
                                                @else
                                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" />
                                                @endif     
                                            </div>
                                        </div>
                                    @endforeach                              
                                    <div class="myRating-inline"><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div></div>
                                </div>                
                            </div>
                        @endif

                        <div class="wrapper">
                            <h3>Delivery Address</h3>
                            <p class="mt-2"><b>{{ $order->name }} | {{ $order->mobile }}</b></p>
                            <p class="tiny-font text-muted">{{ $order->address }}, {{ $order->locality }},<br /> 
                                {{ $order->city }}, {{ $order->state->name }}-{{ $order->zip }}. </p>
                        </div>                  

                        <div class="wrapper">
                            <div class="flex-end">
                                <h3>Total Order Price</h3>
                                <a type="button" class="amount" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    ₹ {{ number_format($order->grandtotal,2) }}
                                </a>
                            </div>
                            <div class="paid-with">Paid by UPI</div>
                        </div>

                        <div class="wrapper">
                            <h3>Updates sent to</h3>
                            <p class="mt-1 text-muted">Mobile: {{ $order->mobile }}</p>
                            <p class="text-muted">Email: {{ $order->user->email }}</p>
                        </div>

                        <div class="wrapper">
                            <h5>Order ID # {{ $order->id }}</h5>
                        </div>
                    </div>
                @endif

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Payment Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul>
                                <li class="list-group-item d-flex">
                                    <span>{{ $orderItemsCount }} x {{ $item->name }}</span>
                                    <span class="ms-auto">₹{{ number_format($order->subtotal,2) }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span>Discount {{ (!empty($order->coupon_code)) ? '('.$order->coupon_code.')' : '' }}</span>
                                    <span class="ms-auto discount-text">- ₹{{ number_format($order->discount,2) }}</span>
                                </li>
                                <hr />
                                <li class="list-group-item d-flex">
                                    <span>Discounted price {{ (!empty($order->coupon_code)) ? '('.$order->coupon_code.')' : '' }}</span>
                                    <span class="ms-auto discount-text">- ₹{{ number_format($order->discount,2) }}</span>
                                </li>
                                <hr />
                                <li class="list-group-item d-flex">
                                    <span>Coupon Discount {{ (!empty($order->coupon_code)) ? '('.$order->coupon_code.')' : '' }}</span>
                                    <span class="ms-auto discount-text">- ₹{{ number_format($order->discount,2) }}</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span>Platform Fees</span>
                                    <span class="ms-auto">₹{{ number_format($order->shipping,2) }}</span>
                                </li>
                                <hr />
                                <li class="list-group-item d-flex fs-lg fw-bold">
                                    <span>Total Paid</span>
                                    <span class="ms-auto">₹{{ number_format($order->grandtotal,2) }}</span>
                                </li>                                
                            </ul>
                            <div class="paid-by">Paid by UPI</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary w-100">Get Invoice</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
