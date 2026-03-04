<div class="status delivered">
    <div class="icon">
        <div class="delivery-tick"></div>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#FFFFFF" fill-rule="nonzero" d="M19.173 7.059l-7.232-4a.469.469 0 0 0-.454 0l-7.232 4A.503.503 0 0 0 4 7.5v9c0 .185.098.355.255.441l7.232 4a.469.469 0 0 0 .454 0l7.232-4a.503.503 0 0 0 .256-.441v-9a.503.503 0 0 0-.256-.441zm-7.459-2.992L17.922 7.5 15.33 8.933 9.123 5.5l2.591-1.433zm-.482 15.6L4.964 16.2V8.334l6.268 3.466v7.866zm.482-8.734L5.507 7.5l2.591-1.433L14.305 9.5l-2.59 1.433zm6.75 5.267l-6.268 3.466V11.8l6.268-3.466V16.2z"></path></svg>
    </div>
    <div class="name">
        <p><b>Delivered</b></p>
        <p class="date">On {{ \Carbon\Carbon::parse($order->created_date)->format('D, d M Y') }}</p>
    </div>
</div>

<div class="product-details">
    @foreach($order->items as $item)    
        <a href="{{ route('account.orderDetail',$order->id) }}" class="product-details-link">
            @include('front.account.orders.product_card')
        </a>
    @endforeach

    <div class="gaps">
        <p class="text-muted">Exchange/Return window closed on Sun, 2 Mar 2025</p>                                            
    </div>
    <div class="ratings">
        <div class="rating-rateBox"><div class="myRating-inline"><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div><div tabindex="0" role="button" class="myRating-imageWrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0  24 24"><path d="M8.65 8.144l-6.023.918-.102.023c-.524.158-.712.866-.303 1.283l4.358 4.45-1.029 6.285-.01.103c-.023.573.565.983 1.071.704L12 18.943l5.388 2.967.09.043c.514.2 1.067-.26.97-.85l-1.029-6.285 4.36-4.45.07-.082c.334-.45.089-1.138-.476-1.224l-6.024-.918-2.694-5.717a.717.717 0 00-1.31 0L8.65 8.144z" fill="#FFF" stroke="#A9ABB3" stroke-width="1.5" fill-rule="evenodd" stroke-linejoin="round"></path></svg></div></div></div>
        <p class="text-muted">Rate & Review to win MynCash!</p>
    </div>
</div>