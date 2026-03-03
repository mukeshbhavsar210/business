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
                                    <div class="card-title">
                                        <button type="button" onclick="window.location.href='{{ route('products.index') }}'" class="btn btn-default btn-sm">
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
                            <th class="border-top-0" width="100">Color/Size</th>                            
                            <th class="border-top-0" width="100">Price</th>
                            <th class="border-top-0" width="90">Stock</th>
                            <th class="border-top-0" width="50">Status</th>
                            <th class="border-top-0" width="70">Action</th>
                        </tr>
                    </thead>                     
                    <tbody id="productAccordion">
                        @if ($products->isNotEmpty())
                            @foreach($products as $key => $product)
                                @php
                                    $productImage = $product->product_images->first();
                                @endphp

                                <tr data-bs-toggle="collapse" data-bs-target="#variantRow{{ $product->id }}" class="cursor-pointer">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('products.edit', $product->id) }}">
                                                @if (!empty($productImage->image))
                                                    <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" height="80" class="me-3 align-self-center rounded" >
                                                    @else
                                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="" height="80" class="me-3 align-self-center rounded" />
                                                @endif
                                            </a>
                                            <div class="flex-grow-1 text-truncate">
                                                <h5 class="product-title">
                                                    <a href="{{ route('products.edit', $product->id) }}">{{ Str::limit($product->title, 70, '...') }}</a>
                                                </h5>
                                                <div class="small-fonts">
                                                    {{-- <span class="color-small" style="background:{{ $product->color->code }}; height:20px; width:20px; border-radius:100px;"></span> --}}
                                                    <p class="mb-0">
                                                        <span class="text-muted">{{ $product->id }}</span> | 
                                                        @if($product->sku)
                                                            <span class="mb-0 text-muted">SKU: {{ $product->sku }}</span>
                                                        @endif          
                                                    </p>

                                                    @if($product->variants->count() > 0)
                                                        <a href="javascript:0" data-bs-toggle="modal" data-bs-target="#variantRow{{ $product->id }}">
                                                            <b>Variants: {{ $product->variants->count() }}</b>
                                                        </a>
                                                    @endif                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td> 
                                    <td>
                                        <p>{{ $product->color->name ?? '' }}</p>
                                        <span class="text-muted">Size:</span> {{ $product->size->code ?? '' }}                                        
                                    </td>    
                                    <td>
                                        <p><b>₹{{ number_format($product->price,2) }}</b></p>
                                        <p class="text-muted fs-10">
                                            @if($product->compare_price)
                                                Discount: ₹{{ number_format($product->compare_price,2) }}
                                            @else
                                                <span>No Discount</span>
                                            @endif
                                        </p>   
                                    </td>                                                                                                             
                                    <td>                                        
                                        @if ($product->qty > 0)
                                            <span class="badge bg-primary-subtle text-primary px-2">{{ $product->qty }} Stock</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2">Out of Stock</span>
                                        @endif                                    
                                    </td>                                   
                                    <td>
                                        @if ($product->status == 1)                                        
                                            <svg class="text-success-500 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif    
                                    </td>
                                    <td>    
                                        <a href="{{ route('products.edit', $product->id ) }}">
                                            <i class="las la-pen text-secondary fs-18"></i>
                                        </a>
                                        <a href="#" onclick="deleteProduct( {{ $product->id }} )" class="text-danger w-4 h-4">
                                            <i class="las la-trash-alt text-secondary fs-18"></i>
                                        </a>
                                    </td> 
                                    
                                    <div class="modal fade" id="variantRow{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Variants</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($product->variants->count())
                                                        @foreach($product->variants as $variant)
                                                            @php
                                                                $variantImage = $product->variant_images->first();
                                                            @endphp
                                                            
                                                            @if(!empty($variantImage->image))
                                                                <img src="{{ asset('uploads/product/small/'.$variantImage->image) }}" height="70" class="me-3 rounded">
                                                            @else
                                                                <img src="{{ asset('admin-assets/img/default-150x150.png') }}" height="70" class="me-3 rounded">
                                                            @endif                                                                                                            
                                                        @endforeach
                                                    @else
                                                        <div class="text-muted">No Variants Available</div>
                                                    @endif
                                                </div>                                        
                                            </div>
                                        </div>
                                    </div>
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
