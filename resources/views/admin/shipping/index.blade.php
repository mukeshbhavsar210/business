@extends('admin.layouts.app')

@section('content')

@include('admin.message')

<div class="card custom-card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="row">
                <div class="col-sm-8 col-12 d-flex">
                    <h3>Shipping Management</h3>
                </div>
                <div class="col-sm-4 col-12 float-end">
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createStateModal">Add State</button>                        
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
        
        <div class="modal fade" id="createStateModal" tabindex="-1" aria-labelledby="createStateModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createStateModalLabel">Add State</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('shipping.store') }}" method="POST" id="shippingForm" name="shippingForm">
                        @csrf                    
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select name="state_id" id="state_id" class="form-select">
                                            <option value="">Select a State</option>
                                            @if ($states->isNotEmpty())
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                                <option value="rest_of_state">Rest of the state</option>
                                            @endif
                                        </select>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="text" name="amount" id="amount" class="form-control" placeholder="Amount">
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
    </div>
@endsection

@section('customJs')
    <script>
        $(document).ready(function () {
            $("#shippingForm").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('shipping.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        var modal = bootstrap.Modal.getInstance(
                            document.getElementById('createStateModal')
                        );
                        modal.hide();
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });              
        
        
        $(document).on('submit', '#editShippingForm', function (e) {
            e.preventDefault();
            var id = $('#edit_id').val();
            $.ajax({
                url: '/shipping/' + id + '/update',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {

                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('editShippingModal')
                    );
                    modal.hide();
                    location.reload();
                }
            });
        });

    });


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