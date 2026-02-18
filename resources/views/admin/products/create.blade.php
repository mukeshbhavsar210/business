@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>    

    <section class="content mt-2">
        <form action="" method="post" name="productForm" id="productForm">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9 col-12">                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Product Name</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                    <input type="hidden" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                    <p class="error"></p>
                                </div>
                            
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote" ></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="shipping_returns">Shipping & Returns</label>
                                    <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote"  ></textarea>
                                </div>
                            </div>
                        </div>                                              

                        <h4 class="mb-2">Products Photo</h4>
                        <div id="image" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">
                                <br>Drop files here or click to upload.<br><br>
                            </div>
                        </div>

                        <div class="row" id="product-gallery"></div>

                        <h4 class="mb-2 mt-3">Pricing</h4>
                        <div class="row">
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                    <p class="error"></p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="compare_price">Compare at Price</label>
                                    <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <select name="color" id="color" class="form-select">
                                        <option value="">Select a Color</option>
                                        @if ($colors->isNotEmpty())
                                            @foreach ($colors as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-muted">To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.</p>
                        <hr />
                                                                         
                            <h4 class="mb-2">Related Products</h4>
                            <select multiple class="related-product" name="related_products[]" id="related_products">

                            </select>
                        </div>

                        <div class="col-md-3 col-12">
                            <h4 class="mb-2">Product Category</h4>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Select a category</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>
                            </div>
                            <div class="form-group">
                                <label for="category">Sub category</label>
                                <select name="sub_category" id="sub_category" class="form-select">
                                    <option value="">Sub category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sub_sub_category">Sub2 category</label>
                                <select name="sub_sub_category" id="sub_sub_category" class="form-select">
                                    <option value="">Sub2 category</option>
                                </select>
                            </div>
                            <hr />

                            <h4 class="mb-2">Product Brand</h4>                        
                            <select name="brand" id="brand" class="form-control">
                                <option value="">Select a brand</option>
                                @if ($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                                                
                            <h4 class="mb-2 mt-3">Inventory</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                        <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="barcode">Barcode</label>
                                        <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="custom-control custom-checkbox">
                                        <div class="form-group mb-0">
                                            <input type="hidden" name="track_qty" value="No" >
                                            <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" value="Yes" checked>                                        
                                            <label for="track_qty" class="custom-control-label">Track Qty.</label>
                                        </div>
                                    </div>

                                    <div>
                                        <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>                        
                            
                             <hr />
                            <h4 class="mb-2">Featured</h4>                                        
                            <select name="is_featured" id="is_featured" class="form-select">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            <p class="error"></p>
                        
                            <h4 class="mb-2">Status</h4>                                        
                            <select name="status" id="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                            </select>                                                                                                            
                        </div>
                    </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create Product</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
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
            url: '{{ route("products.store") }}',
            type: 'post',
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

    $("#sub_category").change(function(){
        var sub_category_id = $(this).val();
        $.ajax({
            url: '{{ route("product-subcategories.extra") }}',
            type: 'get',
            data: { sub_category_id: sub_category_id },
            dataType: 'json',
            success: function(response) {
                $("#sub_sub_category").find("option").not(":first").remove();
                $.each(response["subSubCategories"], function(key, item){
                    $("#sub_sub_category").append(
                        `<option value='${item.id}'>${item.name}</option>`
                    )
                });

            },
            error: function(){
                console.log("Something went wrong");
            }
        });
    });


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
