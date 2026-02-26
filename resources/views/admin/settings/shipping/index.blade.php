@extends('admin.layouts.app')

@section('content')

@include('admin.layouts.common')

<div class="card">
    <div class="card-body py-2">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                <tr>
                    <th class="border-top-0" width="30">ID</th>
                    <th class="border-top-0" width="300">State Name</th>
                    <th class="border-top-0" width="300">Amount</th>                                    
                    <th class="border-top-0" width="100">Action</th>
                </tr>
            </thead>                     
            <tbody>                        
                @if ($shippings->isNotEmpty())
                    @foreach ($shippings as $shipping)
                    <tr>
                        <td>{{ $shipping->id }}</td>
                        <td>{{ ($shipping->state_id == 'rest_of_state') ? 'Rest of the state 2' : $shipping->name }}</td>
                        <td>₹{{ $shipping->amount }}.00</td>
                        <td>
                            <a href="javascript:void(0);" onclick="deleteRecord( {{ $shipping->id}} )" class="text-danger w-4 h-4">
                                <i class="las la-trash-alt text-secondary fs-18"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </table>
        </div>        
    </div>
@endsection

@section('customJs')
    <script>
        function deleteRecord(id){
            var url = '{{ route("shipping.delete","ID") }}'
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
                            window.location.href="{{ route('shipping.index') }}"
                        }
                    }
                });
            }
        }
    </script>
@endsection