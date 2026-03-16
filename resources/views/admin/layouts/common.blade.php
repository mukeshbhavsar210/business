<div id="alert-area">
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}Label" aria-hidden="true" data-bs-keyboard="true">
    <div class="modal-dialog {{ $formConfig['modal_size'] ?? '' }}">
        <div class="modal-content">            
            <form action="{{ $formConfig['action'] }}" method="POST" class="ajax-form" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body py-3">
                    <div class="row">
                        @foreach($formConfig['fields'] as $field)                        
                            <div class="{{ $field['col'] ?? 'col-md-12' }}">                                
                                @if($field['type'] == 'text')
                                    <div class="form-group">
                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['id'] ?? '' }}" class="form-control {{ $field['animate_label'] ?? '' }} {{ $field['class'] ?? '' }}" 
                                            @if(isset($field['data']))
                                                @foreach($field['data'] as $key => $value)
                                                    data-{{ $key }}="{{ $value }}"
                                                @endforeach
                                            @endif 
                                        >
                                        <label class="floating-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                    </div>

                                    @elseif($field['type'] == 'textarea')
                                        <div class="form-group">
                                            <textarea name="{{ $field['name'] }}" class="form-control {{ $field['summer_class'] }}" rows="4"></textarea>                                        
                                            <label class="floating-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                        </div>
                                        
                                    @elseif($field['type'] == 'color')
                                        <div class="form-group">
                                            <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                            <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}">                                            
                                        </div>

                                    @elseif($field['type'] == 'email')
                                        <div class="form-group">
                                            <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}">
                                            <label class="floating-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                        </div>

                                    @elseif($field['type'] == 'date')
                                        <div class="form-group">
                                            <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                            <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}">                                            
                                        </div>

                                    @elseif($field['type'] == 'file')
                                        <div class="form-group">
                                            <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}">
                                            <label class="floating-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                        </div>

                                    @elseif($field['type'] == 'dropzone')
                                        <div class="form-group">
                                            {{-- <input type="hidden" id="{{ $field['image_id'] }}" name="{{ $field['image_id'] }}" value=" "> --}}
                                            <input type="hidden" id="image_id" name="image_id" value=" ">
                                            <label for="image">Image</label>
                                            <div id="image" class="dropzone dz-clickable">
                                                <div class="dz-message needsclick">
                                                    <br>Drop files here or click to upload.<br><br>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($field['type'] == 'select')
                                        <div class="form-group">
                                            <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                            <select name="{{ $field['name'] }}" class="form-select" id="{{ $field['name'] }}">
                                                @foreach($field['options'] as $value => $label)
                                                    <option value="{{ $value }}">
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>                                                    
                                        </div>

                                    @elseif($field['type'] == 'category')
                                        <div class="form-group">
                                            <label for="sub_category">Sub Category</label>
                                            <select name="sub_category_id" id="sub_category" class="form-select" >
                                                <option value="">Sub Category</option>
                                            </select>
                                        </div>
                                    @endif
                            </div>                        
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        {{ $formConfig['button'] }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('customJs')
<script>
    $(document).on('submit', '.ajax-form', function(e) {
        e.preventDefault();

        let form = $(this);
        let formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Close modal
                let modal = form.closest('.modal');
                let modalInstance = bootstrap.Modal.getInstance(modal[0]);
                modalInstance.hide();

                // Optional: Reset form
                form[0].reset();

                // Show success alert
                $('#alert-area').html(`
                    <div class="alert alert-success alert-dismissible fade show">
                        ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);

                // Auto remove after 3 seconds
                setTimeout(function(){
                    $('.alert').fadeOut();
                }, 3000);

                // Reload page OR append row dynamically
                location.reload();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });


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

   $(document).ready(function () {        
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
    });
</script>
@endsection