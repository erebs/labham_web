@extends('layouts.Frontend')
@section('title')
 blogs
  @endsection 
 
@section('contentss')
	<!-- sidebar end  -->
	<!-- .banner-pages  -->
	<div class="banner-main container-main" style="background-image: url('{{ asset('frontend/images/banner-two.png') }}');background-repeat: no-repeat;background-size: 100% auto;padding: 9% 0 9% 0;background-position: center;background-repeat: no-repeat;background-size: cover;height: -webkit-fill-available;">
		<h1 class="text-center banner-main-head">Blog</h1>
		<p class="text-center text-white">We are honoured to be a part of your journey...</p>
	</div>
	<div class="container-main blog-main-section">
		<h1 class="blog-main-head text-center mb-2">Working <span style="font-size: unset !important;" class="labham-primary-color">project</span></h1>
		<p class="text-center text-dark pb-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. x</p>
		<div class="row">
			<div class="col-lg-3 col-md-4 col-sm-6 col-6">
				<div class="inner-col-blog">
					<img src="{{asset('/frontend/images/blog-one.png')}}" alt="blog-img">
					<h4 class="blog-text-img text-white">LABHAM HOUSE <i class="fa-solid fa-arrow-right"></i></h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-6">
				<div class="inner-col-blog">
					<img src="{{asset('/frontend/images/blog-two.png')}}" alt="blog-img">
					<h4 class="blog-text-img text-white">LABHAM HOUSE <i class="fa-solid fa-arrow-right"></i></h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-6">
				<div class="inner-col-blog">
					<img src="{{asset('/frontend/images/blog-three.png')}}" alt="blog-img">
					<h4 class="blog-text-img text-white">LABHAM HOUSE <i class="fa-solid fa-arrow-right"></i></h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-6">
				<div class="inner-col-blog">
					<img src="{{asset('/frontend/images/blog-four.png')}}" alt="blog-img">
					<h4 class="blog-text-img text-white">LABHAM HOUSE <i class="fa-solid fa-arrow-right"></i></h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-6">
				<div class="inner-col-blog">
					<img src="{{asset('/frontend/images/blog-one.png')}}" alt="blog-img">
					<h4 class="blog-text-img text-white">LABHAM HOUSE <i class="fa-solid fa-arrow-right"></i></h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-6">
				<div class="inner-col-blog">
					<img src="{{asset('/frontend/images/blog-two.png')}}" alt="blog-img">
					<h4 class="blog-text-img text-white">LABHAM HOUSE <i class="fa-solid fa-arrow-right"></i></h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-6">
				<div class="inner-col-blog">
					<img src="{{asset('/frontend/images/blog-three.png')}}" alt="blog-img">
					<h4 class="blog-text-img text-white">LABHAM HOUSE <i class="fa-solid fa-arrow-right"></i></h4>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-6 col-6">
				<div class="inner-col-blog">
					<img src="{{asset('/frontend/images/blog-four.png')}}" alt="blog-img">
					<h4 class="blog-text-img text-white">LABHAM HOUSE <i class="fa-solid fa-arrow-right"></i></h4>
				</div>
			</div>
			</div>
		</div>
	</div>
	<div class="container-main blog-client-head">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="blog-main-head text-center pt-4">OUR <span style="font-size: unset !important;" class="labham-primary-color">Clients</span></h1>
				<p class="text-center text-dark pb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. x</p>
			</div>
			<div class="col-lg-6">
				<div class="inner-col-clients">
					<img src="{{asset('/frontend/images/Rectangle 1816.png')}}" alt="">
					<div class="inner-content-client">
						<h3 class="text-white">Lorem Ipsum is simply dummy <i class="fa-solid fa-arrow-right"></i></h3>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="inner-col-clients">
					<img src="{{asset('/frontend/images/Rectangle 1817.png')}}" alt="">
					<div class="inner-content-client">
						<h3 class="text-white">Lorem Ipsum is simply dummy <i class="fa-solid fa-arrow-right"></i></h3>
					</div>
				</div>
			</div>
		</div>
	</div>











@endsection