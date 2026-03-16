@extends('admin.layouts.app')

@section('content')

<div class="card mb-0 pb-0">
    <div class="card-body pb-0">
        <div class="row">
            <div class="col">          
                <div class="page-title">            
                    <h4>Category </h4>                    
                    <span class="counts">{{ $categories->total() }}</span>
                </div>
            </div>
            <div class="col-auto"> 
                <div class="flexContainer">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuBtn">
                            + ADD
                        </button>

                        <ul class="dropdown-menu" id="dropdownMenu">
                            <li><a class="dropdown-item open-modal" href="#" data-target="#createCategory">Category</a></li>
                            <li><a class="dropdown-item open-modal" href="#" data-target="#createSubCategory">Sub Category</a></li>
                            <li><a class="dropdown-item open-modal" href="#" data-target="#createSub2Category">Sub Sub Category</a></li>
                        </ul>
                    </div>  

                    <form action="" method="get" >
                        <div class="d-flex">
                            <div class="card-title">
                                <button type="button" onclick="window.location.href='{{ route('categories.index') }}'" class="btn btn-default btn-sm">
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
                </div>
            </div>
        </div>        
    </div>
</div>

<div class="card mt-0">    
    <div class="row">
        <div class="col-12">                            
            <div class="card">
                <div class="card-body">                                    
                    <div class="accordion" id="categoryAccordion">
                        @foreach ($categories as $category)
                            <div class="accordion-item">                                
                                <div class="accordion-header" id="cat{{ $category->id }}">
                                    <button class="accordion-button collapsed p-2" data-bs-toggle="collapse"
                                        data-bs-target="#catCollapse{{ $category->id }}">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('products.edit', $category->id) }}">
                                                <img src="{{ asset('uploads/category/'.$category->image) }}" alt="" height="75" width="75" class="me-2 align-self-center rounded" />
                                            </a>
                                            <div class="flex">
                                                <div class="flex-grow-1">
                                                    <h5 class="product-title">{{ $category->category_name }} <span>({{ $category->sub_categories_count }})</span></h5>
                                                    <p>Show: {{ $category->showHome }}</p>
                                                </div>
                                                {{-- <a href="{{ route('products.edit', $category->id) }}" class="float-end"><i class="las la-pen text-secondary fs-18"></i></a> --}}
                                            </div>
                                        </div>                                        
                                    </button>
                                </div>

                                <div id="catCollapse{{ $category->id }}" class="accordion-collapse collapse" data-bs-parent="#categoryAccordion">
                                    <div class="accordion-body">
                                        <div class="accordion" id="subAccordion{{ $category->id }}">
                                        @foreach ($category->subCategories as $sub)
                                            <div class="accordion-item">                                                
                                                <div class="accordion-header" id="sub{{ $sub->id }}">                                                    
                                                    <button class="accordion-button collapsed p-2" data-bs-toggle="collapse" data-bs-target="#subCollapse{{ $sub->id }}">
                                                        <div class="flex">
                                                            <h5 class="product-title">{{ $sub->sub_category_name }} ({{ $sub->sub_sub_categories_count }})</h5>
                                                            <p class="m-0 float-end">
                                                                <a href="{{ route('sub_category.edit', $sub->id ) }}">
                                                                    <i class="las la-pen text-secondary fs-18"></i>
                                                                </a>
                                                                <a href="#" onclick="deleteSubCategory({{ $sub->id }})" class="text-danger w-4 h-4">
                                                                    <i class="las la-trash-alt text-secondary fs-18"></i>
                                                                </a>
                                                            </p>
                                                        </div>                                                        
                                                    </button>                                                    
                                                </div>

                                                <div id="subCollapse{{ $sub->id }}" class="accordion-collapse collapse" data-bs-parent="#subAccordion{{ $category->id }}">
                                                    <div class="accordion-body p-0">
                                                        {{-- {{ $sub->subSubCategories->count() }} --}}
                                                        <table class="table mb-0">
                                                            <thead class="table-light">  
                                                                <tr>
                                                                    <th width="70">ID</th>
                                                                    <th>Sub Sub Category</th>
                                                                    <th width="100">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($sub->subSubCategories as $child)
                                                                    <tr>
                                                                        <td>{{ $child->id }}</td>
                                                                        <td>{{ $child->sub_sub_category_name }}</td>
                                                                        <td>
                                                                            <a href="{{ route('sub2_category.edit', $child->id ) }}">
                                                                                <i class="las la-pen text-secondary fs-18"></i>
                                                                            </a>
                                                                            <a href="#" onclick="deleteSub2Category({{ $child->id }})" class="text-danger w-4 h-4">
                                                                                <i class="las la-trash-alt text-secondary fs-18"></i>
                                                                            </a>                                                                            
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>                                                                                                    
    </div>
                    
    {{ $categories->links() }}    
</div>         

<div class="modal fade" id="createCategory" tabindex="-1" aria-labelledby="createCategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createCategoryLabel">Create Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('category.store') }}" method="POST" id="createCategoryForm" name="createCategoryForm">
                    @csrf                    
                    <div class="modal-body">                                                    
                        <div class="form-group">
                            <label for="category_name">Name</label>
                            <input type="text" name="category_name" id="category_name" class="slug-source form-control" data-target="#category_slug">
                            <input type="hidden" readonly id="category_slug" name="category_slug" class="form-control">
                            <p></p>
                        </div>                                 
                        <div class="row">
                            <div class="col-md-4 col-4">
                                <div class="form-group">
                                    <label for="menu_order">Order</label>
                                    <select name="menu_order" id="menu_order" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>                                
                                </div>                                
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group">
                                    <label for="showHome">Show on Home</label>
                                    <select name="showHome" id="showHome" class="form-select">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>                                
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>                                
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="image_id" name="image_id" value=" ">
                            <label for="image">Image</label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
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

<div class="modal fade" id="createSubCategory" tabindex="-1" aria-labelledby="createSubCategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createSubCategoryLabel">Create Sub Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('sub_category.store') }}" method="POST" id="createSubCategoryForm" name="createSubCategoryForm">
                    @csrf                    
                    <div class="modal-body">                        
                        <div class="form-group">
                            <label for="name">Category</label>
                            <select name="category_id" id="category" class="form-select">
                                <option value="">Select a Category</option>
                                @if($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label for="subcategory_name">Name</label>
                            <input type="text" name="sub_category_name" id="sub_category_name" class="form-control slug-source" data-target="#sub_category_slug">
                            <input type="hidden" readonly id="sub_category_slug" name="sub_category_slug" class="form-control">                                                        
                            <p></p>
                        </div>                    
                        
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="showHome">Show on Home</label>
                                    <select name="showHome" id="showHome" class="form-select">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
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

 <div class="modal fade" id="createSub2Category" tabindex="-1" aria-labelledby="createSub2CategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createSub2CategoryLabel">Create Sub2 Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('sub2_category.store') }}" method="POST" id="createSub2CategoryForm" name="createSub2CategoryForm">
                    @csrf                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" id="category_id" class="form-select">
                                <option value="">Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Sub Category</label>
                            <select name="sub_category_id" id="sub_category" class="form-select" >
                                <option value="">Sub Category</option>
                            </select>
                        </div>                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="sub2_category_name" id="sub2_category_name" class="slug-source form-control" data-target="#sub2_category_slug">
                            <input type="hidden" id="sub2_category_slug" name="sub2_category_slug" class="form-control" >                            
                            <p></p>
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
        $("#createCategoryForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('category.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createCategory')
                    );
                    modal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }); 


        $(document).on('change', '#category_id', function () {
            var categoryID = $(this).val();

            if (categoryID) {
                $('#sub_category').html('<option>Loading...</option>');

                $.ajax({
                     url: "{{ route('get.subcategories', ':id') }}".replace(':id', categoryID),
                    type: 'GET',
                    success: function (data) {

                        $('#sub_category').html('<option value="">Select Sub Category</option>');

                        $.each(data, function (key, value) {
                            $('#sub_category').append(
                                '<option value="' + value.id + '">' + value.sub_category_name + '</option>'
                            );
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });

            } else {
                $('#sub_category').html('<option value="">Select Sub Category</option>');
            }

        });


        $("#createSubCategoryForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('sub_category.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createSubCategory')
                    );
                    modal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });


        $("#createSub2CategoryForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('sub2_category.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createSub2Category')
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


    $(document).on('change', '.slug-source', function () {
        let element = $(this);
        let target = element.data('target');

        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'GET',
            data: { title: element.val() },
            dataType: 'json',
            success: function (response) {

                $("button[type=submit]").prop('disabled', false);

                if (response.status === true) {
                    $(target).val(response.slug);
                }
            }
        });
    });


    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
        },
        url:  "{{ route('temp-images.create') }}",
        maxFiles: 1,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.image_id);
            console.log(response)
        }
    });


   


    function deleteCategory(id){
        var url = '{{ route("category.delete","ID") }}'
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
                        window.location.href="{{ route('categories.index') }}"
                    }
                }
            });
        }
    }


    function deleteSubCategory(id){
        var url = '{{ route("sub_category.delete","ID") }}'
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
                    window.location.href="{{ route('categories.index') }}"
                   
                }
            });
        }

    }


    function deleteSub2Category(id){
        var url = '{{ route("sub2_category.delete","ID") }}'
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
                    window.location.href="{{ route('categories.index') }}"
                    
                }
            });
        }
    }

    $(document).ready(function () {

        // Toggle dropdown manually
        $('#dropdownMenuBtn').click(function (e) {
            e.stopPropagation();
            $('#dropdownMenu').toggleClass('show');
        });

        // Close dropdown when clicking outside
        $(document).click(function () {
            $('#dropdownMenu').removeClass('show');
        });

        // Open modal on click
        $('.open-modal').click(function (e) {
            e.preventDefault();

            let targetModal = $(this).data('target');

            // Close dropdown
            $('#dropdownMenu').removeClass('show');

            // Open modal
            $(targetModal).modal('show');
        });

    });
</script>
@endsection
