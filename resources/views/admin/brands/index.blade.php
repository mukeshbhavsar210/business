@extends('admin.layouts.app')

@section('content')

@include('admin.message')

<div class="card custom-card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="row">
                    <div class="col-sm-7 col-12 d-flex">
                        <h3>Brands</h3>  
                        <span class="counts">{{ $brands->total() }}</span>
                    </div>
                    <div class="col-sm-5 col-12 float-end">
                        <div class="flexContainer">
                            <form action="" method="get" >
                                <div class="d-flex">
                                    <div class="card-title">
                                        <button type="button" onclick="window.location.href='{{ route('brands.index') }}'" class="btn btn-default btn-sm">
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

                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createBrandModal">Create Brand</button>                            
                        </div>
                    </div>
                </div>                        
            </div>
        </div>

        <div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createBrandModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createBrandModalLabel">Create Brand</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('shipping.store') }}" method="POST" id="createBrandForm" name="createBrandForm">
                        @csrf                    
                        <div class="modal-body">
                            {{-- <form action="" method="post" id="createBrandForm" name="createBrandForm">                                                                       --}}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                <p></p>
                            </div>
                        
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input readonly type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                <p></p>
                            </div>
                        
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Block</option>
                                </select>                                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Brand</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @php
                    use Illuminate\Support\Str;
                @endphp

                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-top-0" width="40">ID</th>
                            <th class="border-top-0" >Name</th>
                            <th class="border-top-0" width="30">Status</th>
                            <th class="border-top-0" width="100">Action</th>
                        </tr>
                    </thead>                     
                    <tbody>
                        @if ($brands->isNotEmpty())
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $brand->id }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        @if($brand->status == 1)
                                            <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else

                                        <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @endif
                                    </td>
                                    <td>                                        
                                        <a href="#" onclick="deleteBrand({{ $brand->id }})" class="text-danger w-4 h-4">
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

            <div class="card-footer clearfix">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $(document).ready(function () {
        $("#createBrandForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('brands.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createBrandModal')
                    );
                    modal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });

    $('#name').change(function(){
        element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'get',
            data: {title: element.val()},
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if(response["status"] == true){
                    $("#slug").val(response["slug"]);
                }
            }
        });
    })

    function deleteBrand(id){
        var url = '{{ route("brands.delete","ID") }}'
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
                        window.location.href="{{ route('brands.index') }}"
                    }
                }
            });
        }

    }
</script>
@endsection
