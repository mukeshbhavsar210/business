 <div class="tab-pane" id="audio" role="tabpanel">    
    <div class="card mb-1">        
        <div class="row">
            <div class="col">                      
                <h4 class="card-title">Sub2 Category
                    <span class="badge rounded text-blue bg-blue-subtle ms-1">{{ $sub2Categories->total() }}</span>                     
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
                                    <input value="{{ Request::get('keyword3') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
        
                                    <div class="input-group-append">
                                        <button type="submit" class="btn">
                                            <i class="iconoir-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>                

                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createSub2Category">Create Sub2 Category</button>                    
                </div>           
            </div>            
        </div>
    </div>

    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th width="60">ID</th>
                    <th>Sub2 Category</th>
                    <th>Parent Sub Category</th>
                    <th>Parent Category</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>                
                @foreach ($sub2Categories as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td><h5 class="product-title">{{ $value->sub2_category_name }}</h5></td>
                        <td>{{ $value->subCategoryName }}</td>
                        <td>{{ $value->categoryName }}</td>                       
                        <td>
                            <a href="{{ route('sub2_category.edit', $value->id ) }}">
                                <i class="las la-pen text-secondary fs-18"></i>
                            </a>
                            <a href="#" onclick="deleteSub2Category({{ $value->id }})" class="text-danger w-4 h-4">
                                <i class="las la-trash-alt text-secondary fs-18"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach              
            </tbody>
        </table>                                   
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