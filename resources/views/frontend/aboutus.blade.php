@extends('layouts.Frontend')
@section('title')
 aboutus
  @endsection 
 
@section('contentss')
	<!-- sidebar end  -->
	<!-- .banner-pages  -->
	<div class="banner-main container-main" style="background-image: url('{{ asset('frontend/images/banner-two.png') }}');background-repeat: no-repeat;background-size: 100% auto;padding: 9% 0 9% 0;background-position: center;background-repeat: no-repeat;background-size: cover;height: -webkit-fill-available;">
		<h1 class="text-center banner-main-head">ABOUT US</h1>
	</div>
	<div class="container-main about-section">
		<div class="row text-center">
			<div class="col-lg-4 col-md-4 col-sm-4 col-6">
				<div class="inner-col-about">
					<img src="{{asset('/frontend/images/Ellipse 44.png')}}" alt="about-img">
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-6">
				<div class="inner-col-about">
					<img src="{{asset('/frontend/images/Ellipse 44.png')}}" alt="about-img">
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-6">
				<div class="inner-col-about">
					<img src="{{asset('/frontend/images/Ellipse 44.png')}}" alt="about-img">
				</div>
			</div>
		</div>
	</div>
	<div class="container-main about-content">
		<div class="row align-items-center">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="inner-col-about-6">
					<img src="{{asset('/frontend/images/about-img.png')}}" alt="">
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="inner-col-about-6">
					<p class="text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic</p>
				</div>
			</div>
		</div>
	</div>
	<div class="about-main-bg container-main"  style="background-image:url('{{ asset('frontend/images/abutt-main.png') }}');background-repeat: no-repeat;background-size: 100% auto;padding: 9% 0 9% 0;background-position: center;background-repeat: no-repeat;background-size: cover;height: -webkit-fill-available;">
		<h5 href="#" class="labham-primary-bg text-white believe-text text-center">We Believe</h5>
		<h1 class="text-center text-white about-sub-head-banner">Quality of life is determined by quality of citizenship and quality of infrastructure and services.</h1>
	</div>
	<div class="container-main about-content">
		<div class="row align-items-center">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<h1 class="text-center pb-2">About US</h1>
				<p class="text-justify">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic</p>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<img src="{{asset('/frontend/images/Rectangle 1806.png')}}" alt="">
			</div>
		</div>
	</div>

	@endsection