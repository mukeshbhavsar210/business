@extends('admin.layouts.app')

@section('content')

@include('admin.message')

    <div class="card custom-card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="row">
                    <div class="col-sm-7 col-12 d-flex">
                        <h3>Discount Coupon</h3>  
                        <span class="counts">{{ $discountCoupons->total() }}</span>
                    </div>
                    <div class="col-sm-5 col-12 float-end">
                        <div class="flexContainer">
                            <form action="" method="get" >
                                <div class="d-flex">
                                    <div class="card-title">
                                        <button type="button" onclick="window.location.href='{{ route('coupons.index') }}'" class="btn btn-default btn-sm">
                                            <?xml version="1.0" encoding="utf-8"?>
                                                <svg width="20px" height="20px" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                                <g fill="none" fill-rule="evenodd" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" transform="matrix(0 1 1 0 2.5 2.5)">
                                                <path d="m3.98652376 1.07807068c-2.38377179 1.38514556-3.98652376 3.96636605-3.98652376 6.92192932 0 4.418278 3.581722 8 8 8s8-3.581722 8-8-3.581722-8-8-8"/>
                                                <path d="m4 1v4h-4" transform="matrix(1 0 0 -1 0 6)"/>
                                                </g>
                                            </svg>
                                        </button>
                                    </div>                
                                    <div class="card-tools">
                                        <div class="input-group input-group searchMain" >
                                            <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                
                                            <div class="input-group-append">
                                                <button type="submit" class="btn">
                                                    <i class="iconoir-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createDiscountModal">Create Discount</button>                            
                        </div>
                    </div>
                </div>                        
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">               
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-top-0" width="30">ID</th>
                            <th class="border-top-0">Name</th>
                            <th class="border-top-0" width="120">Code</th>
                            <th class="border-top-0" width="120">Discount</th>
                            <th class="border-top-0" width="130">Start Date</th>
                            <th class="border-top-0" width="130">End Date</th>                            
                            <th class="border-top-0 text-end" width="120">Action</th>                            
                        </tr>
                    </thead>                     
                    <tbody>
                        @if ($discountCoupons->isNotEmpty())
                            @foreach ($discountCoupons as $discountCoupon)
                                <tr>
                                    <td>{{ $discountCoupon->id }}</td>
                                    <td>{{ $discountCoupon->name }}</td>
                                    <td>{{ $discountCoupon->code }}</td>
                                    <td>
                                        @if ($discountCoupon->type == 'percent')
                                            {{ $discountCoupon->discount_amount }}%
                                        @else
                                            ₹ {{ $discountCoupon->discount_amount }}.00
                                        @endif
                                    </td>

                                    <td>{{ !empty($discountCoupon->starts_at) ? \Carbon\Carbon::parse($discountCoupon->starts_at)->format('d, M Y') : '' }}</td>
                                    <td>{{ !empty($discountCoupon->expires_at) ? \Carbon\Carbon::parse($discountCoupon->expires_at)->format('d, M Y') : '' }}</td>

                                    <td class="text-end">
                                        @if($discountCoupon->status == 1)
                                            <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                        <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @endif

                                        <a href="{{ route('coupons.edit', $discountCoupon->id ) }}">
                                            <i class="las la-pen text-secondary fs-18"></i>
                                        </a>
                                        <a href="#" onclick="deleteCoupon({{ $discountCoupon->id }})" class="text-danger w-4 h-4">
                                           <i class="las la-trash-alt text-secondary fs-18"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Records not found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>   

    <div class="modal fade" id="createDiscountModal" tabindex="-1" aria-labelledby="createDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createDiscountModalLabel">Create Discount</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('coupons.store') }}" method="POST" id="discountForm" name="discountForm">
                    @csrf                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-7 col-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Coupon Code Name">
                                            <p></p>
                                        </div>
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="code">Code</label>
                                            <input type="text" name="code" id="code" class="form-control" placeholder="Coupon Code">
                                            <p></p>
                                        </div>
                                    </div>                                                                       
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="max_uses">Max uses</label>
                                            <input type="number" name="max_uses" id="max_uses" class="form-control" placeholder="Max Uses">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="max_uses_user">Max uses User</label>
                                            <input type="text" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max uses User">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Type</label>
                                            <select name="type" id="type" class="form-select">
                                                <option value="Percent">Percent</option>
                                                <option value="Fixed">Fixed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="discount_amount">Discount Amount</label>
                                            <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount amount">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="min_amount">Min Amount</label>
                                            <input type="text" name="min_amount" id="min_amount" class="form-control" placeholder="Min Amount">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="1">Active</option>
                                                <option value="0">Block</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            <div class="col-md-5 col-12">
                                <div class="row">
                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="starts_at">Starts at</label>
                                            <input autocomplete="off" type="date" name="starts_at" id="starts_at" class="form-control" placeholder="Starts at">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="expires_at">Expires at</label>
                                            <input autocomplete="off" type="date" name="expires_at" id="expires_at" class="form-control" placeholder="Expires at">
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
                                    <p></p>
                                </div>
                            </div>
                        </div>                                               
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{ $discountCoupons->links() }}    
@endsection

@section('customJs')
<script>
     $(document).ready(function () {
        $("#discountForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('coupons.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createDiscountModal')
                    );
                    modal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });              
    
        // $('#starts_at').datetimepicker({
        //     format:'Y-m-d H:i:s',
        // });

        // $('#expires_at').datetimepicker({
        //     format:'Y-m-d H:i:s',
        // });
    });

    function deleteCoupon(id){
        var url = '{{ route("coupons.delete","ID") }}'
        var newUrl = url.replace("ID",id)

        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response["status"]){
                        window.location.href="{{ route('coupons.index') }}"
                    }
                }
            });
        }
    }
</script>
@endsection
