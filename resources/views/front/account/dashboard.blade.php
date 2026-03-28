@extends('front.layouts.app')

@section('content')

<div class="container">
    <div class="small-title">
        <h4>Account</h4>
        <p>{{ currentUserName() }}</p>
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            @include('front.account.common.sidebar')  
        </div>
        <div class="col-md-9 col-12">
            @include('front.account.common.message')

            <div class="orders-details">
                <div class="showcase">
                    <div class="photo-email">
                        <div class="flex">
                            <div class="photo">
                                {{ $user->image }}
                            </div>
                            <div class="email">
                                {{ $user->email }}
                            </div>            
                        </div>      
                        <div class="edit">                            
                            <a href="{{ route('account.profile') }}" class="btn btn-outline-dark btn-sm">Edit Profile</a>
                        </div>                              
                    </div>
                </div>            

                <div class="card-link">
                    <div class="product-item">
                        <a href="#" class="link">
                            <h4>Orders</h4>
                            <p>Check your order status</p>
                        </a>
                    </div>
                        <div class="product-item">
                            <a href="#" class="link">
                                <h4>Orders</h4>
                                <p>Check your order status</p>
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="#" class="link">
                                <h4>Orders</h4>
                                <p>Check your order status</p>
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="#" class="link">
                                <h4>Orders</h4>
                                <p>Check your order status</p>
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="#" class="link">
                                <h4>Orders</h4>
                                <p>Check your order status</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                   
</div>            

@endsection

@section('customJs')

@endsection