<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-12">	
				<div class="row">
					<div class="col-md-6 col-12">			
						<h5>Online Shopping</h5>
						<ul class="footer-card">
							@if (getCategories()->isNotEmpty())
								@foreach (getCategories() as $category)
									<li>
										<a href="{{ route('front.category.shop', [$category->category_slug]) }}" title="{{ $category->category_name }}" >
											{{ $category->category_name }}
										</a>
									</li>
								@endforeach
							@endif
						</ul>				
					</div>
					<div class="col-md-6 col-12">				
						<h5>Customer Policies</h5>
						<ul class="footer-card">
							@if(staticPages()->isNotEmpty())
								@foreach (staticPages() as $page)
									<li><a href="{{ route('front.page',$page->slug) }}" title="{{ $page->name }}">{{ $page->name }}</a></li>
								@endforeach
							@endif
						</ul>				
					</div>
				</div>
			</div>

			<div class="col-md-4 col-12">
				<div class="original-banner">
					<div class="icon"></div>
					<div class="text">
						<h6><span>100% Original</span>
							guarantee for all products at myntra.com
						</h6>						
					</div>
				</div>

				<div class="original-banner">
					<div class="icon"></div>
					<div class="text">
						<h6>
							<span>Returns within 7 days</span>
							of your order
						</h6>
					</div>
				</div>
			</div>
		</div>
	
		<div class="popular-search">
			<h5>Popular Search</h5>
		</div>
	</div>

	<div class="copyright-area">
		<div class="container">
			<div class="row">
				<div class="col-12 mt-3">
					<div class="copy-right text-center">
						<p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

@include('front.layouts.login_register')