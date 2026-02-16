@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Edit Sub2 Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('sub2-categories.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" name="sub2CategoryForm" id="sub2CategoryForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Category</label>
                            <select name="category_id" id="category" class="form-control">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $sub2Category->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Sub Category</label>
                            <select name="sub_category_id" id="sub_category" class="form-control">
                                <option value="">Select Sub Category</option>

                                @foreach ($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}"
                                        {{ $sub2Category->sub_category_id == $subCategory->id ? 'selected' : '' }}>
                                        {{ $subCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>                       
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $sub2Category->name }}">
                                <p></p>
                            </div>
                        </div>
                        <input type="hidden" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $sub2Category->slug }}">
                        <p></p>

                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($sub2Category->status == 1) ? 'selected' : ' ' }} value="1">Active</option>
                                    <option {{ ($sub2Category->status == 0) ? 'selected' : ' ' }} value="0">Block</option>
                                </select>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('sub2-categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customJs')
<script>
    $("#sub2CategoryForm").submit(function(event){
        event.preventDefault();

        var element = $('#sub2CategoryForm');
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("sub2-categories.update", $sub2Category->id) }}',
            type: 'put',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){

                    window.location.href="{{ route('sub-categories.index') }}"

                    $('#name').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $('#slug').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $('#category').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                } else {

                    if(response['notFound'] == true){
                        window.location.href="{{ route('sub-categories.index') }}"
                        return false;
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

                    if(errors['category']){
                        $('#category').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['category']);
                    } else {
                        $('#category').removeClass('is-invalid')
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

     $('#category').on('change', function () {
        var categoryID = $(this).val();

        if (categoryID) {
            $('#sub_category').html('<option>Loading...</option>');

            $.ajax({
                url: "{{ route('get.subcategories', '') }}/" + categoryID,
                type: 'GET',
                success: function (data) {                 
                    $('#sub_category').html('<option value="">Sub Category</option>');

                    $.each(data, function (key, value) {
                        $('#sub_category').append(
                            '<option value="' + value.id + '">' + value.name + '</option>'
                        );
                    });
                }
            });
        }
    });
</script>
@endsection
