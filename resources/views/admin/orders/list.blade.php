@extends('admin.layouts.app')

@section('content')

@include('admin.message')

<div class="card mb-0"> 
    <ul class="nav nav-tabs" role="tablist">        
        <li class="nav-item" role="presentation">
            <a class="nav-link active py-2" data-bs-toggle="tab" href="#pending" role="tab" aria-selected="false" tabindex="-1">                                            
                Pending              
                <span class="counts">{{ $confirmed_orders->total() }}</span>
            </a>
        </li>                                                
        <li class="nav-item" role="presentation">
            <a class="nav-link py-2" data-bs-toggle="tab" href="#shipped" role="tab" aria-selected="false" tabindex="-1">
                Shipped
                <span class="counts">{{ $shipped_orders->total() }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link  py-2" data-bs-toggle="tab" href="#delivered" role="tab" aria-selected="true">
                Delivered
                <span class="counts">{{ $delivered_orders->total() }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link py-2" data-bs-toggle="tab" href="#cancelled" role="tab" aria-selected="false" tabindex="-1">
                Cancelled                
                <span class="counts">{{ $cancelled_orders->total() }}</span>
            </a>
        </li>
    </ul>                           
</div>
                           
<div class="card">
    <div class="card-body">                                    
        <div class="tab-content">
            @include('admin/orders/tab1')
            @include('admin/orders/tab2')
            @include('admin/orders/tab3')
            @include('admin/orders/tab4')
        </div>
    </div>
</div>
@endsection