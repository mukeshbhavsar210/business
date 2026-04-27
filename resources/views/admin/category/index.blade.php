@extends('admin.layouts.app')

@section('content')

<div class="card mb-0">
    <div class="card-body pb-0">            
        <div class="row">                
            <div class="col-sm-3 col-12">
                <div class="page-title">
                    <h4>Category</h4>
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
    
        <div class="accordion mt-1" id="categoryAccordion">
            @foreach ($categories as $category)                                                     
                <div class="accordion-item">                                
                    <div class="accordion-header" id="cat{{ $category->id }}">
                        <div class="accordion-button collapsed p-2" data-bs-toggle="collapse" data-bs-target="#catCollapse{{ $category->id }}">
                            <div class="category-card">
                                <div>                                    
                                    <img src="{{ asset('uploads/category/'.$category->image) }}" alt="" height="75" width="75" class="me-2 align-self-center rounded" />
                                </div>
                                <div class="flex-grow-1">
                                    <h5>{{ $category->category_name }}</h5>
                                    <p class="mb-0 text-muted">Order: {{ $category->menu_order }}</p>                                    
                                </div>

                                @if ($category->status == 1)  
                                    <span class="sprites green-tick-icon"></span>
                                @else
                                    <span class="sprites red-tick-icon"></span>
                                @endif                                 
                                <div class="counts">{{ $category->sub_categories_count }}</div>
                            </div>
                        </div>
                    </div>

                    <div id="catCollapse{{ $category->id }}" class="accordion-collapse collapse" data-bs-parent="#categoryAccordion">
                        <div class="accordion-body">
                            <div class="flex">
                                <h5>Sub Category</h5>
                                <a href="javascript:0" class="edit-icon"
                                        data-id="{{ $category->id }}"
                                        data-category_name="{{ $category->category_name }}"
                                        data-status="{{ $category->status }}"
                                        data-showHome="{{ $category->showHome }}"
                                        data-menu_order="{{ $category->menu_order }}"
                                        onclick="editCategoryModal(this)"                                                
                                        data-bs-toggle="modal" 
                                        data-bs-target="#categoryModal"                                                
                                        >
                                        <span class="sprites"></span>
                                    </a>
                                    <a href="#" class="delete-icon" onclick="deleteCategory({{ $category->id }})" >
                                        <span class="sprites"></span>
                                    </a> 
                            </div>
                        
                            <div class="accordion" id="subAccordion{{ $category->id }}">
                                @foreach ($category->subCategories as $sub)
                                    <div class="accordion-item">                                                
                                        <div class="accordion-header" id="sub{{ $sub->id }}">                                                    
                                            <button class="accordion-button collapsed p-2" data-bs-toggle="collapse" data-bs-target="#subCollapse{{ $sub->id }}">
                                                <div class="category-card">
                                                    <div class="flex">
                                                        <p class="product-title">{{ $sub->sub_category_title }}</p>
                                                    </div>                                                                
                                                </div>                                                        
                                            </button>                                                    
                                        </div>

                                        <div id="subCollapse{{ $sub->id }}" class="accordion-collapse collapse" data-bs-parent="#subAccordion{{ $category->id }}">
                                            <div class="accordion-body">
                                                <div class="flex-justify">
                                                    <div class="flex">                                                                
                                                        @foreach ($sub->subSubCategories as $child)
                                                            <div class="chip">
                                                                <span>{{ $child->sub_sub_category_name }}</span>
                                                                <span>
                                                                    <a href="#" onclick="deleteSub2Category({{ $child->id }})" class="delete-icon">
                                                                        <span class="sprites"></span>
                                                                    </a>                                                                            
                                                                </span>
                                                            </div>
                                                        @endforeach   
                                                    </div>  
                                                    {{-- <h5>Sub Sub Category <span class="counts">{{ $sub->subSubCategories->count() }}</span></h5> --}}
                                                    <div class="flex">
                                                        <a class="edit-icon" href="javascript:0"
                                                            data-id="{{ $sub->id }}"
                                                            data-sub_category_name="{{ $sub->sub_category_name }}"
                                                            data-status="{{ $sub->status }}"
                                                            data-showHome="{{ $sub->showHome }}"
                                                            onclick="editSubCategoryModal(this)"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#subCategoryModal">
                                                            <span class="sprites"></span>
                                                        </a>
                                                            
                                                        <a href="#" class="delete-icon" onclick="deleteSubCategory({{ $sub->id }})" >
                                                            <span class="sprites"></span>
                                                        </a> 
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
            @endforeach                
        </div>
    </div>                                                                                           
                    
    {{ $categories->links() }}    
</div>   

@foreach($modals as $key => $modal)
    @include('admin.layouts.common', [
        'modal_id' => $modal['modal_id'],
        'form_id' => $modal['form_id'],
        'method_id' => $modal['method_id'],        
        'formConfig' => $modal['formConfig'],
        'title' => $modal['title'] ?? 'Modal'
    ])
@endforeach

@endsection

@section('customJs')
<script>    
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