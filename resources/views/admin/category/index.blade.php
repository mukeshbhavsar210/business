@extends('admin.layouts.app')

@section('content')

<div class="card mb-0">
    <div class="card-body pb-0">            
        <div class="row">                
            <div class="col-sm-3 col-12">
                <div class="page-title">
                    <h4>{{ $title }}</h4>
                    <span class="counts">{{ $total  }}</span>
                </div>
            </div>
            <div class="col-sm-9 col-12 float-end">
                <div class="flexContainer">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuBtn">
                            + ADD
                        </button>

                        <ul class="dropdown-menu" id="dropdownMenu">
                            <li><a class="dropdown-item open-modal" href="#" onclick="createCategoryModal()" data-bs-toggle="modal" data-bs-target="#categoryModal" >Create Category</a></li>
                            <li><a class="dropdown-item open-modal" href="#" onclick="createSubCategoryModal()" data-bs-toggle="modal" data-bs-target="#subCategoryModal">Create Sub Category</a></li>
                            <li><a class="dropdown-item open-modal" href="#" onclick="createSubSubCategoryModal()" data-bs-toggle="modal" data-bs-target="#subSubCategoryModal">Create Sub Sub Category</a></li>                            
                        </ul>
                    </div>                     

                    <form action="" method="get" >
                        <div class="d-flex">
                            <div class="card-title">
                                <button type="button" onclick="window.location.href='{{ $refresh }}'" class="btn btn-default btn-sm">
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
    <div class="card">
        <div class="card-body">                                    
            <div class="accordion" id="categoryAccordion">
                <div class="row">
                    @foreach ($categories as $category)                             
                        <div class="col-6 mb-2">
                            <div class="accordion-item">                                
                                <div class="accordion-header" id="cat{{ $category->id }}">
                                    <div class="accordion-button collapsed p-2" data-bs-toggle="collapse" data-bs-target="#catCollapse{{ $category->id }}">
                                        <div class="category-card">
                                            <div>
                                                <a href="{{ route('category.edit', $category->id) }}">
                                                    <img src="{{ asset('uploads/category/'.$category->image) }}" alt="" height="85" width="85" class="me-2 align-self-center rounded" />
                                                </a> 
                                            </div>                                       
                                            <div class="flex-grow-1">
                                                <h5>{{ $category->category_name }} </h5>
                                                <p class="mb-0 text-muted">Show: {{ $category->showHome }}</p>
                                                <p class="mb-0 text-muted">Menu Order: {{ $category->menu_order }}</p>
                                            </div>
                                            <div class="counts">{{ $category->sub_categories_count }}</div>

                                            <a class="float-end" href="javascript:0"
                                                data-id="{{ $category->id }}"
                                                data-category_name="{{ $category->category_name }}"
                                                data-status="{{ $category->status }}"
                                                data-showHome="{{ $category->showHome }}"
                                                data-menu_order="{{ $category->menu_order }}"
                                                onclick="editCategoryModal(this)"                                                
                                                data-bs-toggle="modal" 
                                                data-bs-target="#categoryModal"                                                
                                                >
                                                <i class="las la-pen text-secondary fs-18"></i>
                                            </a>
                                        </div>                                        
                                    </div>
                                </div>

                                <div id="catCollapse{{ $category->id }}" class="accordion-collapse collapse" data-bs-parent="#categoryAccordion">
                                    <div class="accordion-body">
                                        <div class="accordion" id="subAccordion{{ $category->id }}">
                                        @foreach ($category->subCategories as $sub)
                                            <div class="accordion-item">                                                
                                                <div class="accordion-header" id="sub{{ $sub->id }}">                                                    
                                                    <button class="accordion-button collapsed p-2" data-bs-toggle="collapse" data-bs-target="#subCollapse{{ $sub->id }}">
                                                        <div class="category-card">
                                                            <div class="flex">
                                                                <p class="product-title">{{ $sub->sub_category_name }}</p>
                                                                <span>- {{ $sub->sub_sub_categories_count }}</span>
                                                            </div>
                                                            <div class="flex">                                                                
                                                                <a class="float-end" href="javascript:0"
                                                                    data-id="{{ $sub->id }}"
                                                                    data-sub_category_name="{{ $sub->sub_category_name }}"
                                                                    data-status="{{ $sub->status }}"
                                                                    data-showHome="{{ $sub->showHome }}"
                                                                    onclick="editSubCategoryModal(this)"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#subCategoryModal">
                                                                    <i class="las la-pen text-secondary fs-18"></i>
                                                                </a>

                                                                <a href="{{ route('sub_category.edit', $sub->id ) }}">
                                                                    <i class="las la-pen text-secondary fs-18"></i>
                                                                </a>
                                                                <a href="#" onclick="deleteSubCategory({{ $sub->id }})" class="text-danger w-4 h-4">
                                                                    <i class="las la-trash-alt text-secondary fs-18"></i>
                                                                </a>                                                                
                                                            </div>
                                                        </div>                                                        
                                                    </button>                                                    
                                                </div>

                                                <div id="subCollapse{{ $sub->id }}" class="accordion-collapse collapse" data-bs-parent="#subAccordion{{ $category->id }}">
                                                    <div class="accordion-body flex">
                                                        {{-- {{ $sub->subSubCategories->count() }} --}}                                                        
                                                        @foreach ($sub->subSubCategories as $child)
                                                            <div class="chip">
                                                                <span>{{ $child->sub_sub_category_name }}</span>
                                                                <span>
                                                                    {{-- <a href="{{ route('sub_sub_category.edit', $child->id ) }}">
                                                                        <i class="las la-pen text-secondary fs-18"></i>
                                                                    </a> --}}
                                                                    <a href="#" onclick="deleteSub2Category({{ $child->id }})">
                                                                        <i class="las la-trash-alt text-secondary fs-18"></i>
                                                                    </a>                                                                            
                                                                </span>
                                                            </div>
                                                        @endforeach                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                             
                    @endforeach
                </div>
            </div>
        </div>                                                                                       
    </div>
                    
    {{ $categories->links() }}    
</div>   

@foreach($modals as $key => $modal)
    @include('admin.layouts.common', [
        'modal_id' => $modal['modal_id'],
        'form_id' => $modal['form_id'],
        'formConfig' => $modal['formConfig']
    ])
@endforeach

@endsection

@section('customJs')
<script>    
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
        var url = '{{ route("sub_sub_category.delete","ID") }}'
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

    
</script>
@endsection