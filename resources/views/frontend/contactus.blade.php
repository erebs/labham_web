@extends('layouts.Frontend')
@section('title')
 contact
  @endsection 
 
@section('contentss')
	<!-- sidebar end  -->
	<!-- .banner-pages  -->
	<div class="banner-main container-main" style="background-image: url('{{ asset('frontend/images/banner-two.png') }}');background-repeat: no-repeat;background-size: 100% auto;padding: 9% 0 9% 0;background-position: center;background-repeat: no-repeat;background-size: cover;height: -webkit-fill-available;">
		<h1 class="text-center banner-main-head">Contact Us</h1>
		<p class="text-center text-white">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet </p>
	</div>
	<div class="contact-details container-main">
		<div class="row">
			<div class="col-lg-4">
				<div class="inner-col-contact">
					<img src="{{asset('/frontend/images/Vector (1).png')}}" alt="">
					<h3 class="text-center">Office Location</h3>
					<p class="text-center">MHS Tower , Kinassery , Kozhikode , Kerala,  pin:673013</p>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="inner-col-contact">
					<img src="{{asset('/frontend/images/Vector (2).png')}}" alt="">
					<h3 class="text-center" >Discuss on Phone</h3>
					<p class="text-center">+91 8075646433</p>
					<p class="text-center">+91 9778919040</p>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="inner-col-contact">
					<img src="{{asset('/frontend/images/Vector (3).png')}}" alt="">
					<h3 class="text-center" >Send an Email</h3>
					<p class="text-center">sreevan@labhamhouse.com</p>
				</div>
			</div>
		</div>
	</div>
	<!-- message section -->
	<!-- <div class="contact-send-msg">
		<div class="container-main">
			<div class="send-message-contact">
				<div class="row">
					<div class="col-lg-6 send-message-div">
						<h1 class="send-message-heading">Get in touch with LABHAM HOUSE  <br> and send us messages <br> for any info.</h1>
						<h4 class="send-message-subheading">Just send us your query <br> we will give you the help you need at any time.</h5>
					</div>
					<div class="col-lg-6">
						<form>
							<div class="row">
								<div class="col-lg-6 pb-3">
									<input type="text" class="form-control" placeholder="First name">
								</div>
								<div class="col-lg-6 pb-3">
									<input type="text" class="form-control" placeholder="Last name">
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6 pb-3">
									<input type="email" class="form-control" placeholder="Email Address">
								</div> 
								<div class="col-lg-6 pb-3">
									<input type="number" class="form-control" placeholder="Phone">
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12 pb-3">
									<textarea class="form-control" placeholder="Message goes here.." id="exampleFormControlTextarea1" rows="4"></textarea>
								</div>
							</div>
						</form>
					</div>
				</div>
				<a class="btn labham-primary-bg home-send-message-btn text-white" href="#">send message</a>
			</div>
		</div>
	</div> -->











@endsection