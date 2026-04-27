@props([
    'product' => null,
    'categories' => null,
    'subcategories' => null,
    'subsubcategories' => null,
    'selectedsubcategory' => null,
    'selectedsubsubcategory' => null,
    'brands' => null,
    'colors' => null,
    'sizes' => null,
    'discountpercentages' => null,
    'selecteddiscount' => null,
    'route' => null,
    'formname' => null,
    'title' => '',
    'buttonText' => '',        
    'method' => 'POST'
])

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
     
        <form action="{{ $route }}" method="POST" name="{{ $formname }}" id="{{ $formname }}" enctype="multipart/form-data" >
            @csrf

            @if($method !== 'POST')
                @method($method)
            @endif
            
            <div class="row mt-2">
                <div class="col-md-9 col-12">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label for="title" class="form-label">Product Title</label>
                                <input type="text" name="title" class="form-control slug-source" value="{{ old('title', $product->title ?? '') }}" data-target="#slug">
                                <input type="hidden" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ old('title', $product->slug ?? '') }}">
                            </div>
                        
                            <div class="form-group">
                                <label for="short_description" class="form-label">Short Description</label>
                                <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('title', $product->short_description ?? '') }}" >
                            </div>
                        
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control summernote" cols="30" rows="10" >                                
                                    {{ old('description', $product->description ?? '') }}
                                </textarea>
                            </div>
                        </div>
                    </div>
                                     
                    <div class="row">
                        <div class="col-md-10 col-12">
                            <div class="form-group">
                                <label for="shipping_returns" class="form-label">Shipping & Returns</label>
                                <input type="text" name="shipping_returns" id="shipping_returns" class="form-control" value="{{ old('title', $product->shipping_returns ?? '') }}" >
                            </div>
                        </div>

                        <div class="col-md-2 col-6">
                            <div class="flex-2">
                                <div class="form-group">                                
                                    <label class="form-label">Is Returnable?</label><br />
                                    <div class="flex"> 
                                        <div class="mt-2">                                        
                                            <input type="hidden" name="is_returnable" value="0">
                                            <input class="form-check-input" type="checkbox" name="is_returnable" value="1"
                                            {{ old('is_returnable', $product->is_returnable ?? 0) == 1 ? 'checked' : '' }} >                                        
                                        </div>
                                        <div>
                                            <select name="return_days" id="return_days" class="form-select d-none" style="width: 90px;">
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
                            </div> 
                        </div>                                                                                                                        
                    </div>

                    <hr />

                    <h5 class="mb-3 ">Product Category</h5>
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                    <select name="category" id="category" class="form-select">
                                    <option value="">Select</option>
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

                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="sub_category" class="form-label">Sub Category</label>   
                                <select name="sub_category" id="sub_category" class="form-select">                                            
                                    @if ($subcategories->isNotEmpty())
                                        @foreach ($subcategories as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $selectedsubcategory == $value->id ? 'selected' : '' }} >
                                                {{ $value->sub_category_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="sub_sub_category" class="form-label">Sub Sub Category</label>
                                <select name="sub_sub_category" id="sub_sub_category" class="form-select">                                            
                                    @if ($subsubcategories->isNotEmpty())
                                        @foreach ($subsubcategories as $value)
                                            <option {{ ($selectedsubsubcategory == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->sub_sub_category_name }}</option>
                                        @endforeach
                                    @endif
                                </select>    
                            </div>
                        </div>

                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label class="form-label">Brand</label>
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
                            
                    <div class="row mt-1">
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="price">Rs</span>                                
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ old('price', $product->price ?? '') }}">
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="form-group">
                                <label for="compare_price" class="form-label">Discount</label>
                                <select name="discount_percent" class="form-select">
                                    <option value="">Select Discount</option>
                                    @foreach($discountpercentages as $discount)
                                        <option value="{{ $discount->id }}"
                                            {{ $selecteddiscount == $discount->id ? 'selected' : '' }}>
                                            {{ $discount->percentage }}%
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="form-group">
                                <label class="form-label">Colors</label>
                                <div class="dropdown customDropdown">
                                    <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Select Colors <i class="las la-angle-down ms-1"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        @foreach ($colors as $value)
                                            <li>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" class="form-check-input" name="colors[]" value="{{ $value->id }}"
                                                        {{ isset($product) && $product->colors->contains($value->id) ? 'checked' : '' }}>
                                                        {{ $value->name }}
                                                </label>
                                            </li>
                                        @endforeach                                                                                                          
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="form-group">
                                <label class="form-label">Sizes</label>
                                <div class="dropdown customDropdown">
                                    <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Select Size <i class="las la-angle-down ms-1"></i>
                                    </button>

                                    <ul class="dropdown-menu">
                                        @foreach ($sizes as $value)
                                            <li>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" name="sizes[]" class="form-check-input" value="{{ $value->id }}" 
                                                    {{ isset($product) && $product->sizes->contains($value->id) ? 'checked' : '' }}>                                                
                                                    {{ $value->name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">                                                        
                            <label class="form-label mt-4">
                                <input type="hidden" name="cod" value="0">                                
                                <input class="form-check-input" type="checkbox" name="cod" value="1"
                                    {{ old('cod', $product->cod ?? 0) == 1 ? 'checked' : '' }} >
                                    Cash on delivery?
                            </label>                            
                        </div>
                    </div>
                    <p class="text-muted">To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.</p>

                    <hr />
                        
                    <div class="row">
                        <div class="col-md-9 col-8">
                            <h5 class="mt-2">Product Photos</h5>
                        </div>
                        <div class="col-md-3 col-4">                                                    
                            <select name="color_id" class="form-select">
                                <option value="">Select Color</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}"
                                        @if(isset($product) && $product->images->isNotEmpty())
                                            {{ $product->images->first()?->color_id == $color->id ? 'selected' : '' }}
                                        @endif
                                        >
                                        {{ $color->name }}
                                    </option>
                                @endforeach
                            </select>                                                                                   
                        </div>
                    </div>
                        
                    <div id="image" class="dropzone dz-clickable mt-3 mb-2">
                        <div class="dz-message needsclick">Drop Product Image</div>
                    </div> 

                    <div class="row">
                        @if(isset($product) && $product->images->isNotEmpty())                        
                            <div id="product-gallery" class="row">                                    
                                @foreach ($product->images as $index => $image)
                                    <div class="col-2 uploaded-images" id="image-row-{{ $image->id }}">                                        
                                        <input type="hidden" name="image_array[{{ $index }}][image_id]" value="{{ $image->id }}">
                                        <img src="{{ asset('uploads/product/small/'.$image->image) }}" class="rounded" />

                                        <a href="javascript:void(0)" class="deleteProductImg delete-icon-edit" data-id="{{ $image->id }}">
                                            <span class="sprites"></span>
                                        </a>
                                    </div>
                                @endforeach                                                            
                            </div>                               
                        @endif
                                                
                        <div class="row" id="product-gallery"></div>         
                    </div>                     
                    
                    <h5 class="mb-2 mt-2">Uploaded Variant</h5> 
                    <div id="variant_image" class="dropzone dz-clickable">
                        <div class="dz-message needsclick">Drop Variant images</div>
                    </div> 

                    <hr />
                    
                    <div class="row mt-2">
                        @if(isset($product) && $product->variants->isNotEmpty())                                                        
                            @foreach ($product->variants as $index => $variant)
                                @if($variant->image)
                                    <div class="col-2 uploaded-images" id="variant-image-row-{{ $variant->id }}">

                                        {{-- Store variant id --}}
                                        <input type="hidden" name="existing_variant_images[{{ $index }}][id]" value="{{ $variant->id }}">

                                        <img src="{{ asset('uploads/product/small/'.$variant->image) }}" class="rounded" />

                                        <a href="javascript:void(0)" 
                                        data-id="{{ $variant->id }}" 
                                        onclick="deleteVariantImage(this)" 
                                        class="deleteVariantImg delete-icon-edit">
                                            <span class="sprites"></span>
                                        </a>     

                                        {{-- Color Dropdown --}}
                                        <select name="existing_variant_images[{{ $index }}][color_id]" class="form-select mt-1">
                                            <option value="">Select Color</option>
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}" 
                                                    {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                                    {{ $color->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach                                
                        @endif   
                        
                    <div class="row" id="variant-gallery"></div>
                </div>
                                            
                <h5 class="mb-2">Related products</h5>
                <select multiple class="related-product " name="related_products[]" id="related_products">
                    @if (!empty($relatedProducts))
                        @foreach ($relatedProducts as $relProduct)
                            <option selected value="{{ $relProduct->id }}">{{ $relProduct->title }}</option>
                        @endforeach
                    @endif
                </select>

                    <div class="mt-3 mb-3">
                        <button type="submit" class="btn btn-primary"> {{ $buttonText }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>                   
                </div>

                <div class="col-md-3 col-12 pl-0">                    
                    <h4 class="mb-2">Inventory</h4>
                    <div class="form-group">
                        <label for="sku" class="form-label">SKU (Stock Keeping Unit)</label>
                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku" value="{{ old('sku', $product->sku ?? '') }}">
                        <p class="error"></p>
                    </div>    

                    <div class="form-group">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ old('barcode', $product->barcode ?? '') }}">
                    </div>                                        
                    
                    <div class="custom-control custom-checkbox">
                        <div class="form-group mb-0">
                            <label for="track_qty" class="custom-control-label">Track Qty.</label>
                            <input type="hidden" name="track_qty" value="No" >
                            <div class="flex-2">
                                <input class="form-check-input mt-2" type="checkbox" id="track_qty" name="track_qty" value="Yes"
                                {{ old('track_qty', $product->track_qty ?? '') == 'Yes' ? 'checked' : '' }} >                                
                                <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ old('qty', $product->qty ?? '') }}">
                                <p class="error"></p>
                            </div>
                        </div>                    
                    </div>                                      
                        
                    <div class="row mt-3">
                        <div class="col-6">
                            <h6 class="mb-1">Featured</h6>
                            <input type="hidden" name="is_featured" value="Yes">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="Yes"
                                    {{ old('is_featured', $product->is_featured ?? 'Yes') == 'Yes' ? 'checked' : '' }} >                        
                            </div> 
                        </div>
                        <div class="col-6">
                            <h6 class="mb-1">Status</h6>
                            <input type="hidden" name="status" value="1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" value="1"
                                    {{ old('status', $product->status ?? 1) == 1 ? 'checked' : '' }} >                        
                            </div>                                              
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


    $(document).on('click', '.deleteProductImg', function () {
        let id = $(this).data('id');

        if (!confirm("Are you sure you want to delete Product image?")) {
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


    $(document).on('click', '.deleteVariantImg', function () {
        let id = $(this).data('id');

        if (!confirm("Are you sure you want to delete Variant image?")) {
            return;
        }

        $.ajax({
            url: '{{ route("variant-images.destroy") }}',
            type: 'DELETE',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status) {
                    $("#variant-image-row-" + id).remove();
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
        maxFiles: 5,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.image_id);
            console.log(response)

            var html = `<div class="col-2 uploaded-images" id="image-row-${response.image_id}">                            
                            <input type="hidden" name="image_array[]" value="${response.image_id}" >
                            <img src="${response.ImagePath}" class="rounded" />
                            <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="deleteCardImg delete-icon-edit">
                                <span class="sprites"></span>
                            </a>
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
    let variantIndex = 0;
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

            var html = `<div class="col-2 uploaded-images" id="variant-image-row-${response.image_id}">                            

                {{-- ✅ SAME ARRAY --}}
                <input type="hidden" name="variants[${variantIndex}][image_id]" value="${response.image_id}">

                <img src="${response.ImagePath}" class="rounded" />

                <a href="javascript:void(0)" onclick="deleteVariantImage(${response.image_id})" class="deleteCardImg2 delete-icon-edit">
                    <span class="sprites"></span>
                </a>    

                <select name="variants[${variantIndex}][color_id]" class="form-select mt-1">
                    <option value="">Select Color</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>`;

            $("#variant-gallery").append(html);

            variantIndex++;
        },

        complete: function(file){
            this.removeFile(file);
        }
    });

        function deleteVariantImage(id){
            $("#variant-image-row-"+id).remove();
        }

        $(document).on('input', '.slug-source', function () {
            let element = $(this);
            let form = element.closest('form');
            let target = element.data('target');
            let submitBtn = form.find("button[type=submit]");

            submitBtn.prop('disabled', true);

            $.ajax({
                url: '{{ route("getSlug") }}',
                type: 'GET',
                data: { title: element.val() },
                dataType: 'json',
                success: function (response) {

                    submitBtn.prop('disabled', false);

                    if (response.status) {
                        form.find(target).val(response.slug);
                    }
                }
            });
        });

        $(document).ready(function () {
            function toggleReturnDays() {
                if ($('input[name="is_returnable"]').is(':checked')) {
                    $('#return_days').removeClass('d-none');
                } else {                    
                    $('#return_days').addClass('d-none');
                }
            }

            // Run on page load
            toggleReturnDays();

            // Run on checkbox change
            $(document).on('change', 'input[name="is_returnable"]', function () {
                toggleReturnDays();
            });
        });
</script>
@endsection