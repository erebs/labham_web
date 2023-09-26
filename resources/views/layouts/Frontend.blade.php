<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LABHAM HOUSE | @yield('title')</title>
  <link rel="stylesheet" href="{{asset('/frontend/css/common.css')}}">

  <link rel="stylesheet" href="{{asset('/frontend/css/labam.css')}}">
	<!-- swipper css -->
	<link rel="stylesheet" href="{{asset('/frontend/css/swiper-bundle.min.css')}}">
	<!-- fav icon  -->
	<link rel="icon" type="image/x-icon" href="{{asset('/frontend/images/fav-icon.png')}}">
	<!-- icons  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- bootstrap  -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- carousel  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.min.css">
	<!-- j query  -->
	<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
		<script src="{{asset('/frontend/js/swiper-bundle.min.js')}}"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
		 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<style type="text/css">
	body {
user-select: none;
}
	.cart-count {
  background-color: red; /* Customize the background color */
  color: white; /* Customize the text color */
  border-radius: 50%; /* Make it circular */
  padding: 2px 6px; /* Adjust padding as needed */
  font-size: 12px; /* Adjust font size as needed */
  position: relative; /* Position it relative to the link */
  top: -5px; /* Adjust vertical position */
  left: 5px; /* Adjust horizontal position */
}


</style>
<body>
	<!-- navbar  -->
	<nav>
    <div class="nav-main container-main">
      <div class="nav-logo">
        <a href="/"><img src="{{asset('/frontend/images/logo-main.png')}}" alt="logo-main"></a>
      </div>
			
			<div class="form-group has-search nav-item-links align-items-center">
    		<span class="fa fa-search form-control-feedback"></span>
    		<input type="text" class="form-control" id="searchInput" placeholder="Search products..." oninput="Search()">
    		<div class="search-suggestion" id="Searchsec">
					
					
				</div>
			</div>




      <div class="nav-buttons">
        <ul class="d-flex" style="margin-bottom: 0px;width: 100%;justify-content: end;">
					
					@if(auth()->guard('member')->check())
					
					<li><a href="/profile"><img src="{{asset('/frontend/images/user.png')}}" alt="login">Profile</a></li> 
					<li><a href="/cart"><img src="{{asset('/frontend/images/Buy.png')}}" alt="cart"> Cart 
						<span class="cart-count" id="cartcnt"></span>
					</a></li>
					<li class="d-md-block d-lg-none cart-mobile"><a href="/cart"><img src="{{asset('/frontend/images/Buy.png')}}" alt="cart">	<span class="count-cart" id="cartct2"></span></a></li>
					<i onclick="toggleCartt()" class="fa-solid fa-bars d-md-block d-lg-none"></i>
					
					@else
					<li><a href="/signin"><img src="{{asset('/frontend/images/user.png')}}" alt="login">Sign In</a></li>

					<li><a href="/v1/cart"><img src="{{asset('/frontend/images/Buy.png')}}" alt="cart"> Cart 
						<span class="cart-count" id="cartcnt1"></span></a></li>
						<li class="d-md-block d-lg-none cart-mobile"><a href="/v1/cart"><img src="{{asset('/frontend/images/Buy.png')}}" alt="cart">	<span class="count-cart" id="cartct1"></span></a></li>
						<i onclick="toggleCartt()" class="fa-solid fa-bars d-md-block d-lg-none"></i>
			
					@endif
					
					
					
				</ul>
      </div>
    </div>

		<div class="container-main under-container-nav">
			<div class="under-nav">
				<ul>
					<li><a href="/" >Home</a></li>
					<li><a href="/v1/product/categories">Categories</a></li>
					<li><a href="/products">Products</a></li>
					<li><a href="/about">About</a></li>
					<!-- <li><a href="/blog">Blog</a></li> -->
					<li><a href="/contact">Contact us</a></li>
				</ul>
			</div>
		</div>
  </nav>
	<!-- navbar end -->
	<!-- sidebar  -->
	<div class="sidebar">
		<div class="navbar-sidebar">
			<ul>
				<li class="sidebar-li"><a  href="/">Home</a></li>
				<li class="sidebar-li"><a href="/v1/product/categories">Categories</a></li>
				<li class="sidebar-li"><a href="/products">Products</a></li>
				<li class="sidebar-li"><a href="/about">About</a></li>
				<li class="sidebar-li"><a href="/contact">Contact us</a></li>
				@if(auth()->guard('member')->check())
				<li class="sidebar-li"><a href="/profile">Profile</a></li>
				<li class="sidebar-li"><a href="/cart">Cart
					<span class="cart-count mt-2" id="cartcntt"></span>
				</a></li>
				
				@else
				<li class="sidebar-li"><a href="/v1/cart">Cart
					<span class="cart-count mt-4" id="cartcntt1"></span>
				</a></li>
				<li class="sign-in-btn-mobile"><a href="/signin">Sign in</a></li>
				@endif
			</ul>
		</div>
		<div class="d-inline closse" onclick="toggleCartt()"><img src="{{asset('/frontend/images/close-circle-line.png')}}" alt="" srcset=""></div>
	</div>
 <div class="container-main mobile-search">
		<input type="text" class="form-control" id="searchInput1" placeholder="Search Products" oninput="Search1()">
		<div class=" search-suggestion-mobile" id="Searchsec1">
					
					
				</div>
	</div><br>

@yield('contentss')




	<!-- footer   -->
  <footer id="footer" style="background-image: url(./frontend/images/footer-bg.png);background-repeat: no-repeat;background-size: 100% auto;padding: 3% 0 1% 0;background-position: center;background-repeat: no-repeat;background-size: cover;height: -webkit-fill-available;">
		<div class="container-main">
			<div class="row text-sm-left text-md-left">
				<div class="col-xs-6 col-sm-6 col-md-4">
					<img class="logo-footer pb-3" src="{{asset('/frontend/images/logo-main.png')}}" alt="">
					<ul class="list-unstyled quick-links">
						<h3 class="footer-main-head">Contact Us</h3>
						<li><a href="#"> <img style="width: 20px;margin-top: -3px;margin-right: 10px;" src="{{asset('/frontend/images/whatsapp.png')}}" alt="icon">+91 8075646433</a></li>
						<li><a href="#"> <img style="width: 20px;margin-top: -3px;margin-right: 10px;" src="{{asset('/frontend/images/Call.png')}}" alt="icon"> +91 9778919040</a></li>
					</ul>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-4">
					<h3 class="pb-3 footer-main-head">Most Popular Categories</h3>
					<ul class="list-unstyled quick-links">
						@php
						$foot_cat=DB::table('categories')->where('status','Active')->get();
						@endphp
						@foreach($foot_cat as $fc)
						<li><a href="/v1/category-products/{{encrypt($fc->id)}}">  {{$fc->name}}</a></li>
						@endforeach
					</ul>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4">
					<h3 class="pb-3 footer-main-head">Customer Services</h3>
					<ul class="list-unstyled quick-links">
						
						<li><a href="/terms">  Terms & Conditions</a></li>
						<li><a href="/privacy-policy">  Privacy Policy</a></li>
						<li><a href="/faq">  FAQ</a></li>
						<!-- <li><a href="#">  E-waste Policy</a></li> -->
						<li><a href="return-policy" title="Design and developed by">Cancellation & Return Policy</a></li>
					</ul>
				</div>
        
			</div>
      <hr class="footer-underline">
      <div class="text-center">
        <a href="https://www.erebsindia.com/" class="text-dark footer-text">© copyright 2023 Labham House | Designed by  ERE Business Solutions</a>
      </div>
		</div>
  </footer>
	<!-- js link -->
	<script src="{{asset('/frontend/js/main.js')}}"></script>
	<!-- slider brands script  -->
	<script>
		// script for image zoom 
	 	const largeImages = document.querySelectorAll('.large-image');
     const zoomedView = document.getElementById('zoomed-view');

    largeImages.forEach((image) => {
        image.addEventListener('mousemove', (event) => {
            const { left, top, width, height } = image.getBoundingClientRect();
            const x = (event.clientX - left) / width;
            const y = (event.clientY - top) / height;

            zoomedView.style.backgroundImage = `url('${image.src}')`;
            zoomedView.style.backgroundPosition = `${x * 100}% ${y * 100}%`;
        });
    });
// end 
	// slider home 
		var swiper = new Swiper(".slide-container", {
			slidesPerView: 4,
			spaceBetween: 20,
			sliderPerGroup: 4,
			loop: true,
			centerSlide: "true",
			fade: "true",
			grabCursor: "true",
			pagination: {
				el: ".swiper-pagination",
				clickable: true,
				dynamicBullets: true,
			},
			navigation: {
				nextEl: ".swiper-button-next",
				prevEl: ".swiper-button-prev",
			},

			breakpoints: {
				0: {
					slidesPerView: 1,
				},
				520: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 3,
				},
				1000: {
					slidesPerView: 4,
				},
			},
		});
	</script>
	<!-- carousel  -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
	<!-- scripts -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="{{ asset('js/sweetalert.js') }}"></script>
</body>
</html>

<script type="text/javascript">

		$(document).ready(function() {
				$('#ab2').hide();
				$('#cashdiv').hide();
				$('#otpdiv').hide();
				$('#ct2').hide();
				GetCartCount();


 
});
	



function GetCartCount()

{
	 $.post("/get-cartcount", {_token: "{{ csrf_token() }}"}, function(result) {

                  $('#cartcnt').text(result);
                  $('#cartcnt1').text(result);
                  $('#cartcntt').text(result);
                  $('#cartcntt1').text(result);
                  $('#cartct1').text(result);
                  $('#cartct2').text(result);

                });
}

function Search()

            {
                	var prod=$('input#searchInput').val();
               

                
                 $.post("/get-prod", {prod:prod,_token: "{{ csrf_token() }}"}, function(result) {

                  $('#Searchsec').html(result);
                  
             });
             } 

             function Search1()

            {
                	var prod=$('input#searchInput1').val();
               

                
                 $.post("/get-prod", {prod:prod,_token: "{{ csrf_token() }}"}, function(result) {

                 
                  $('#Searchsec1').html(result);
             });
             }


</script>