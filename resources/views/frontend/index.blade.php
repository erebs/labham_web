
@extends('layouts.Frontend')
@section('title')
 home
  @endsection 
 
@section('contentss')


	<div class="container-main category-section">
		<div class="row">
			<div class="col-lg-12">
				<div class="top-categories">
					<h3 class="heading-category"> <span style="font-size: unset;"> Catagories</span></h3>
					<a href="/v1/product/categories" class="view-all-home">View All <img src="{{asset('/frontend/images/arrow-home.png')}}" alt="arrow"></a>
				</div>
				<hr style="margin-top: 0px !important;margin-bottom: 25px !important;">
			</div>

			@foreach($cat as $c)
			<div class="col-lg-3 col-md-2 col-sm-3 col-4" onclick="window.location.href='/v1/category-products/{{encrypt($c->id)}}'" style="cursor:pointer;">
				<div class="category-product">
					<a >
						<img class="product-image-category" src="{{url($c->image)}}" alt="product">
						<h4 class="text-center product-name">{{$c->name}}</h4>
					</a>
				</div>
			</div>
			@endforeach
			
			
			
			<div class="col-lg-12">
				<!-- <div class="top-categories">
					<h3 class="heading-category">Most popular</h3>
					<a href="#" class="view-all-home">View All <img src="{{asset('/frontend/images/Stroke-1.png')}}" alt="arrow"></a>
				</div> -->
				<hr style="margin-top: 0px !important;margin-bottom: 40px !important;">
			</div>
		</div>
		</div>
	<!-- sidebar end  -->
	<div class="container-main carousel-home-banner">
    <div id="carouselExampleIndicators" style="position: relative;" class="carousel slide slider-banner-home" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($banners as $index => $b)
            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($banners as $index => $b)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img class="d-block w-100" src="{{ asset($b->image) }}" alt="Slide {{ $index + 1 }}">
            </div>
            @endforeach
        </div>
    </div>
</div>

	<div class="container-main category-section">
		<div class="row">
			<div class="col-lg-12">
				<div class="top-categories">
					<h3 class="heading-category">Most popular</h3>
					<a href="/popular-products" class="view-all-home">View All <img src="{{asset('/frontend/images/Stroke-1.png')}}" alt="arrow"></a>
				</div>
				<hr style="margin-top: 0px !important;margin-bottom: 40px !important;">
			</div>
			@foreach($pop as $p)
      <div class="col-lg-3 col-md-4 col-12">
				<div class="populer-product">
					<a href="/v1/productsingle/{{encrypt($p->id)}}">
						<img class="populer-product-image" src="{{url($p->image)}}" alt="populer-product">
						<div class="product-details">
							<h4 class="product-name">{{$p->name}}</h4>
							<!-- <h4 class="product-name">Pr</h4> -->
							<div class="product-sub-details">
								<h5 class="product-size" style="text-decoration: line-through">Price : ₹{{$p->price}}</h5>
								<h5 class="product-rate" style="float:right;">Offer Price : ₹{{$p->offerprice}}</h5>
							</div>
							<a style="cursor:pointer;" onclick="AddToCart('{{$p->id}}')" class="btn labham-primary-bg add-to-cart-btn">ADD TO CART</a>
						</div>
					</a>
				</div>
			</div>
			@endforeach



			<div class="col-lg-12">
				<div class="top-categories">
					<h3 class="heading-category">Featured</h3>
					<a href="/featured-products" class="view-all-home">View All <img src="{{asset('/frontend/images/Stroke-1.png')}}" alt="arrow"></a>
				</div>
				<hr style="margin-top: 0px !important;margin-bottom: 40px !important;">
			</div>
			@foreach($featured as $f)
      <div class="col-lg-3 col-md-4 col-12">
				<div class="populer-product">
					<a href="/v1/productsingle/{{encrypt($f->id)}}">
						<img class="populer-product-image" src="{{url($f->image)}}" alt="populer-product">
						<div class="product-details">
							<h4 class="product-name">{{$f->name}}</h4>
							<!-- <h4 class="product-name">Pr</h4> -->
							<div class="product-sub-details">
								<h5 class="product-size" style="text-decoration: line-through">Price : ₹{{$f->price}}</h5>
								<h5 class="product-rate" style="float:right;">Offer Price : ₹{{$f->offerprice}}</h5>
							</div>
							<a style="cursor:pointer;" onclick="AddToCart('{{$f->id}}')" class="btn labham-primary-bg add-to-cart-btn">ADD TO CART</a>
						</div>
					</a>
				</div>
			</div>
			@endforeach


			<div class="col-lg-12">
				<div class="top-categories">
					<h3 class="heading-category">Trending</h3>
					<a href="/trending-products" class="view-all-home">View All <img src="{{asset('/frontend/images/Stroke-1.png')}}" alt="arrow"></a>
				</div>
				<hr style="margin-top: 0px !important;margin-bottom: 40px !important;">
			</div>
			@foreach($trending as $t)
      <div class="col-lg-3 col-md-4 col-12">
				<div class="populer-product">
					<a href="/v1/productsingle/{{encrypt($t->id)}}">
						<img class="populer-product-image" src="{{url($t->image)}}" alt="populer-product">
						<div class="product-details">
							<h4 class="product-name">{{$t->name}}</h4>
							<!-- <h4 class="product-name">Pr</h4> -->
							<div class="product-sub-details">
								<h5 class="product-size" style="text-decoration: line-through">Price : ₹{{$t->price}}</h5>
								<h5 class="product-rate" style="float:right;">Offer Price : ₹{{$t->offerprice}}</h5>
							</div>
							<a style="cursor:pointer;" onclick="AddToCart('{{$t->id}}')" class="btn labham-primary-bg add-to-cart-btn">ADD TO CART</a>
						</div>
					</a>
				</div>
			</div>
			@endforeach
     
     
    
      
      
		</div>
	</div>
	<!-- main brands slider  -->
	
	    <!-- customer-review section  -->
			


			<script type="text/javascript">
				
function AddToCart(pid)
{

   $.ajax({
     type: "POST",
     url: "/add-to-cart",
     data: {
        "_token": "{{ csrf_token() }}",
        "pid": pid,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          Toastify({
						  text: "Product added to cart",
						  duration: 2000,
						  newWindow: true,
						  // close: true,
						  gravity: "top", // `top` or `bottom`
						  position: "right", // `left`, `center` or `right`
						  stopOnFocus: true, // Prevents dismissing of toast on hover
						  style: {
						    background: "linear-gradient(to right, green, green)",
						  },
						  callback: function () {

						  	GetCartCount();
						 
						  },
						}).showToast();
             
        }
      else if(data['err'])
        {
         Toastify({
						  text: "Mobile number already exists",
						  duration: 2000,
						  newWindow: true,
						  // close: true,
						   gravity: "top", // `top` or `bottom`
						  position: "right", // `left`, `center` or `right
						  stopOnFocus: true, // Prevents dismissing of toast on hover
						  style: {
						    background: "linear-gradient(to right, red, red)",
						  },
						  callback: function () {
						 
						  },
						}).showToast();
        }

        
       
     }
   });
   
}



			</script>


			@endsection



	