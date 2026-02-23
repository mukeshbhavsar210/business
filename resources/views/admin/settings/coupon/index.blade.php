@extends('admin.layouts.app')

@section('content')

    @include('admin.layouts.common')

    <div class="card custom-card">
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
    {{ $discountCoupons->links() }}    
@endsection

@section('customJs')
<script>
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
