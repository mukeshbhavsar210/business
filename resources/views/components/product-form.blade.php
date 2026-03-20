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

<form action="{{ $route }}" method="POST" name="{{ $formname }}" id="{{ $formname }}" enctype="multipart/form-data" >
    @csrf

    @if($method !== 'POST')
        @method($method)
    @endif
    
    <div class="row gx-1">
        <div class="col-md-9 col-12">
            <div class="card mb-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="title">Product Title</label>
                                <input type="text" name="title" class="form-control slug-source" value="{{ old('title', $product->title ?? '') }}" data-target="#slug">
                                <input type="hidden" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ old('title', $product->slug ?? '') }}">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="short_description">Short Description</label>
                                <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('title', $product->short_description ?? '') }}" >
                            </div>
                        </div>

                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control summernote" cols="30" rows="10" >                                
                                    {{ old('description', $product->description ?? '') }}
                                </textarea>
                            </div>
                        </div>

                        <div class="col-md-8 col-6">
                            <div class="form-group">
                                <label for="shipping_returns">Shipping & Returns</label>
                                <input type="text" name="shipping_returns" id="shipping_returns" class="form-control" value="{{ old('title', $product->shipping_returns ?? '') }}" >
                            </div>
                        </div>

                        <div class="col-md-4 col-6">
                            <div class="flex-2">
                                <div class="form-group">                                
                                    <label>Is Returnable</label><br />
                                    <div class="flex-2"> 
                                        <div class="mt-2">                                        
                                            <input type="hidden" name="is_returnable" value="0">
                                            <input class="form-check-input" type="checkbox" name="is_returnable" value="1"
                                            {{ old('is_returnable', $product->is_returnable ?? 0) == 1 ? 'checked' : '' }} >                                        
                                        </div>
                                        <div>
                                            <select name="return_days" id="return_days" class="form-select" style="width: 90px">
                                                <option value="7 days"
                                                    {{ old('return_days', $product->return_days ?? '7 days') == '7 days' ? 'selected' : '' }}>
                                                    7 days
                                                </option>

                                                <option value="14 days"
                                                    {{ old('return_days', $product->return_days ?? '') == '14 days' ? 'selected' : '' }}>
                                                    14 days
                                                </option>
                                            </select>
                                        </div>                                    
                                    </div>
                                </div>                    
                                <div>
                                    <label>Cash on delivery?</label><br />
                                    <div class="mt-2">                                
                                        <input type="hidden" name="cod" value="0">                                
                                        <input class="form-check-input" type="checkbox" name="cod" value="1"
                                            {{ old('cod', $product->cod ?? 0) == 1 ? 'checked' : '' }} >
                                    </div>
                                </div> 
                            </div> 
                        </div>                    
                    </div>
                </div>
            </div>

            <div class="card mb-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <h5 class="mb-2">Product Category</h5>
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select name="category_id" id="category_id" class="form-select">
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
                                </div>

                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label for="sub_category_id">Sub Category</label>
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
                                </div>

                                <div class="col-md-4 col-6">
                                    <div class="form-group">
                                        <label for="sub_sub_category_id">Sub Sub Category</label>
                                        <select name="sub_sub_category_id" id="sub_sub_category_id" class="form-select">
                                            <option value="">Sub Sub Category</option>
                                            @if ($subsubcategories->isNotEmpty())
                                                @foreach ($subsubcategories as $value)
                                                    <option {{ ($product->sub_sub_category_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->sub_sub_category_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">                            
                            <h5 class="mb-2">Product Brand</h5>
                            <div class="form-group">
                                <label>Brand</label>
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
                            </div>
                        </div>                        
                    </div>
                    <hr />

                    <h5 class="mb-1">Pricing</h5>
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
                                <label for="compare_price">Discount</label>
                                <select name="discount_percent" class="form-select">
                                    <option value="0" {{ ($brand->discount_percent_id ?? '') == 0 ? 'selected' : '' }}>No Discount</option>
                                    <option value="10" {{ ($brand->discount_percent_id ?? '') == 10 ? 'selected' : '' }}>10%</option>
                                    <option value="20" {{ ($brand->discount_percent_id ?? '') == 20 ? 'selected' : '' }}>20%</option>
                                    <option value="30" {{ ($brand->discount_percent_id ?? '') == 30 ? 'selected' : '' }}>30%</option>
                                    <option value="40" {{ ($brand->discount_percent_id ?? '') == 40 ? 'selected' : '' }}>40%</option>
                                    <option value="50" {{ ($brand->discount_percent_id ?? '') == 50 ? 'selected' : '' }}>50%</option>
                                    <option value="60" {{ ($brand->discount_percent_id ?? '') == 60 ? 'selected' : '' }}>60%</option>
                                    <option value="70" {{ ($brand->discount_percent_id ?? '') == 70 ? 'selected' : '' }}>70%</option>
                                    <option value="80" {{ ($brand->discount_percent_id ?? '') == 80 ? 'selected' : '' }}>80%</option>
                                    <option value="90" {{ ($brand->discount_percent_id ?? '') == 90 ? 'selected' : '' }}>90%</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <select name="color_id" id="color" class="form-select">
                                    <option value="">Select a Color</option>
                                    @foreach ($colors as $value)
                                        <option value="{{ $value->id }}" {{ old('color_id', $product->color_id ?? '') == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
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
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="mb-2">Product photos</h4>
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
                                            <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="rounded" />                                            
                                            <a href="javascript:void(0)" class="deleteCardImg" data-id="{{ $image->id }}">X</a>                                            
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif                         

                    <h5 class="mb-2">Related products</h5>
                    <select multiple class="related-product " name="related_products[]" id="related_products">
                        @if (!empty($relatedProducts))
                            @foreach ($relatedProducts as $relProduct)
                                <option selected value="{{ $relProduct->id }}">{{ $relProduct->title }}</option>
                            @endforeach
                        @endif
                    </select>

                    <div class="col-md-3 col-12 mt-3">
                        <button type="submit" class="btn btn-primary"> {{ $buttonText }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-12 pl-0">
            <div class="card mb-1 p-0">
                <div class="card-body">
                    <h4 class="mb-2">Inventory</h4>
                    <div class="form-group">
                        <label for="sku">SKU (Stock Keeping Unit)</label>
                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku" value="{{ old('sku', $product->sku ?? '') }}">
                        <p class="error"></p>
                    </div>

                    <div class="flex-2">
                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ old('barcode', $product->barcode ?? '') }}">
                        </div>                
                        <div class="custom-control custom-checkbox">
                            <div class="form-group mb-0">
                                <label for="track_qty" class="custom-control-label">Track Qty.</label>
                                <input type="hidden" name="track_qty" value="No" >
                                <input class="form-check-input" type="checkbox" id="track_qty" name="track_qty" value="Yes"
                                    {{ old('track_qty', $product->track_qty ?? '') == 'Yes' ? 'checked' : '' }} >                                
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ old('qty', $product->qty ?? '') }}">
                        <p class="error"></p>
                    </div>                                            
                </div>
            </div>

            <div class="card mb-1 p-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="mb-1">Featured</h6>
                            <input type="hidden" name="is_featured" value="No">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="Yes"
                                    {{ old('is_featured', $product->is_featured ?? 'No') == 'Yes' ? 'checked' : '' }} >                        
                            </div> 
                        </div>
                        <div class="col-6">
                            <h6 class="mb-1">Status</h6>
                            <input type="hidden" name="status" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" value="1"
                                    {{ old('status', $product->status ?? 0) == 1 ? 'checked' : '' }} >                        
                            </div>                                              
                        </div>
                    </div>
                    
                    <hr />
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#variantProductModal">Variant Product</button>
                    
                    <div class="modal fade" id="variantProductModal" tabindex="-1" aria-labelledby="variantProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Variant Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="variant_image" class="dropzone dz-clickable mb-2">
                                        <div class="dz-message needsclick">
                                            <br>Drop variant images here or click to upload.<br><br>
                                        </div>
                                    </div>

                                    <div class="row" id="variant-gallery"></div>
                                                    
                                    @if(isset($product) && $product->variants->isNotEmpty())
                                    <p>Uploaded Variant Images</p>
                                    <div class="row">
                                        @foreach ($product->variants as $variant)
                                            @if($variant->image)
                                                <div class="col-md-3" id="variant-image-row-{{ $variant->id }}">
                                                    <div class="uploaded-images">
                                                        <input type="hidden" name="existing_variant_images[]" value="{{ $variant->id }}">
                                                        <img src="{{ asset('uploads/product/small/'.$variant->image) }}" class="rounded" />
                                                        <a href="javascript:void(0)" onclick="deleteVariantImage({{ $variant->id }})" class="deleteCardImg">X</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif   
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</form>
   
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
                                ${item.sub_sub_category_name}
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


    $(document).on('click', '.deleteCardImg', function () {
        let id = $(this).data('id');

        if (!confirm("Are you sure you want to delete image?")) {
            return;
        }

        $.ajax({
            url: '{{ route("product-images.destroy") }}',
            type: 'DELETE',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status) {
                    $("#image-row-" + id).remove();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });    


    $(document).on('click', '.deleteCardImg2', function () {
        let id = $(this).data('id');

        if (!confirm("Are you sure you want to delete image?")) {
            return;
        }

        $.ajax({
            url: '{{ route("product-images.destroy") }}',
            type: 'DELETE',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status) {
                    $("#image-row2-" + id).remove();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });  
 

    let index = 1;
    function addVariant() {
        let wrapper = document.getElementById('variants-wrapper');
        wrapper.insertAdjacentHTML('beforeend', `
            <div class="variant-item">
                <div class="row">
                    <div class="col-md-12 col-6">
                        <div class="form-group">
                            <input type="file" name="variant_images[${index}]" class="form-control">
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

               var html = `<div class="col-md-3" id="image-row-${response.image_id}">
                    <div class="uploaded-images">
                        <input type="hidden" name="image_array[]" value="${response.image_id}" >
                        <img src="${response.ImagePath}" class="rounded" />
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


        //File image uplaod
        Dropzone.autoDiscover = false;

        const variantDropzone = $("#variant_image").dropzone({
            url: "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(file, response){

                var html = `
                <div class="col-md-3" id="variant-image-row-${response.image_id}">
                    <div class="uploaded-images">
                        <input type="hidden" name="variant_image_array[]" value="${response.image_id}">
                        <img src="${response.ImagePath}" class="rounded" />
                        <a href="javascript:void(0)" onclick="deleteVariantImage(${response.image_id})" class="deleteCardImg">X</a>
                    </div>
                </div>`;

                $("#variant-gallery").append(html);
            },

            complete: function(file){
                this.removeFile(file);
            }
        });

        function deleteVariantImage(id){
            $("#variant-image-row-"+id).remove();
        }
   
</script>
@endsection