@if (Session::has('success'))    
    <div class="toast-message fade show" role="alert" data-bs-delay="2000">        
        <div class="toast-body">{!! Session::get('success') !!}</div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>        
    </div>    
@endif