@extends('admin.layouts.app')

@section('content')

<div class="card mb-0">
    <div class="card-body pb-0">            
        <div class="row">                
            <div class="col-sm-7 col-12">
                <div class="page-title">
                    <h4>Ratings</h4>
                    <span class="counts">{{ $total }}</span>
                </div>
            </div>
            <div class="col-sm-5 col-12 float-end">
                
            </div>
        </div>                        
    </div>
</div>

<div class="card">
    <div class="card-body py-2">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-top-0" width="20%">Product</th>
                            <th class="border-top-0" width="15%">Rating</th>
                            <th class="border-top-0" width="35%">Comments</th>
                            <th class="border-top-0" width="8%">Status</th>
                            <th class="border-top-0" width="5%">Action</th>                            
                        </tr>
                    </thead>                     
                    <tbody>
                        @if ($reviews->isNotEmpty())
                            @foreach ($reviews as $key => $review)                                                                   
                                <tr>
                                    <td>
                                        @php
                                            $productImage = optional($review->product)->product_images->first();
                                        @endphp

                                        <div class="d-flex align-items-center">
                                            <a href="{{ $review->product->url }}" target="_blank">                                                
                                                @if (!empty($productImage?->image))
                                                    <img src="{{ asset('uploads/product/small/'.$productImage->image) }}" height="90" class="me-3 align-self-center rounded">
                                                @else
                                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }}" height="90" class="me-3 align-self-center rounded">
                                                @endif
                                            </a>

                                            <div class="flex-grow-1 text-truncate">
                                                <h5 class="product-title ">
                                                    <a href="{{ route('products.edit', $review->product->id) }}">
                                                        {{ Str::limit($review->product->title, 70, '...') }}                                                                                                             
                                                    </a>                                                    
                                                </h5>
                                                <p class="small-fonts"><span class="text-muted">{{ $review->id }} / </span></p>                                                
                                            </div>
                                        </div>                                       
                                    </td>
                                    <td>                                        
                                        <p>{{ $review->user->name }} ({{ $review->user->id }})</p>
                                        <p>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    ⭐
                                                @else
                                                    <span style="color: #ccc;">☆</span>
                                                @endif
                                            @endfor
                                            <b>{{ $review->rating }}</b>                                            
                                        </p>                                        
                                    </td>
                                    <td><p>{{ $review->review }}</p></td>
                                    <td>
                                        @if($review->status == 1)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif                                     
                                    </td>
                                    <td>
                                        @if($review->status == 0)
                                            <a href="{{ route('review.approve', $review->id) }}" class="btn btn-sm btn-outline-primary">Approve</a>
                                        @else
                                            <a href="{{ route('review.reject', $review->id) }}" class="btn btn-sm btn-outline-primary">Reject</a>
                                        @endif
                                    </td>                                     
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Records not found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</section>
@endsection