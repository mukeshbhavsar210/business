@extends('admin.layouts.app')

@section('content')

<div class="card custom-card">
    @include('admin.layouts.common')        
        <div class="card-body">            
            <div class="chip-wrapper">
                @if ($colors->isNotEmpty())
                    @foreach ($colors as $value)
                        <div class="color-chip">
                            <span class="badge" style="background-color: {{ $value->code }}"></span>
                            <span class="color-title">{{ $value->name }}</span>
                        
                            <a href="#" onclick="deleteBrand({{ $value->id }})" class="float-end">
                                <i class="las la-trash-alt text-secondary fs-18"></i>
                            </a> 
                        </div>
                    @endforeach            
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $(document).ready(function () {
        $("#createBrandForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('colors.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    var modal = bootstrap.Modal.getInstance(
                        document.getElementById('createBrandModal')
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

    function deleteBrand(id){
        var url = '{{ route("brands.delete","ID") }}'
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
                        window.location.href="{{ route('brands.index') }}"
                    }
                }
            });
        }

    }
</script>
@endsection
