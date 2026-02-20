@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Edit Sub2 Category</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('categories.index') }}" class="btn btn-primary float-end">Back</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <form action="" method="post" name="sub2CategoryForm" id="sub2CategoryForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                            <label>Category</label>
                                <select name="category_id" id="category" class="form-select">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $sub2Category->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Sub Category</label>
                                <select name="sub_category_id" id="sub_category" class="form-select">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}"
                                            {{ $sub2Category->sub_category_id == $subCategory->id ? 'selected' : '' }}>
                                            {{ $subCategory->sub_category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                       
                        <div class="col-md-7">
                            <div class="form-group">                            
                                <label for="sub2_category_name">Name</label>
                                <input type="text" name="sub2_category_name" id="sub2_category_name" class="slug-source form-control" data-target="#sub2_category_slug" placeholder="Name" value="{{ $sub2Category->sub2_category_name }}">
                                <input type="hidden" readonly id="sub2_category_slug" name="sub2_category_slug" class="form-control" value="{{ $sub2Category->sub2_category_slug }}">
                                <p></p>
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
    $("#sub2CategoryForm").submit(function(event){
        event.preventDefault();

        var element = $('#sub2CategoryForm');
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("sub2_category.update", $sub2Category->id) }}',
            type: 'put',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){

                    window.location.href="{{ route('categories.index') }}"

                    // $('#sub2_category_name').removeClass('is-invalid')
                    // .siblings('p')
                    // .removeClass('invalid-feedback').html("");

                    // $('#sub2_category_slug').removeClass('is-invalid')
                    // .siblings('p')
                    // .removeClass('invalid-feedback').html("");

                    // $('#category').removeClass('is-invalid')
                    // .siblings('p')
                    // .removeClass('invalid-feedback').html("");

                } else {

                    if(response['notFound'] == true){
                        window.location.href="{{ route('categories.index') }}"
                        return false;
                    }

                    // var errors = response['errors']
                    // if(errors['sub2_category_name']){
                    //     $('#sub2_category_name').addClass('is-invalid')
                    //     .siblings('p')
                    //     .addClass('invalid-feedback').html(errors['sub2_category_name']);
                    // } else {
                    //     $('#sub2_category_name').removeClass('is-invalid')
                    //     .siblings('p')
                    //     .removeClass('invalid-feedback').html("");
                    // }

                    // if(errors['sub2_category_slug']){
                    //     $('#sub2_category_slug').addClass('is-invalid')
                    //     .siblings('p')
                    //     .addClass('invalid-feedback').html(errors['sub2_category_slug']);
                    // } else {
                    //     $('#sub2_category_slug').removeClass('is-invalid')
                    //     .siblings('p')
                    //     .removeClass('invalid-feedback').html("");
                    // }

                    // if(errors['category']){
                    //     $('#category').addClass('is-invalid')
                    //     .siblings('p')
                    //     .addClass('invalid-feedback').html(errors['category']);
                    // } else {
                    //     $('#category').removeClass('is-invalid')
                    //     .siblings('p')
                    //     .removeClass('invalid-feedback').html("");
                    // }

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
