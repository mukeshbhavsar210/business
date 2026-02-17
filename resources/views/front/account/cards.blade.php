@extends('front.layouts.app')

@section('content')

<div class="container-small">
    <div class="small-title">
        <h4>Account</h4>
        <p>User name</p>
    </div>

    <div class="row">
        <div class="col-md-3 col-12">
            @include('front.account.common.sidebar')  
        </div>
        <div class="col-md-9 col-12">
            @include('front.account.common.message')        
            <h3>Saved Cards</h3>                
            </div>            
        </div>            
    </div>
</div>

@endsection

@section('customJs')
<script>
    
</script>
@endsection
