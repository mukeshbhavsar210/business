@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Edit Sub Category</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('categories.index') }}" class="btn btn-primary float-end">Back</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <form action="" method="post" name="subCategoryForm" id="subCategoryForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name">Category</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Select a Category</option>
                                    @if($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option {{ ($subCategory->category_id == $category->id) ? 'selected' : ' ' }} value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="sub_category_name">Name</label>
                                <input type="text" name="sub_category_name" id="sub_category_name" class="slug-source form-control" data-target="#sub_category_slug" placeholder="Name" value="{{ $subCategory->sub_category_name }}">
                                <input type="hidden" readonly id="sub_category_slug" name="sub_category_slug" class="form-control"  value="{{ $subCategory->sub_category_slug }}">
                                <p></p>
                            </div>
                        </div>                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option {{ ($subCategory->status == 1) ? 'selected' : ' ' }} value="1">Active</option>
                                    <option {{ ($subCategory->status == 0) ? 'selected' : ' ' }} value="0">Block</option>
                                </select>
                                <p></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="showHome">Show on Home</label>
                                <select name="showHome" id="showHome" class="form-select">
                                    <option {{ ($subCategory->showHome == 'Yes' ? 'selected' : '')}} value="Yes">Yes</option>
                                    <option  {{ ($subCategory->showHome == 'No' ? 'selected' : '')}} value="No">No</option>
                                </select>
                            </div>
                        </div>                        
                        <div class="col-md-1 mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>                            
                        </div>                        
                    </div>
                </div>
            </div>            
        </form>
    </div>    
</section>
@endsection

@section('customJs')
<script>
    $("#subCategoryForm").submit(function(event){
        event.preventDefault();

        var element = $('#subCategoryForm');
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("sub_category.update", $subCategory->id) }}',
            type: 'put',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){

                    window.location.href="{{ route('categories.index') }}"

                    $('#sub_category_name').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $('#sub_category_slug').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $('#category').removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                } else {

                    if(response['notFound'] == true){
                        window.location.href="{{ route('categories.index') }}"
                        return false;
                    }

                    var errors = response['errors']
                    if(errors['sub_category_name']){
                        $('#sub_category_name').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['sub_category_name']);
                    } else {
                        $('#sub_category_name').removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }

                    if(errors['sub_category_slug']){
                        $('#sub_category_slug').addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['sub_category_slug']);
                    } else {
                        $('#sub_category_slug').removeClass('is-invalid')
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

    $('#sub_category_name').change(function(){
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


     $(document).on('change', '.slug-source', function () {
        let element = $(this);
        let target = element.data('target');

        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'GET',
            data: { title: element.val() },
            dataType: 'json',
            success: function (response) {

                $("button[type=submit]").prop('disabled', false);

                if (response.status === true) {
                    $(target).val(response.slug);
                }
            }
        });
    });
</script>
@endsection
