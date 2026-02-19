@extends('admin.layouts.app')

@section('content')

<div class="card mb-0"> 
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-semibold active py-2" data-bs-toggle="tab" href="#documents" role="tab" aria-selected="true">
                Category                        
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-semibold py-2" data-bs-toggle="tab" href="#images" role="tab" aria-selected="false" tabindex="-1">                                            
                Sub Category                
            </a>
        </li>                                                
        <li class="nav-item" role="presentation">
            <a class="nav-link fw-semibold py-2" data-bs-toggle="tab" href="#audio" role="tab" aria-selected="false" tabindex="-1">
                Sub2 Category                
            </a>
        </li>
    </ul>                           
</div>

<div class="card">    
    <div class="row">
        <div class="col-12">                            
            <div class="card">
                <div class="card-body">                                    
                    <div class="tab-content">
                        @include('admin/categories/category/tab1')
                        @include('admin/categories/category/tab2')
                        @include('admin/categories/category/tab3')
                    </div>
                </div>
            </div>
        </div>                                                                                                    
    </div>
                    
    {{ $categories->links() }}    
</div>            
@endsection

@section('customJs')
<script>
     $(document).ready(function () {
        $("#createCategoryForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('categories.category.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createCategory')
                    );
                    modal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }); 


        $(document).on('change', '#category_id', function () {
            var categoryID = $(this).val();

            if (categoryID) {
                $('#sub_category').html('<option>Loading...</option>');

                $.ajax({
                     url: "{{ route('get.subcategories', ':id') }}".replace(':id', categoryID),
                    type: 'GET',
                    success: function (data) {

                        $('#sub_category').html('<option value="">Select Sub Category</option>');

                        $.each(data, function (key, value) {
                            $('#sub_category').append(
                                '<option value="' + value.id + '">' + value.sub_category_name + '</option>'
                            );
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });

            } else {
                $('#sub_category').html('<option value="">Select Sub Category</option>');
            }

        });


        $("#createSubCategoryForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('categories.subCategory.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createSubCategory')
                    );
                    modal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });


        $("#createSub2CategoryForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('categories.sub2Category.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createSub2Category')
                    );
                    modal.hide();
                    location.reload();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
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
            console.log(response)
        }
    });


   


    function deleteCategory(id){
        var url = '{{ route("categories.delete","ID") }}'
        var newUrl = url.replace("ID",id)

        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response["status"]){
                        window.location.href="{{ route('categories.index') }}"
                    }
                }
            });
        }
    }


    function deleteSubCategory(id){
        var url = '{{ route("subCategories.delete","ID") }}'
        var newUrl = url.replace("ID",id)

        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    window.location.href="{{ route('categories.index') }}"
                   
                }
            });
        }

    }


    function deleteSub2Category(id){
        var url = '{{ route("sub2Categories.delete","ID") }}'
        var newUrl = url.replace("ID",id)

        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: newUrl,
                type: 'delete',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    window.location.href="{{ route('categories.index') }}"
                    
                }
            });
        }
    }
</script>
@endsection
