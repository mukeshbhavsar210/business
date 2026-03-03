@extends('front.layouts.app')

@section('content')
<div class="container-small">
    <div class="small-title">
        <h4>Account</h4>
        <p>{{ $userDetails->name }}</p>
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            <div class="sticky">
                @include('front.account.common.sidebar')
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="details-accounts"> 
                <div class="order-history">
                    Product will come
                </div>

                <div class="order-history">
                    <form method="POST" action="{{ route('account.order.cancel', $order->id) }}">
                        @csrf
                        
                        <div class="individual">
                            <h5>Reason for Cancellation</h5>
                            <p>Please tell us correct reason for cancellation. This information is only used to improve our service</p>                
                            
                            <hr />

                            <h5 class="mb-3">Select Reason</h5>
                            
                            <div class="reason-group">
                                <label class="custom-radio">
                                    <input type="radio" name="cancel_reason" value="Incorrect size ordered" required>
                                    <span class="radio-mark"></span>
                                    Incorrect size ordered
                                </label>

                                <label class="custom-radio">
                                    <input type="radio" name="cancel_reason" value="Product not required anymore" required>
                                    <span class="radio-mark"></span>
                                    Product not required anymore
                                </label>

                                <label class="custom-radio">
                                    <input type="radio" name="cancel_reason" value="Cash issue" required>
                                    <span class="radio-mark"></span>
                                    Cash issue
                                </label>

                                <label class="custom-radio">
                                    <input type="radio" name="cancel_reason" value="Ordered by mistake">
                                    <span class="radio-mark"></span>
                                    Ordered by mistake
                                </label>

                                <label class="custom-radio">
                                    <input type="radio" name="cancel_reason" value="Wants to change style/color">
                                    <span class="radio-mark"></span>
                                    Wants to change style/color
                                </label>

                                <label class="custom-radio">
                                    <input type="radio" name="cancel_reason" value="Delayed Delivery Cancellation">
                                    <span class="radio-mark"></span>
                                    Delayed Delivery Cancellation
                                </label>
                            
                                <label class="custom-radio">
                                    <input type="radio" name="cancel_reason" value="Duplicate order">
                                    <span class="radio-mark"></span>
                                    Duplicate order
                                </label>
                            </div>
                        </div>
                        
                        <textarea name="cancel_comments" class="form-control" placeholder="Additional comments" rows="3"></textarea>                        

                        <div class="flex-end">
                            <div>
                                <p class="mt-2">Refund Details</p>                                
                            </div>
                            <div>
                                <button type="submit" class="btn btn-danger mt-3">Cancel Order</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection