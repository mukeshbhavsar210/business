<div class="modal fade" id="ratingsModal_{{ $item->product->id }}" tabindex="-1" aria-labelledby="ratingsModal_{{ $item->product->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="ratingsModal__{{ $item->product->id }}Label">Write Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">                                                                          
                    {{-- @foreach ($orderItems as $item) --}}
                     @foreach($order->items as $item)
                        <div class="image-area">
                            @php
                                $userReview = $userReviews[$item->product->id] ?? null;
                            @endphp

                            @if(!$userReview)                                
                                <div class="img">
                                    <img src="{{ asset('uploads/product/small/'.$item->product->images->first()->image ?? '') }}"  class="img-fluid">
                                </div>
                                <div class="right-review">                                                                                
                                    <h5>{{ Str::limit($item->product->title, 70, '...') }}</h5>                                                                                

                                    <div class="modal-rating" data-product="{{ $item->product->id }}">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="star" data-value="{{ $i }}">☆</i>
                                        @endfor
                                    </div>

                                    <input type="hidden" name="rating[{{ $item->product->id }}]" class="rating-value" >
                                    <textarea name="review[{{ $item->product->id }}]" class="form-control mt-2"
                                    placeholder="Please Write Product review here" cols="3" rows="3" placeholder=""></textarea>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <p class="tiny-font text-muted mt-2">By submitting review you give us consent to publish and process personal information in accordance with Terms of use and Privacy Policy</p>
                </div>                                                                
                <div class="modal-footer">                                                                    
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


@section('customJs')
<script>
    $(document).ready(function(){   
        $(document).on('click', '.open-modal', function () {
            let value = $(this).data('value');
            let productId = $(this).data('product');

            let modal = $('#ratingsModal_' + productId);
            let stars = modal.find('.modal-rating .star');

            // reset
            stars.removeClass('active').html('☆');

            // fill till clicked value
            stars.each(function () {
                if ($(this).data('value') <= value) {
                    $(this).addClass('active').html('★');
                }
            });

            // set hidden input
            modal.find('.rating-value').val(value);
        });


        $(document).on('click', '.modal-rating .star', function () {
            let value = $(this).data('value');
            let parent = $(this).closest('.modal-rating');
            let productId = parent.data('product');

            // reset stars (ONLY inside this modal)
            parent.find('.star').html('☆');

            // fill stars
            parent.find('.star').each(function () {
                if ($(this).data('value') <= value) {
                    $(this).html('★');
                }
            });

            // set correct hidden input
            $('input[name="rating[' + productId + ']"]').val(value);
        });
    });
</script>
@endsection