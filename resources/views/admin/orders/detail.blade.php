@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order: #{{ $order->id }}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                @include('admin.message')
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header pt-3">
                            <h1 class="h5 mb-3">Shipping Address</h1>
                            <div class="row invoice-info">
                                <div class="col-sm-8 invoice-col">
                                    <address>
                                        <h4>{{ $order->first_name.' '.$order->last_name.'' }} </h4>
                                        {{ $order->address }}<br>
                                        {{ $order->city }}, {{ $order->state }}-{{ $order->zip }}, {{ $order->countryName }}.<br>
                                        Phone: {{ $order->mobile }}<br>
                                        Email: {{ $order->email }}
                                    </address>
                                </div>

                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-6 text-right">Invoice</div>
                                        <div class="col-sm-6"><b>#007612</b></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 text-right"><span>Order ID:</span></div>
                                        <div class="col-sm-6"><b>{{ $order->id }}</b></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 text-right"><span>Total:</span></div>
                                        <div class="col-sm-6"><b>₹ {{ number_format($order->grandtotal,2) }}</b></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 text-right"><span>Status:</span></div>
                                        <div class="col-sm-6">
                                            @if ($order->status == 'pending')
                                                <span class="badge bg-danger">Pending</span>
                                            @elseif ($order->status == 'shipped')
                                                <span class="badge bg-info">Shipped</span>
                                            @elseif ($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 text-right"><span>Shipped Date:</span></div>
                                        <div class="col-sm-6">
                                            <b>
                                                @if (!empty($order->shipped_date))
                                                    {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, y')}}
                                                @else
                                                    n/a
                                                @endif
                                            </b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                            <div class="card-body table-responsive p-3">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-right" width="100">Price</th>
                                            <th class="text-center" width="100">Qty</th>
                                            <th class="text-right" width="100">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $item)

                                        @endforeach
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td class="text-right">₹ {{ number_format($item->price,2) }}</td>
                                            <td class="text-center">{{ $item->qty }}</td>
                                            <td class="text-right">₹ {{ number_format($item->total,2) }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-right">Subtotal:</td>
                                            <td class="text-right">₹ {{ number_format($order->subtotal,2) }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-right">Discount: {{ (!empty($order->coupon_code)) ? '('.$order->coupon_code.')' : '' }}</td>
                                            <td class="text-right">₹ {{ number_format($order->discount,2) }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-right">Shipping:</td>
                                            <td class="text-right">₹ {{ number_format($order->shipping,2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right">Grand Total:</td>
                                            <th class="text-right">₹ {{ number_format($order->grandtotal,2) }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <form action="" method="post" name="changeOrderStatusForm" id="changeOrderStatusForm">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Order Status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="pending" {{ ($order->status == 'pending') ? 'selected' : ''}}>Pending</option>
                                            <option value="shipped" {{ ($order->status == 'shipped') ? 'selected' : ''}}>Shipped</option>
                                            <option value="delivered" {{ ($order->status == 'delivered') ? 'selected' : ''}}>Delivered</option>
                                            <option value="cancelled" {{ ($order->status == 'cancelled') ? 'selected' : ''}}>Cancelled</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="shipped_date">Shipped Date</label>
                                        <input placeholder="Shipped Date" autocomplete="off" value="{{ $order->shipped_date }}" type="text" name="shipped_date" id="shipped_date" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="post" name="sendInvoiceEmail" id="sendInvoiceEmail">
                                    <h2 class="h4 mb-3">Send Inovice Email</h2>
                                    <div class="mb-3">
                                        <select name="userType" id="userType" class="form-control">
                                            <option value="customer">Customer</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary">Send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('customJs')
    <script>
        $(document).ready(function(){
            $('#shipped_date').datetimepicker({
                format:'Y-m-d H:i:s',
            });
        });

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
