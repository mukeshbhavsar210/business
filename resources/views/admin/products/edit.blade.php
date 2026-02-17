@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->

    <section class="content">
        <form action="" method="post" name="productForm" id="productForm">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="title">Product Title</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $product->title }}">
                                            <p class="error"></p>
                                            <input type="hidden" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $product->slug }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote" >{{ $product->description }}</textarea>
                                            </div>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="short_description">Short Description</label>
                                            <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" >{{ $product->short_description }}</textarea>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="shipping_returns">Shipping & Returns</label>
                                            <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote"  >{{ $product->shipping_returns }}</textarea>
                                        </div>
                                    </div>                                
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">                                
                                    <h5 class="h5 mb-2">Product Photos</h5>
                                    <div id="image" class="dropzone dz-clickable mb-4">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>

                                    <div id="product-gallery">
                                        @if ($productImages->isNotEmpty())
                                        <h6>Uploaded images</h6>
                                        <div class="row">
                                            @foreach ( $productImages as $image)
                                                <div class="col-md-2" id="image-row-{{ $image->id }}">
                                                    <div class="card">
                                                        <input type="hidden" name="image_array[]" value="{{ $image->id }}" >
                                                        <img src="{{ asset('uploads/product/small/'.$image->image ) }}" class="rounded" />
                                                        <a href="javascript:void(0)" onclick="deleteImage({{ $image->id }})" class="deleteCardImg">X</a>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="h5 mb-1">Pricing</h5>
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ $product->price }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price" value="{{ $product->compare_price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label for="color">Color</label>
                                                <select name="color" id="color" class="form-control">
                                                    <option value="">Select</option>
                                                    @if ($colors->isNotEmpty())
                                                        @foreach ($colors as $value)
                                                            <option {{ ($product->color_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="form-group">
                                                <label for="size">Size</label>
                                                <select name="size" id="size" class="form-control">
                                                    <option value="">Size</option>
                                                    @if ($sizes->isNotEmpty())
                                                        @foreach ($sizes as $value)
                                                            <option {{ ($product->size_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-muted">To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.</p>
                                    <hr />

                                    <h5 class="h5 mb-2">Product category</h5>
                                    <div class="row">
                                        <div class="col-md-4 col-6">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="">Select a category</option>
                                                    @if ($categories->isNotEmpty())
                                                        @foreach ($categories as $value)
                                                            <option {{ ($product->category_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="error"></p>
                                            </div>
                                        </div>                                
                                        <div class="col-md-4 col-6">
                                            <div class="form-group">
                                                <label for="category">Sub Category</label>
                                                <select name="sub_category" id="sub_category" class="form-control">
                                                    <option value="">Sub category</option>
                                                    @if ($subCategories->isNotEmpty())
                                                        @foreach ($subCategories as $value)
                                                            <option {{ ($product->sub_category_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-6">
                                            <div class="form-group">
                                                <label for="category">Sub2 Category</label>
                                                <select name="sub_sub_category" id="sub_sub_category" class="form-control">
                                                    <option value="">Sub2 category</option>
                                                    @if ($sub2Categories->isNotEmpty())
                                                        @foreach ($sub2Categories as $value)
                                                            <option {{ ($product->sub_sub_category_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>    
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                      
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="h5 mb-1">Related products</h5>
                                <select multiple class="related-product " name="related_products[]" id="related_products">
                                    @if (!empty($relatedProducts))
                                        @foreach ($relatedProducts as $relProduct)
                                            <option selected value="{{ $relProduct->id }}">{{ $relProduct->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="h5 mb-2">Product brand</h5>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select a brand</option>
                                        @if ($brands->isNotEmpty())
                                            @foreach ($brands as $value)
                                                <option {{ ($product->brand_id == $value->id) ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="h5 mb-1">Inventory</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku" value="{{ $product->sku }}">
                                        <p class="error"></p>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode" value="{{ $product->barcode }}">
                                    </div>
                                    <div class="col-md-5">
                                        <div class="custom-control custom-checkbox">
                                            <input type="hidden" name="track_qty" value="No" >
                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" {{ ($product->track_qty == 'Yes') ? 'checked' : ' ' }}>
                                            <label for="track_qty" class="custom-control-label">Track Qty.</label>
                                        </div>
                                        <div>
                                            <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty" value="{{ $product->qty }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-6">
                                        <h5 class="h5 mb-1">Featured</h5>                                        
                                        <select name="is_featured" id="is_featured" class="form-control">
                                            <option {{ ($product->is_featured == 'No' ? 'selected' : '')}} value="No" >No</option>
                                            <option  {{ ($product->is_featured == 'Yes' ? 'selected' : '')}} value="Yes" >Yes</option>
                                        </select>
                                        <p class="error"></p>                                        
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <h5 class="h5 mb-1">Status</h5>                                        
                                        <select name="status" id="status" class="form-control">
                                            <option {{ ($product->status == 1 ? 'selected' : '' )}} value="1">Active</option>
                                            <option  {{ ($product->status == 0 ? 'selected' : '' )}} value="0">Block</option>
                                        </select>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
@endsection

@section('customJs')
<script>
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

    $('#title').change(function(){
        element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'get',
            data: {title: element.val()},
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if(response["status"] == true){
                    $("#slug").val(response["slug"]);
                }
            }
        });
    })



    //Product form add details in database
    $("#productForm").submit(function(event){
        event.preventDefault();

        var formArray = $(this).serializeArray();
        $("button[type='submit']").prop('disabled',true);

        $.ajax({
            url: '{{ route("products.update",$product->id) }}',
            type: 'put',
            data: formArray,
            dataType: 'json',
            success: function(response){

                $("button[type='submit']").prop('disabled',false);

                if (response['status'] == true) {

                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

                    window.location.href="{{ route('products.index') }}";

                } else {
                    var errors = response['errors'];

                    $(".error").removeClass('invalid-feedback').html('');
                    $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

                    $.each(errors, function(key,value){
                        $(`#${key}`).addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(value);
                    });
                }
            },

            error: function(){
                console.log("Something went wrong")
            }
        });
    });

    $("#category").change(function(){
        var category_id = $(this).val();
        $.ajax({
            url: '{{ route("product-subcategories.index") }}',
            type: 'get',
            data: {category_id:category_id},
            dataType: 'json',
            success: function(response) {
                $("#sub_category").find("option").not(":first").remove();
                $.each(response["subCategories"],function(key,item){
                    $("#sub_category").append(`<option value='${item.id}' >${item.name}</option>`)
                })
            },
            error: function(){
                console.log("Something went wrong")
            }
        });
    })

    //File image uplaod
    Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url:  "{{ route('product-images.update') }}",
            maxFiles: 10,
            paramName: 'image',
            params: {'product_id' : '{{ $product->id }}'},
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

</script>

@endsection