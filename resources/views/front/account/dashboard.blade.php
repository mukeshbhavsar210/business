@extends('front.layouts.app')

@section('title', 'My Dashboard')

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

            @include('front.account.common.modal', [
                'form' => $profileFormConfig,
                'model' => $user
            ])          

            <div class="orders-details">
                <div class="showcase">
                    <div class="photo-email">
                        <div class="flex">
                            <div class="photo">
                                <img src="{{ asset('uploads/profile/' . Auth::user()->image) }}" class="profile-pic">                                
                            </div>
                            <div class="email">
                                <h6>{{ $user->name }}</h6>
                                <p>{{ $user->email }}</p>
                                <p class="mt-2"><a href="javascript:0" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</a></p>
                            </div>            
                        </div>      
                        <div class="edit">                                                        
                            <p><a href="{{ route('account.logout') }}" class="btn btn-outline-danger btn-sm">Logout</a></p>
                        </div>                              
                    </div>
                </div>            

                <div class="card-link">
                    <div class="product-item">
                        <a href="{{ route('account.orders') }}" class="link dash-icon-1">
                            <span class="sprites"></span>
                            <h4>Orders</h4>
                            <p>Check your order status</p>
                        </a>
                    </div>
                        <div class="product-item">
                            <a href="{{ route('account.wishlist') }}" class="link dash-icon-2">
                                <span class="sprites"></span>
                                <h4>Wishlist</h4>
                                <p>Check your order status</p>
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="{{ route('account.cards') }}" class="link dash-icon-3">
                                <span class="sprites"></span>
                                <h4>Saved Card</h4>
                                <p>Check your order status</p>
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="{{ route('account.address') }}" class="link dash-icon-4">
                                <span class="sprites"></span>
                                <h4>Addresses</h4>
                                <p>Check your order status</p>
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="{{ route('account.coupons') }}" class="link dash-icon-5">
                                <span class="sprites"></span>
                                <h4>Coupons</h4>
                                <p>Check your order status</p>
                            </a>
                        </div>
                        <div class="product-item">
                            <a href="{{ route('account.profile') }}" class="link dash-icon-6">
                                <span class="sprites"></span>
                                <h4>Profile Details</h4>
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