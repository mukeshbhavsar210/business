
<div class="tab-pane" id="images" role="tabpanel">
    <div class="card mb-1">        
        <div class="row">
            <div class="col">                      
                <h4 class="card-title">
                    Sub Category
                    <span class="badge rounded text-blue bg-blue-subtle ms-1">{{ $subCategories->total() }}</span>                     
                </h4> 
            </div>
            <div class="col-auto"> 
                <div class="flexContainer">
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
                                    <input value="{{ Request::get('keyword2') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
        
                                    <div class="input-group-append">
                                        <button type="submit" class="btn">
                                            <i class="iconoir-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>                

                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createSubCategory">Create Sub Category</button>                    
                </div>              
            </div>            
        </div>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th width="60">ID</th>
                    <th>Sub Category Name</th>      
                    <th>Parent Category</th>      
                    <th width="100">Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>                
                    @foreach ($subCategories as $subCategory)
                        <tr>
                            <td>{{ $subCategory->id }}</td>
                            <td><h5 class="product-title">{{ $subCategory->sub_category_name }}</h5></td>
                            <td>
                                <div class="small-fonts">
                                    {{ $subCategory->categoryName }}
                                </div> 
                            </td>
                            <td>
                                @if($subCategory->status == 1)
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
                                <a href="{{ route('sub-categories.edit', $subCategory->id ) }}">
                                    <i class="las la-pen text-secondary fs-18"></i>
                                </a>
                                <a href="#" onclick="deleteSubCategory({{ $subCategory->id }})" class="text-danger w-4 h-4">
                                    <i class="las la-trash-alt text-secondary fs-18"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
            
            </tbody>
        </table>                                              
    </div>

    <div class="modal fade" id="createSubCategory" tabindex="-1" aria-labelledby="createSubCategoryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createSubCategoryLabel">Create Sub Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('categories.subCategory.store') }}" method="POST" id="createSubCategoryForm" name="createSubCategoryForm">
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

