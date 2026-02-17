@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" id="categoryForm" name="categoryForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-12">                            
                            <label for="name">Name</label>
                            <input type="text" value="{{ $category->name}}" name="name" id="name" class="form-control" placeholder="Name">
                            <input type="hidden" value="{{ $category->slug}}" readonly name="slug" id="slug" class="form-control" placeholder="">
                            <p></p>    
                            
                            <div class="row">
                                <div class="col-md-4 col-4">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ ($category->status == 1 ? 'selected' : '')}} value="1">Active</option>
                                        <option  {{ ($category->status == 0 ? 'selected' : '')}} value="0">Block</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-4">
                                    <label for="showHome">Show on Home</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option {{ ($category->showHome == 'Yes' ? 'selected' : '')}} value="Yes">Yes</option>
                                        <option  {{ ($category->showHome == 'No' ? 'selected' : '')}} value="No">No</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-4">
                                    <label for="menu_order">Order</label>
                                    <select name="menu_order" id="menu_order" class="form-control">
                                        <option {{ ($category->menu_order == '1' ? 'selected' : '')}} value="1">1</option>
                                        <option {{ ($category->menu_order == '2' ? 'selected' : '')}} value="2">2</option>
                                        <option {{ ($category->menu_order == '3' ? 'selected' : '')}} value="3">3</option>
                                        <option {{ ($category->menu_order == '4' ? 'selected' : '')}} value="4">4</option>
                                        <option {{ ($category->menu_order == '5' ? 'selected' : '')}} value="5">5</option>
                                        <option {{ ($category->menu_order == '6' ? 'selected' : '')}} value="6">6</option>
                                    </select>                                
                                </div>

                                <div class="col-md-6 col-6 mt-4">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-md-4 col-12">                            
                            <input type="hidden" id="image_id" name="image_id" value=" ">
                            <label for="image">Image</label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                </div>                            
                            </div>

                            @if(!empty($category->image))
                                <img style="border-radius: 7px; width:200px" src="{{ asset('uploads/category/thumb/'.$category->image) }}" alt="" />
                            @endif
                        </div>                        
                    </div>
                </div>
            </div>            
        </form>
    </div>
    <!-- /.card -->
</section>
@endsection

@section('customJs')
    <script>
        $("#categoryForm").submit(function(event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route("categories.update",$category->id) }}',
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);

                    if(response["status"] == true){

                        window.location.href="{{ route('categories.index') }}"

                        $('#name').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $('#slug').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                    } else {

                        if(response['notFound'] == true){
                            window.location.href="{{ route('categories.index') }}"
                        }

                        var errors = response['errors']
                        if(errors['name']){
                            $('#name').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                        }

                        if(errors['slug']){
                            $('#slug').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['slug']);
                        } else {
                            $('#slug').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                        }

                    }

                }, error: function(jqXHR, exception) {
                    console.log("Something event wrong");
                }
            })
        });

        $('#name').change(function(){
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

        Dropzone.autoDiscover = false;
            const dropzone = $("#image").dropzone({
                init: function() {
                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });
                },
                url:  "{{ route('temp-images.create') }}",
                maxFiles: 1,
                paramName: 'image',
                addRemoveLinks: true,
                acceptedFiles: "image/jpeg,image/png,image/gif",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, success: function(file, response){
                    $("#image_id").val(response.image_id);
                    //console.log(response)
                }
            });
    </script>
@endsection
