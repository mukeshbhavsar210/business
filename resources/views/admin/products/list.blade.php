@extends('admin.layouts.app')

@section('content')

@include('admin.message')
    <div class="card mb-0">
        <div class="card-body pb-0">
            <div class="row">
                <div class="row">
                    <div class="col-sm-8 col-12">
                        <div class="page-title">
                            <h4>Products</h4>
                            <span class="counts">{{ $products->total() }}</span>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12 float-end">
                        <div class="flexContainer">
                            <form action="" method="get" >
                                <div class="d-flex">
                                    <div class="card-title mr-3">
                                        <a href="javascript:0" onclick="window.location.href='{{ route('products.index') }}'" class="refresh-icon" >
                                            <span class="sprites"></span>                                            
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
                            <a href="{{ route('products.create') }}" class="btn btn-primary ">Create</a>
                        </div>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body pt-1">
            <div class="table-responsive">
                @php
                    use Illuminate\Support\Str;
                @endphp

                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-top-0">Product</th>
                            <th class="border-top-0" width="170">Variants</th>
                            <th class="border-top-0" width="130">Colors/Sizes</th>                            
                            <th class="border-top-0 text-end" width="80">Price</th>
                            <th class="border-top-0 text-end" width="70">COD</th>
                            <th class="border-top-0 text-end" width="90">Returnable</th>
                            <th class="border-top-0 text-end" width="90">Stock</th>                            
                            <th class="border-top-0 text-end" width="90">Action</th>
                        </tr>
                    </thead>                     
                    <tbody id="productAccordion">
                        @if ($products->isNotEmpty())
                            @foreach($products as $key => $product)
                                @php
                                    $productImage = $product->product_images->first();
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('products.edit', $product->id) }}">
                                                @if (!empty($productImage->image))
                                                    <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" height="90" class="me-3 align-self-center rounded" >
                                                @else
                                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" height="90" class="me-3 align-self-center rounded" />
                                                @endif
                                            </a>
                                            <div class="flex-grow-1 text-truncate">
                                                <h5 class="product-title">
                                                    <a href="{{ route('products.edit', $product->id) }}">{{ Str::limit($product->title, 70, '...') }}</a>
                                                </h5>
                                                <div class="small-fonts">                                                    
                                                    <p class="text-muted">{{ $product->category->category_name }} / {{ $product->subCategory->sub_category_name }} / {{ $product->subSubCategory->sub_sub_category_name }} / {{ $product->brand->name }}</p>
                                                    <p class="mb-0">
                                                        <span class="text-muted">{{ $product->id }} / </span>
                                                        @if($product->sku)
                                                            <span class="mb-0 text-muted">{{ $product->sku }}</span>
                                                        @endif          
                                                    </p>
                                                    {{-- @if($product->variants->count() > 0)                                                        
                                                        <b>Variants: {{ $product->variants->count() }}</b>
                                                    @endif                                                     --}}
                                                </div>
                                            </div>
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="align-self-center">
                                            <div class="img-group color_code">
                                                @if($product->variants->count())
                                                    @foreach($product->variants as $variant)                                        
                                                        <p class="user-avatar position-relative d-inline-block ms-n3">
                                                            <img src="{{ asset('uploads/product/small/'.$variant->image) }}" height="50" class="shadow-sm rounded-circle">                                                            
                                                        </p>                                                    
                                                    @endforeach
                                                @else
                                                    <div class="text-muted">No Variants</div>
                                                @endif
                                                </div>                                            
                                            </div>
                                        </td>
                                    <td>
                                        <div class="align-self-center">
                                            <div class="img-group color_code">
                                                @if($product->colors)
                                                        @foreach($product->colors as $color)                                                    
                                                        <p class="user-avatar position-relative d-inline-block ms-n1 show-tooltip" >                                                        
                                                            <span class="color" style="background-color: {{ $color->code }};">                                                            
                                                                <span class="tooltip">{{ $color->name }}</span>
                                                            </span>                                                        
                                                        </p>                                                    
                                                    @endforeach
                                                @else
                                                    No Colors
                                                @endif                                                
                                            </div>                                            
                                        </div>   
                                        <div class="align-self-center">
                                            <div class="img-group color_code">
                                                @foreach($product->sizes as $size)                                                    
                                                     <p class="user-avatar position-relative d-inline-block ms-n1 show-tooltip" >                                                        
                                                        <span class="size">{{ $size->code }}</span>
                                                        <span class="tooltip">{{ $size->name }}</span>
                                                    </p>                                                    
                                                @endforeach                                                                                           
                                            </div>                                            
                                        </div>                                                                         
                                    </td>                                    
                                    <td class="text-end"> 
                                        <div class="price">                                   
                                            @if($product->discount_percent > 0)
                                                <h5 class="mb-0">₹{{ round($product->discount_price) }}</h5>
                                                <p class="tiny-font text-muted"><del>₹{{ $product->price }}</del><br />
                                                    <span class="discount">{{ $product->discount_percent }}% OFF</span>
                                                </p>
                                            @else
                                                <h5 class="mb-0">₹{{ number_format($product->price, 2) }}</h5>
                                            @endif
                                        </div>
                                    </td>     
                                    <td class="text-end">
                                        <p>{{ $product->cod == 1 ? 'Yes' : 'No' }}</p>
                                    </td>   
                                    <td class="text-end">
                                        <p>{{ $product->is_returnable == 1 ? 'Yes' : 'No' }}</p>                                        
                                        @if($product->is_returnable == 1)
                                            <p class="text-muted tiny-font">{{ $product->return_days }}</p>
                                        @endif                                        
                                    </td>                                                                                                       
                                    <td class="text-end">                                        
                                        @if ($product->qty > 0)
                                            <span class="badge bg-primary-subtle text-primary px-2">{{ $product->qty }} Stock</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2">Out of Stock</span>
                                        @endif
                                    </td>                                   
                                    <td class="text-end">
                                        <div class="pull-right">
                                            <div class="flex">
                                                @if ($product->status == 1)  
                                                    <span class="sprites green-tick-icon"></span>
                                                @else
                                                    <span class="sprites red-tick-icon"></span>
                                                @endif
                                                
                                                <a href="{{ route('products.edit', $product->id ) }}" class="edit-icon">
                                                    <span class="sprites"></span>
                                                </a>
                                                <a href="#" onclick="deleteProduct( {{ $product->id }} )" class="delete-icon" >
                                                    <span class="sprites"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </td> 
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>Records not found</td>
                                </tr>
                            @endif
                    </tbody>
                </table>
            </div>
        </div>        
        <div class="card-body pb-0 clearfix">
            {{ $products->links() }}
        </div>          
    </div>    
@endsection

@section('customJs')
<script>
    function deleteProduct(id){
        var url = '{{ route("products.delete","ID") }}'
        var newUrl = url.replace("ID",id)

        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                success: function(response){
                    if(response["status"]){
                        window.location.href="{{ route('products.index') }}"
                    } else {
                        window.location.href="{{ route('products.index') }}"
                    }
                }
            });
        }
    }
</script>
@endsection