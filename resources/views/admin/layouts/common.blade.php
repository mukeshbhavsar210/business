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

<div class="card-header">
    <div class="row align-items-center">            
        <div class="row">                
            <div class="col-sm-7 col-12 d-flex">
                <h3>{{ $title }}</h3>  
                <span class="counts">{{ $total }}</span>
            </div>
            <div class="col-sm-5 col-12 float-end">
                <div class="flexContainer">
                    <form action="" method="get" >
                        <div class="d-flex">
                            <div class="card-title">
                                <button type="button" onclick="window.location.href='{{ $refresh }}'" class="btn btn-default btn-sm">
                                    <?xml version="1.0" encoding="utf-8"?>
                                        <svg width="20px" height="20px" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                                        <g fill="none" fill-rule="evenodd" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" transform="matrix(0 1 1 0 2.5 2.5)">
                                        <path d="m3.98652376 1.07807068c-2.38377179 1.38514556-3.98652376 3.96636605-3.98652376 6.92192932 0 4.418278 3.581722 8 8 8s8-3.581722 8-8-3.581722-8-8-8"/>
                                        <path d="m4 1v4h-4" transform="matrix(1 0 0 -1 0 6)"/>
                                        </g>
                                    </svg>
                                </button>
                            </div>
        
                            <div class="card-tools">
                                <div class="input-group input-group searchMain" >
                                    <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn">
                                            <i class="iconoir-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}">{{ $button_name }}</button>                            
                    {{-- <a href="{{ $button_route }}" class="btn btn-primary">{{ $button_name }}</a> --}}
                </div>
            </div>
        </div>                        
    </div>
</div>

<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" aria-labelledby="{{ $modal_id }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $formConfig['modal_size'] ?? '' }}">
        <div class="modal-content">            
            <form action="{{ $formConfig['action'] }}" method="POST" class="ajax-form" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        @foreach($formConfig['fields'] as $field)                        
                            <div class="{{ $field['col'] ?? 'col-md-12' }}">
                                <div class="form-group">
                                    <label class="form-label" for="{{ $field['name'] }}">{{ $field['label'] }}</label>

                                    @if($field['type'] == 'text')
                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['id'] ?? '' }}" class="form-control {{ $field['class'] ?? '' }}" placeholder="{{ $field['placeholder'] ?? '' }}"
                                            @if(isset($field['data']))
                                                @foreach($field['data'] as $key => $value)
                                                    data-{{ $key }}="{{ $value }}"
                                                @endforeach
                                            @endif 
                                        >

                                    @elseif($field['type'] == 'textarea')
                                        <textarea name="{{ $field['name'] }}" class="form-control {{ $field['summer_class'] }}"></textarea>                                        

                                    @elseif($field['type'] == 'color')
                                        <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}">

                                    @elseif($field['type'] == 'email')
                                        <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}">

                                    @elseif($field['type'] == 'date')
                                        <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}">

                                    @elseif($field['type'] == 'file')
                                        <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" class="form-control" placeholder="{{ $field['placeholder'] ?? '' }}">

                                    @elseif($field['type'] == 'select')
                                        <select name="{{ $field['name'] }}" class="form-select">
                                            @foreach($field['options'] as $value => $label)
                                                <option value="{{ $value }}">
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>                                                    
                                    @endif
                                </div>
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
</script>
@endsection