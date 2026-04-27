@extends('front.layouts.app')

@section('title', 'FAQS')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-12 mx-auto">
            <h2>Frequently Asked Questions</h2>

            <hr />

            <div class="row mt-4">
                <div class="col-md-3 col-12">
                    <ul id="faq-nav" class="nav flex-column position-sticky" style="top: 20px;">
                        <li><a class=" active" href="#faq1">Top Queries</a></li>
                        <li><a class="" href="#faq2">Terms and Conditions</a></li>
                        <li><a class="" href="#faq3">Shipping, Order, Tracking & Delivery</a></li>
                        <li><a class="" href="#faq4">Cancellations & Modifications</a></li>
                        <li><a class="" href="#faq5">Return & Exchange</a></li>
                        <li><a class="" href="#faq6">Sign Up & Login</a></li>
                        <li><a class="" href="#faq7">Payments</a></li>
                        <li><a class="" href="#faq8">Coupons and "My Cashback"</a></li>
                    </ul>
                </div>

                <div class="col-md-9 col-12">
                    <div data-bs-spy="scroll" data-bs-target="#faq-nav" data-bs-offset="0" class="scrollspy-example" tabindex="0" style="height: 500px; overflow-y: auto;">
                        <div id="faq1" class="faq-section">
                            <h4>Top Queries</h4>
                            <p class="mt-3">You can track your orders in 'My Orders.'</p>
                            <hr />
                            
                            <div class="accordion-faqs" id="accordionExample">
                                <div class="accordion-item">
                                    <h6 class="accordion-button" data-bs-toggle="collapse" data-bs-target="#faqs-1" aria-expanded="true" aria-controls="collapseOne">
                                        Why are there different prices for the same product? Is it legal? 
                                    </h6>
                                    
                                    <div id="faqs-1" class="accordion-collapse collapse show" aria-labelledby="faqs-1" data-bs-parent="#accordionExample">
                                        {{ config('app.name') }} is an online marketplace platform that enables independent sellers to sell their products to buyers. The prices are solely decided by the sellers, and Myntra does not interfere in the same. There could be a possibility that the same product is sold by different sellers at different prices. Myntra rightfully fulfils all legal compliances of onboarding multiple sellers on its forum as it is a marketplace platform.
                                    </div>
                                </div>

                                <div class="accordion-item">                                
                                    <h5 class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faqs-2" aria-expanded="false" aria-controls="collapseTwo">
                                         How can I contact any seller? 
                                    </h5>
                                
                                    <div id="faqs-2" class="accordion-collapse collapse" aria-labelledby="faqs-2" data-bs-parent="#accordionExample">
                                        <p>{{ config('app.name') }} is a marketplace on which third-party sellers sell products to customers. To contact a seller or raise any grievance against them, please send a letter with the below address on the envelope and include product page URL so that it can be forwarded to the seller.</p>
                                        <p>To,<br />
                                        'Include Seller's name'<br />
                                        Seller Mailbox: Contact Seller<br />
                                        C/O {{ config('app.name') }}<br />
                                        Buildings Alyssa, Begonia and Clover situated in Embassy Tech Village,<br />
                                        Outer Ring Road, Devarabeesanahalli Village, Varthur Hobli,<br />
                                        Bengaluru – 560103, India<br />
                                        Telephone: +91-80-61561999</p>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h5 class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faqs-3" aria-expanded="false" aria-controls="collapseThree">
                                         I saw the product at Rs. 1000 but post clicking on the product, there are multiple prices and the size which I want is being sold for Rs. 1600. Why is there a change in price in the product description page? 
                                    </h5>

                                    <div id="faqs-3" class="accordion-collapse collapse" aria-labelledby="faqs-3" data-bs-parent="#accordionExample">
                                        It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="faq2" class="faq-section d-none">
                            <h4>Terms and Conditions</h4>                    
                        </div>

                        <div id="faq3" class="faq-section d-none">
                            <h4>Shipping, Order, Tracking & Delivery</h4>                    
                        </div>

                        <div id="faq4" class="faq-section d-none">
                            <h4>Cancellations & Modifications</h4>                    
                        </div>

                        <div id="faq5" class="faq-section d-none">
                            <h4>Return & Exchange</h4>                    
                        </div>

                        <div id="faq6" class="faq-section d-none">
                            <h4>Sign Up & Login</h4>                    
                        </div>

                        <div id="faq7" class="faq-section d-none">
                            <h4>Payments</h4>                    
                        </div>

                        <div id="faq8" class="faq-section d-none">
                            <h4>Coupons and "My Cashback"</h4>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
@endsection