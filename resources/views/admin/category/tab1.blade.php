<div class="tab-pane active" id="documents" role="tabpanel">
    <div class="card mb-2">
        <div class="row">
            <div class="col">                      
                <h4 class="card-title">
                    Category 
                    <span class="badge rounded text-blue bg-blue-subtle ms-1">{{ $categories->total() }}</span>
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
                    
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createCategory">Create Category</button>                    
                </div>
            </div>
        </div>        
    </div>

    <div class="table-responsive browser_users">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th class="border-top-0" width="50">ID</th>
                    <th class="border-top-0">Category Name</th>
                    <th class="border-top-0" width="150">Show</th>
                    <th class="border-top-0" width="120">Menu Order</th>
                    <th class="border-top-0" width="80">Status</th>
                    <th class="border-top-0" width="120">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($categories->isNotEmpty())
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('products.edit', $category->id) }}">
                                        <img src="{{ asset('uploads/category/thumb/'.$category->image) }}" alt="" height="70" width="70" class="me-3 align-self-center rounded" />                                        
                                    </a>
                                    <div class="flex-grow-1 text-truncate">
                                        <h5 class="product-title">
                                            <a href="{{ route('products.edit', $category->id) }}">{{ Str::limit($category->category_name, 75, '...') }}</a>
                                        </h5>
                                    </div>
                                </div>
                            </td>  
                            <td>{{ $category->showHome }}</td>
                            <td>{{ $category->menu_order }}</td>
                            <td>
                                @if($category->status == 1)
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
                                <a href="{{ route('category.edit', $category->id ) }}">
                                    <i class="las la-pen text-secondary fs-18"></i>
                                </a>
                                <a href="#" onclick="deleteCategory({{ $category->id }})" class="text-danger w-4 h-4">
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