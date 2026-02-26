@extends('admin.layouts.app')

@section('content')
    
    <div class="card mb-0">
        <div class="card-body pb-0">
            <div class="row mb-2">
                <div class="col-sm-10 col-12 d-flex">
                    <h3>Order: #{{ $order->id }}</h3>
                </div>
                <div class="col-sm-2 col-12">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary float-end">Back to Order</a>
                </div>
            </div>
        </div>
    </div>
   
    <div class="card">
        <div class="card-body py-0">                
            @include('admin.message')
            <div class="row">                
                <div class="col-md-9 col-12">                       
                    <div class="row">                
                        <div class="col-md-8 col-12">
                            <div class="card border mb-2">
                                <div class="card-body">                                    
                                    <div class="small-fonts">
                                        <h4 class="mb-1 mt-0">{{ $order->name}}</h4>
                                        <p class="mb-0 mt-0">{{ $order->address }}</p>
                                        <p class="mb-0 mt-0">{{ $order->locality }}, {{ $order->city }} - {{ $order->zip }}.</p>
                                        <p class="mb-0 mt-0">{{ $order->stateName }}.</p>
                                        <p class="mb-0 mt-0">Mobile: {{ $order->mobile }}</p>
                                    </div>                                   
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card border mb-2">
                                <div class="card-body">                                    
                                    <div class="small-fonts">                                                         
                                        <div class="flex-details">
                                            <p class="label">Invoice No.</p>
                                            <p class="right">: {{ $order->id }}</p>
                                        </div>
                                        <div class="flex-details">
                                            <p class="label">Order ID</p>
                                            <p class="right">: {{ $order->id }}</p>
                                        </div>
                                        <div class="flex-details">
                                            <p class="label">Total</p>
                                            <p class="right">: ₹{{ number_format($order->grandtotal,2) }}</p>
                                        </div>
                                        <div class="flex-details">
                                            <p class="label">Shipped Date</p>
                                            <p class="right">:                                        
                                                @if (!empty($order->shipped_date))
                                                    {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y')}}
                                                @else
                                                    Pending
                                                @endif                                        
                                            </p>                           
                                        </div>
                                        <div class="flex-details">
                                            <p class="label">Status</p>                                        
                                            <p class="right">:
                                                @if ($order->status == 'pending')
                                                    <span class="badge bg-danger">Pending</span>
                                                @elseif ($order->status == 'shipped')
                                                    <span class="badge bg-info">Shipped</span>
                                                @elseif ($order->status == 'delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                @else
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @endif
                                            </p>
                                        </div>                                         
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border">
                        <div class="card-body"> 
                            <table class="table">
                                <thead class="table-light">  
                                    <tr>
                                        <th class="border-top-0">Products details</th>                                
                                        <th class="border-top-0 text-end" width="130">Qty</th>
                                        <th class="border-top-0 text-end" width="130">Price</th>
                                        <th class="border-top-0 text-end" width="100">Amount</th>
                                    </tr>                                                    
                                </thead>
                                <tbody>
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">        
                                                    @php
                                                        $image = $item->product?->images->first();
                                                    @endphp

                                                    <a href="{{ route('front.product', $item->product->slug) }}" target="_blank">
                                                        @if($image)
                                                            <img src="{{ asset('uploads/product/small/'.$image->image) }}" height="90" class="me-3 align-self-center rounded">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" width="60">
                                                        @endif
                                                    </a>                                        
                                                    <div class="flex-grow-1 text-truncate">
                                                        <h5 class="product-title">
                                                            <a href="{{ route('front.product', $item->product->slug) }}" target="_blank">{{ Str::limit($item->product->title, 75, '...') }}</a>
                                                        </h5>
                                                        <div class="small-fonts">
                                                            <p class="mb-0"><span class="text-muted">Size: </span> {{ $item->size }}</p>
                                                            <p class="mb-0"><span class="text-muted">Color: </span>{{ $item->color }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>                                                                                                            
                                            <td class="text-end"><p class="mt-3">{{ $item->qty }}</p></td>
                                            <td class="text-end"><p class="mt-3">₹{{ $item->total }}</p></td>
                                            <td class="text-end"><p class="mt-3">₹{{ $item->qty*$item->price }}</p></td>                                    
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">Subtotal:</td>
                                            <td class="text-end"><b>₹{{ $order->subtotal }}</b></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">Discount: {{ (!empty($order->coupon_code)) ? '('.$order->coupon_code.')' : '' }}</td>                                    
                                            <td class="text-end">₹ {{ $order->discount }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">Shipping:</td>
                                            <td class="text-end">₹ {{ $order->shipping }}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end"><b>Grand Total:</b></td>
                                            <td class="text-end"><b>₹{{ $order->grandtotal }}</b></td>
                                        </tr>
                                </tbody>
                            </table>                                             
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-12">             
                    <div class="card border">
                        <div class="card-body">
                            <form action="" method="post" name="changeOrderStatusForm" id="changeOrderStatusForm">                        
                                <h5 class="mb-2">Order Status</h4>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="pending" {{ ($order->status == 'pending') ? 'selected' : ''}}>Pending</option>
                                        <option value="shipped" {{ ($order->status == 'shipped') ? 'selected' : ''}}>Shipped</option>
                                        <option value="delivered" {{ ($order->status == 'delivered') ? 'selected' : ''}}>Delivered</option>
                                        <option value="cancelled" {{ ($order->status == 'cancelled') ? 'selected' : ''}}>Cancelled</option>
                                    </select>                                
                                </div>
                                <div class="mb-1">
                                    <div class="form-group">
                                        <label for="shipped_date">Shipped Date</label>
                                        <input placeholder="Shipped Date" autocomplete="off" value="{{ $order->shipped_date }}" type="date" name="shipped_date" id="shipped_date" class="form-control">
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <button class="btn btn-primary">Update</button>
                                </div>                        
                            </form>
                        </div>
                    </div>

                    <div class="card border">
                        <div class="card-body">
                            <form action="" method="post" name="sendInvoiceEmail" id="sendInvoiceEmail">
                                <h5 class="mb-2">Send Inovice Email</h5>
                                <select name="userType" id="userType" class="form-select">
                                    <option value="customer">Customer</option>
                                    <option value="admin">Admin</option>
                                </select>                            
                                <div class="mt-2">
                                    <button class="btn btn-primary">Send Invoice</button>
                                </div>
                            </form>   
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </section>
@endsection

@section('customJs')
    <script>
        // $(document).ready(function(){
        //     $('#shipped_date').datetimepicker({
        //         format:'Y-m-d H:i:s',
        //     });
        // });

        $("#changeOrderStatusForm").submit(function(event){
            event.preventDefault();
            var element = $(this);

            if (confirm("Are you sure you want to change status?")){
                $.ajax({
                    url: '{{ route("orders.changeOrderStatus",$order->id) }}',
                    type: 'post',
                    data: element.serializeArray(),
                    dataType: 'json',
                    success: function(response){
                        window.location.href='{{ route("orders.detail",$order->id ) }}';
                    }
                });
            }
        });

        $("#sendInvoiceEmail").submit(function(event){
            event.preventDefault();
            var element = $(this);

            if (confirm("Are you sure you want to send email?")){
                $.ajax({
                    url: '{{ route("orders.sendInvoiceEmail",$order->id) }}',
                    type: 'post',
                    data: element.serializeArray(),
                    dataType: 'json',
                    success: function(response){
                        window.location.href='{{ route("orders.detail",$order->id ) }}';
                    }
                });
            }
        });
    </script>
@endsection
