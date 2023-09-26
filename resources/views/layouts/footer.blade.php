<section class="section-padding bg-white border-top d-none d-xl-block d-lg-block">
  <div class="container">
    <div class="row">
      <div class="col-lg-4 col-sm-6">
        <div class="feature-box">
          <i class="mdi mdi-truck-fast"></i>
          <h6>Free & Next Day Delivery</h6>
          <p>Lorem ipsum dolor sit amet, cons...</p>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6">
        <div class="feature-box">
          <i class="mdi mdi-basket"></i>
          <h6>100% Satisfaction Guarantee</h6>
          <p>Rorem Ipsum Dolor sit amet, cons...</p>
        </div>
      </div>
      <div class="col-lg-4 col-sm-6">
        <div class="feature-box">
          <i class="mdi mdi-tag-heart"></i>
          <h6>Great Daily Deals Discount</h6>
          <p>Sorem Ipsum Dolor sit amet, Cons...</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding footer bg-gradient border-top d-none d-xl-block d-lg-block">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-3">
        <h4 class="mb-4 mt-1">
          <a class="logo" href="{{url('/')}}">
            <img src="{{url('/images/full-logo.png')}}" style="max-width: 80%;" alt="FahadBazar">
          </a>
        </h4>
        <p class="mb-0"><a class="text-white" href="#"><i class="mdi mdi-phone"></i> +91 6238 629 710</a></p>
        <!-- <p class="mb-0"><a class="text-white" href="#"><i class="mdi mdi-cellphone-iphone"></i> 12345 67890, 56847-98562</a></p> -->
        <p class="mb-0"><a class="text-danger" href="#"><i class="mdi mdi-email"></i> fahadbazar@gmail.com</a></p>
        <p class="mb-0"><a class="text-danger" href="https://fahadbazar.com/"><i class="mdi mdi-web"></i> fahadbazar.com</a></p>
      </div>
      <div class="col-lg-2 col-md-2">
        <h6 class="mb-4 text-white">TOP CITIES </h6>
        <ul>
          <li><a class="text-white" href="javascript:void(0);">Kozhikode</a></li>
          <li><a class="text-white" href="javascript:void(0);">Thrissur</a></li>
          <li><a class="text-white" href="javascript:void(0);">Ernakulam</a></li>
          <li><a class="text-white" href="javascript:void(0);">Kannur</a></li>
          <li><a class="text-white" href="javascript:void(0);">Alapuzhya</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-2">
        <h6 class="mb-4 text-white">CATEGORIES</h6>
        <ul>
          @foreach($categories as $key => $value)
            @if($key > 4) @break @endif
            <li>
              <a href="{{url('/products/'.$value->id)}}" class="text-white">{{$value->name}}</a>
            </li>
          @endforeach
        </ul>
      </div>
      <div class="col-lg-2 col-md-2">
        <h6 class="mb-4 text-white">ABOUT US</h6>
        <ul>
          <li><a class="text-white" href="{{url('/contactus')}}">Contact Us</a></li>
          <li><a class="text-white" href="{{url('/aboutus')}}">About Us</a></li>
          <li><a class="text-white" href="{{url('/terms')}}">Terms & Conditions</a></li>
          <li><a class="text-white" href="{{url('/privacy')}}">Privacy Policy</a></li>
          <li><a class="text-white" href="{{url('/return')}}">Return Policy</a></li>
			 <li><a class="text-white" href="{{url('/refund')}}">Refund Policy</a></li>
          <li><a class="text-white" href="{{url('/shipping')}}">Shipping Policy</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-3">
        <h6 class="mb-4 text-white">Download App</h6>
        <div class="app">
          <a href="#"><img src="{{url('/images/google.png')}}" alt=""></a>
          <a href="#"><img src="{{url('/images/apple.png')}}" alt=""></a>
        </div>
        <h6 class="mb-3 mt-4 text-white">GET IN TOUCH</h6>
        <div class="footer-social">
          <a class="btn-facebook" href="#"><i class="mdi mdi-facebook"></i></a>
          <a class="btn-twitter" href="#"><i class="mdi mdi-twitter"></i></a>
          <a class="btn-instagram" href="#"><i class="mdi mdi-instagram"></i></a>
          <a class="btn-whatsapp" href="#"><i class="mdi mdi-whatsapp"></i></a>
          <a class="btn-messenger" href="#"><i class="mdi mdi-facebook-messenger"></i></a>
          <a class="btn-google" href="#"><i class="mdi mdi-google"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="pt-4 pb-4 bg-vio footer-bottom d-none d-xl-block d-lg-block">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-lg-6 col-sm-6" style="vertical-align: middle;">
        <p class="mt-1 mb-0" style="color: white !important;">
          &copy; Copyright 2020<strong class="text-dark"><a href="{{url('/')}}"> VioSmart </a></strong>. All Rights Reserved<br>
        </p>
      </div>
      <div class="col-lg-6 col-sm-6 text-right">
        <img alt="osahan logo" src="{{url('/images/payment_methods.png')}}" style="max-height: 30px;">
      </div>
    </div>
  </div>
</section>

<div class="footer-fix-nav shadow">
  <div class="row mx-0">
    <div class="col">
      <a href="{{url('/')}}"><i class="fas fa-home"></i></a>
    </div>
    <div class="col border-0">
      <a href="{{url('/categories')}}"><i class="fas fa-th-large"></i></a>
    </div>

    <div class="col">
      <a href="{{url('/products')}}"><i class="fas fa-boxes"></i></a>
    </div>
    <div class="col">
      <a href="{{url('/profile')}}"><i class="fas fa-user"></i></a>
    </div>
  </div>
</div>

<nav id="main-nav">
  <ul class="first-nav">
    <li class="search" data-nav-custom-content>

    </li>
    @if(isset($userId) && $userId > 0)
      <li class="" >
        <a href="{{url('/profile')}}" class="pt-1 pb-1">
          <i class="fas fa-user" style="width:15px;"></i> &nbsp;<b style="font-size: 14px;">My Profile</b>
        </a>
      </li>
      <li class="" >
        <a href="{{url('/orders')}}" class="pt-1 pb-1">
          <i class="fas fa-envelope-open" style="width:15px;"></i> &nbsp;<b style="font-size: 14px;">My Orders</b>
        </a>
      </li>
      <li class="" >
        <a href="{{url('/address')}}" class="pt-1 pb-1">
          <i class="fas fa-map-marked-alt" style="width:15px;"></i> &nbsp;<b style="font-size: 14px;">My Address</b>
        </a>
      </li>
      <li class="" >
        <a href="{{url('/notifications')}}" class="pt-1 pb-1">
          <i class="fas fa-bell" style="width:15px;"></i> &nbsp;<b style="font-size: 14px;">Notifications</b>
        </a>
      </li>
      <li class="" >
        <a href="{{url('/logout')}}" class="pt-1 pb-1">
          <i class="fas fa-user-lock" style="width:15px;"></i> &nbsp;<b style="font-size: 14px;">Log Out</b>
        </a>
      </li>
    @else
      <li class="" >
        <a onclick="$('#bd-example-modal').modal('show');" class="pt-1 pb-1">
          <i class="fas fa-user" style="width:15px;"></i> &nbsp;<b style="font-size: 14px;">Login/Sign Up</b>
        </a>
      </li>
    @endif
  </ul>
  <ul class="second-nav">
    <li class="pt-2">
      <a class="pt-1 pb-1" href="{{url('/contactus')}}"> &nbsp; <b>Contact Us</b></a>
    </li>
    <li class="">
      <a class="pt-1 pb-1"  href="{{url('/aboutus')}}"> &nbsp; <b>About Us</b></a>
    </li>
    <li class="">
      <a class="pt-1 pb-1"  href="{{url('/terms')}}"> &nbsp; <b>Terms & Conditions</b></a>
    </li>
    <li class="">
      <a class="pt-1 pb-1"  href="{{url('/privacy')}}"> &nbsp; <b>Privacy Policy</b></a>
    </li>
    <li class="">
      <a class="pt-1 pb-1"  href="{{url('/return')}}"> &nbsp; <b>Return Policy</b></a>
    </li>
	    <li class="">
      <a class="pt-1 pb-1"  href="{{url('/refund')}}"> &nbsp; <b>Refund Policy</b></a>
    </li>
    <li class="">
      <a class="pt-1 pb-1"  href="{{url('/shipping')}}"> &nbsp; <b>Shipping Policy</b></a>
    </li>
  </ul>
</nav>






