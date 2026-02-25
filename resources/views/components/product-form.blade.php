<div class="card mb-1">
    <div class="card-body pb-1 pt-2">
        <div class="row">
            <div class="col-sm-6">
                <h3>{{ $title }}</h3>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('products.index') }}" class="btn btn-primary float-end">Back</a>
            </div>
        </div>
    </div>
</div> 

<div class="card p-0">
    <div class="card-body">
        <form action="{{ $route }}" method="POST" name="{{ $formname }}" id="{{ $formname }}" enctype="multipart/form-data" >
            @csrf

            @if($method !== 'POST')
                @method($method)
            @endif
            
            <div class="row">
                <div class="col-md-9 col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Product Title</label>
                                <input type="text" name="title" class="form-control slug-source" value="{{ old('title', $product->title ?? '') }}" data-target="#slug">
                                <input type="hidden" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ old('title', $product->slug ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control summernote" cols="30" rows="10" >                                
                                    {{ old('description', $product->description ?? '') }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">                            
                            <div class="form-group">
                                <label for="short_description">Short Description</label>
                                <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" >
                                    {{ old('short_description', $product->short_description ?? '') }}
                                </textarea>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="shipping_returns">Shipping & Returns</label>
                                <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote">
                                    {{ old('shipping_returns', $product->shipping_returns ?? '') }}                                
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-2">Product Photos</h4>
                    <div id="image" class="dropzone dz-clickable mb-2">
                        <div class="dz-message needsclick">
                            <br>Drop files here or click to upload.<br><br>
                        </div>
                    </div>   

                    <div class="row" id="product-gallery"></div>
                                    
                    @if(isset($product) && $product->images->isNotEmpty())
                        <div id="product-gallery">
                            <h5>Uploaded Images</h5>
                            <div class="row">
                                @foreach ($product->images as $image)
                                    <div class="col-md-2" id="image-row-{{ $image->id }}">
                                        <div class="uploaded-images">
                                            <input type="hidden" name="image_array[]" value="{{ $image->id }}">

                                            <img src="{{ asset('uploads/product/small/'.$image->image) }}" 
                                                class="rounded" />

                                            <a href="javascript:void(0)" 
                                            onclick="deleteImage({{ $image->id }})" 
                                            class="deleteCardImg">X</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif     
                    <hr />

                    <h4 class="mb-1">Pricing</h4>
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ old('price', $product->price ?? '') }}">
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="compare_price">Discount Price</label>
                                <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Discount Price" value="{{ old('compare_price', $product->compare_price ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <select name="color" id="color" class="form-select">
                                    <option value="">Select a Color</option>
                                @if ($colors->isNotEmpty())
                                        @foreach ($colors as $value)
                                            <option 
                                                value="{{ $value->id }}"
                                                {{ old('color_id', $product->color_id ?? '') == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="size">Size</label>
                                <select name="size" id="size" class="form-select">
                                    <option value="">Select a Size</option>
                                    @if ($sizes->isNotEmpty())
                                        @foreach ($sizes as $value)
                                            <option 
                                                value="{{ $value->id }}"
                                                {{ old('size_id', $product->size_id ?? '') == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted">To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.</p>
                    <hr />

                    <h4 class="mb-2">Related products</h4>
                    <select multiple class="related-product " name="related_products[]" id="related_products">
                        @if (!empty($relatedProducts))
                            @foreach ($relatedProducts as $relProduct)
                                <option selected value="{{ $relProduct->id }}">{{ $relProduct->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3 col-12">
                    <h4 class="mb-2">Product Category</h4>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" id="category" class="form-select">
                            <option value="">Select a category</option>
                            @if ($categories->isNotEmpty())
                                @foreach ($categories as $value)
                                    <option 
                                        value="{{ $value->id }}"
                                        {{ old('category_id', $product->category_id ?? '') == $value->id ? 'selected' : '' }}>
                                        {{ $value->category_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <p class="error"></p>
                    </div>
                
                    <div class="form-group">
                        <label for="category">Sub Category</label>
                        @php
                            $selectedSubCategory = old('sub_category_id', $product->sub_category_id ?? '');
                        @endphp

                        <select name="sub_category_id" id="sub_category" class="form-select">
                            <option value="">Select Subcategory</option>
                            @if ($subcategories->isNotEmpty())
                                @foreach ($subcategories as $value)
                                    <option 
                                        value="{{ $value->id }}"
                                        {{ $selectedSubCategory == $value->id ? 'selected' : '' }}>
                                        {{ $value->sub_category_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                
                    <div class="form-group">
                        <label for="category">Sub2 Category</label>
                        <select name="sub_sub_category" id="sub_sub_category" class="form-select">
                            <option value="">Sub2 category</option>
                            @if ($subsubcategories->isNotEmpty())
                                @foreach ($subsubcategories as $value)
                                    <option {{ ($product->sub_sub_category_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->sub2_category_name }}</option>
                                @endforeach
                            @endif
                        </select>    
                    </div>                           

                    <hr />
                    <h4 class="mb-2">Product Brand</h4>                        
                    <select name="brand" id="brand" class="form-select">
                        <option value="">Select a Brand</option>
                        @if ($brands->isNotEmpty())
                            @foreach ($brands as $value)
                                <option 
                                    value="{{ $value->id }}"
                                    {{ old('brand_id', $product->brand_id ?? '') == $value->id ? 'selected' : '' }}>
                                    {{ $value->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>                        
                    
                    <h4 class="mb-2 mt-3">Inventory</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                <input type="text" name="sku" id="sku" class="form-control" placeholder="sku" value="{{ old('sku', $product->sku ?? '') }}">
                                <p class="error"></p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="barcode">Barcode</label>
                                <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ old('barcode', $product->barcode ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="custom-control custom-checkbox">
                                <div class="form-group mb-0">
                                    <input type="hidden" name="track_qty" value="No" >
                                    <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes"
                                        {{ old('track_qty', $product->track_qty ?? '') == 'Yes' ? 'checked' : '' }} >
                                    <label for="track_qty" class="custom-control-label">Track Qty.</label>
                                </div>
                            </div>
                            <div>
                                <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ old('qty', $product->qty ?? '') }}">
                                <p class="error"></p>
                            </div>
                        </div>
                    </div>

                    <hr />
                    <h4 class="mb-2">Product Variants</h4>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#variantsModal">
                        Create Product Variants
                    </button>

                    <hr />
                    <h4 class="mb-2">Featured</h4>
                    <select name="is_featured" id="is_featured" class="form-select">
                        <option value="No" {{ old('is_featured', $product->is_featured ?? 'No') == 'No' ? 'selected' : '' }}>
                            No
                        </option>
                        <option value="Yes" {{ old('is_featured', $product->is_featured ?? '') == 'Yes' ? 'selected' : '' }}>
                            Yes
                        </option>
                    </select>
                    <p class="error"></p>
                    
                    <h4 class="mb-2">Status</h4>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ old('status', $product->status ?? 'No') == 1 ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ old('status', $product->status ?? '') == 0 ? 'selected' : '' }}>
                            Block
                        </option>
                    </select>                                                 
                </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary"> {{ $buttonText }}</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
                    
            <div class="modal fade" id="variantsModal" tabindex="-1" aria-labelledby="variantsModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="variantsModalLabel">Add Product Variant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="variants-wrapper" class="overflow-variant">
                                <div class="variant-item">                                                                          
                                    @php
                                        $variants = old('variants', isset($product) ? $product->variants->toArray() : [['price' => '']]);
                                    @endphp

                                    @foreach ($variants as $index => $variant)
                                        <div class="row">  
                                            <div class="col-md-6 col-6">
                                                <div class="form-group">
                                                    <label for="color">Photo</label>
                                                    <input type="file" name="variant_images[0]" class="form-control" value="{{ $variant['variant_images[0]'] ?? '' }}" >                                                    
                                                </div>
                                            </div>                                           
                                            <div class="col-md-6 col-6">
                                                <div class="form-group">
                                                    <label for="color">Color</label>
                                                    <select name="variants[0][color]" id="color_variants" class="form-select">
                                                        <option value="">Select a Color</option>
                                                        @if ($colors->isNotEmpty())
                                                            @foreach ($colors as $value)
                                                                <option 
                                                                    value="{{ $value->id }}"
                                                                    {{ old('color_id', $product->color_id ?? '') == $value->id ? 'selected' : '' }}>
                                                                    {{ $value->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach                                                                                                                                                      
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" onclick="addVariant()">Add Row</button>
                            <button type="button" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@section('customJs')
<script>
    $(document).ready(function () {

    if ($("#category").val()) {
        $("#category").trigger('change');
    }

    setTimeout(function () {
        if ($("#sub_category").val()) {
            $("#sub_category").trigger('change');
        }
    }, 500);

});

     $('.related-product').select2({
        ajax: {
            url: '{{ route('products.getProducts') }}',
            dataType: 'json',
            tags: true,
            multiple: true,
            minimumInputLength: 3,
            processResults: function (data) {
                return {
                    results: data.tags
                };
            }
        }
    });

    
    $(document).on('change', '#category', function () {
        var category_id = $(this).val();

        $.ajax({
            url: '{{ route("product-subcategories.index") }}',
            type: 'GET',
            data: { category_id: category_id },
            dataType: 'json',
            success: function(response) {
                $("#sub_category").find("option").not(":first").remove();

                $.each(response.subCategories, function(key, item) {
                    $("#sub_category").append(
                        `<option value='${item.id}'>${item.sub_category_name}</option>`
                    );
                });
            }
        });
    });

    $(document).on('change', '#sub_category', function () {
        var sub_category_id = $(this).val();
        $("#sub_sub_category").find("option").not(":first").remove();
        if (sub_category_id) {
            $.ajax({
                url: '{{ route("product-subcategories.extra") }}',
                type: 'GET',
                data: { sub_category_id: sub_category_id },
                dataType: 'json',
                success: function(response) {

                    $.each(response.subSubCategories, function(key, item){
                        $("#sub_sub_category").append(
                            `<option value="${item.id}">
                                ${item.sub2_category_name}
                            </option>`
                        )
                    });
                },
                error: function(){
                    console.log("Something went wrong");
                }
            });
        }
    });


    function deleteImage(id){
        $("#image-row-"+id).remove();
        if (confirm("Are you sure you want to delete image?")) {
            $.ajax({
                url: '{{ route("product-images.destroy") }}',
                type: 'delete',
                data: {id:id},
                    success: function(response) {
                        if(response.status == true){
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    }
            })
        }
    }    

    let index = 1;
    function addVariant() {
        let wrapper = document.getElementById('variants-wrapper');
        wrapper.insertAdjacentHTML('beforeend', `
            <div class="variant-item">
                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label for="color">Photo</label>
                            <input type="file" name="variant_images[${index}]" class="form-control">
                        </div>
                    </div> 
                    <div class="col-md-6 col-6">                    
                        <div class="form-group">
                            <label for="color">Color</label>
                            <select name="variants[${index}][color]" id="color_variants" class="form-select">
                                <option value="">Select a Color</option>
                                @if ($colors->isNotEmpty())
                                    @foreach ($colors as $value)
                                        <option 
                                            value="{{ $value->id }}"
                                            {{ old('color_id', $product->color_id ?? '') == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>                                                    
                        </div>                                           
                    </div>                                       
                </div>
            </div>
        `);
        index++;
    }


    //File image uplaod
    Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url:  "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                $("#image_id").val(response.image_id);
                console.log(response)

               var html = `<div class="col-md-2" id="image-row-${response.image_id}">
                    <div class="card">
                        <input type="hidden" name="image_array[]" value="${response.image_id}" >
                        <img src="${response.ImagePath}" />
                        <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="deleteCardImg">X</a>
                    </div>
                </div>`;

                $("#product-gallery").append(html);
            },
            complete: function(file){
                this.removeFile(file);
            }
        });

        function deleteImage(id){
            $("#image-row-"+id).remove();
        }
</script>
@endsection