@extends('layouts.Frontend')
@section('title')
 products
  @endsection 
 
@section('contentss')
	<section class="product-single mt-4">
		<div class = "card-wrapper container-main mt-4">
				<div class = "card" style="border: none !important;">
					<!-- card left -->
					<div class = "product-imgs">
						<div class="img-display">
							<div class="img-showcase" style="cursor:zoom-in;">
									<img class="large-image" src="{{url($prod->image)}}" alt="product-slider-image">
									@if($prod->image2!='')
									<img class="large-image" src="{{url($prod->image2)}}" alt="product-slider-image">
									@endif
									@if($prod->image3!='')
									<img class="large-image" src="{{url($prod->image3)}}" alt="product-slider-image">
									@endif
									@if($prod->image4!='')
									<img class="large-image" src="{{url($prod->image4)}}" alt="product-slider-image">
									@endif
							</div>
					</div>
						<div class="zoomed-view-container">
							<div id="zoomed-view"></div>
					</div>
						<div class = "img-select">
							<div class = "img-item">
								<a href = "#" data-id = "1">
									<img id="main-image"  style="height: 100%;" src = "{{url($prod->image)}}" alt = "product-slider-image">
								</a>
							</div>
							@if($prod->image2!='')
							<div class = "img-item">
								<a href = "#" data-id = "2">
									<img id="main-image" style="height: 100%;" src = "{{url($prod->image2)}}" alt = "product-slider-image">
								</a>
							</div>
							@endif
							@if($prod->image3!='')
							<div class = "img-item">
								<a href = "#" data-id = "3">
									<img style="height: 100%;" src = "{{url($prod->image3)}}" alt ="product-slider-image">
								</a>
							</div>
							@endif
							@if($prod->image4!='')
							<div class = "img-item">
								<a href = "#" data-id = "4">
									<img style="height: 100%;" src = "{{url($prod->image4)}}" alt = "product-slider-image">
								</a>
							</div>
							@endif
							
						</div>
					</div>
					<div class="product-deatils-single">
						<h2 class="mt-3 product-single-page-name">{{$prod->name}}</h2>
						<h5 class="product-sub-name-single-page">Be the first to review this product</h5>
						@if($prod->status=='Available')
						<h5 class="cart-stock-status mt-3 mb-3">{{$prod->status}}</h5>
						@else
						<h5 class="cart-stock-status mt-3 mb-3" style="color:red;">{{$prod->status}}</h5>
						@endif
							
						<div class="product-reviews">
             <!--  <img class="star" src="{{asset('/frontend/images/star.png')}}" alt=""> 
              <h5 class="product-reviews-text">4.0 |</h5> 
              <img class="blue-tick" src="{{asset('/frontend/images/blue-tick.png')}}" alt="">
              <h5 class="product-reviews-text">12 Reviews</h5> -->
            </div>
						<h4 class="tax-text">Inclusive of all Taxes</h4>
						<!-- <div class="product-rate-details mt-3">
							<h5 class="price-details-main-text">Price Per Piece or Box:</h5>
							<h5 class="product-price-single-pg">12,950</h5>
						</div> -->
						<div class="product-rate-details">
							<h5 class="price-details-main-text">Price:</h5>
							<h5 style="text-decoration: line-through;color: grey;" class="product-price-single-pg">₹{{$prod->price}}</h5>
						</div>
						<!-- <div class="product-rate-details">
							<h5 class="price-details-main-text">Discount</h5>
							<h5 class="product-price-single-pg">12%</h5>
						</div> -->
						<div class="product-rate-details">
							<h5 class="price-details-main-text">Discount Price:</h5>
							<h5 class="product-price-single-pg">₹{{$prod->offerprice}}</h5>
						</div>
						<h6 class="product-summary-single">{{$prod->desc}}</h6>
						<div class="person-bar-wrap">
							<div class="person-count">
								<div  class="hidden-filter">
									<p class="quantity-main-text">Quantity</p>
									<div style="display: flex;" class="hidden-filter-context">
										<span style="margin-right: -6px;z-index: 15;" class="minus-adult minus" onclick="MinusCount()">-</span>
										<input class="counter" type="text" name="limit" id="limit" value="1">
										<span style="margin-left: -8px;z-index: 15;" class="plus-adult plus" onclick="PlusCount()">+</span>
									</div>
								</div>
							</div>
						</div><br>
						<!-- <a href="profile.html" class="btn labham-primary-bg text-white add-to-cart-btn-single">Buy Now</a> -->
						
						@if($prod->status=='Available')

						<br>
						<button onclick="AddCart()" id="ct1" class="btn labham-primary-bg text-white add-to-cart-btn-single">Add to cart</button>
						<button onclick="window.location.href='/mycart'" id="ct2" class="btn labham-primary-bg text-white add-to-cart-btn-single">Visit cart</button>

					



						@else
						<!-- <button style="cursor: pointer;" onclick="AddCart()" class="btn labham-primary-bg text-white add-to-cart-btn-single">Not</button> -->
						@endif
						
					
					</div>
				</div>
		</div>

		<!-- gallery section  -->
		@if(SizeOf($gal))
	<div class="container-main category-section">
		<div class="row">
			<div class="col-lg-12">
				<div class="top-categories">
					<h3 class="heading-category"> <span style="font-size: unset;">Gallery</span></h3>
				</div>
				<hr style="margin-top: 0px !important;margin-bottom: 25px !important;">
			</div>

			@foreach($gal as $g)
			<div class="col-lg-3 col-md-2 col-sm-3 col-4 mb-3">
				<div class="category-product">
					<a href="">
						<img class="product-image-category" src="{{url($g->image)}}" alt="product">
					</a>
				</div>
			</div>
			@endforeach	
		</div>
	</div>
	@endif
	<!-- vedio section  -->
		@if(SizeOf($vid))
	<div class="container-main category-section mb-4">
		<div class="row">
			<div class="col-lg-12">
				<div class="top-categories">
					<h3 class="heading-category"> <span style="font-size: unset;">Videos</span></h3>
				</div>
				<hr style="margin-top: 0px !important;margin-bottom: 25px !important;">
			</div>

@foreach($vid as $v)
			<div class="col-lg-3 col-md-2 col-sm-3 col-4 mb-3">
				<div class="category-product">
					@php
					print_r($v->url);
					@endphp
				</div>
			</div>
			@endforeach
		
		</div>
	</div>
	</section>
	@endif
	<!-- sidebar end  -->
	<!-- <div class="container-main mt-4">
		<h2 class="product-detail-heading mb-3">Product Details</h2>
		<div class="product-all-details">
			<h4 class="product-det-sub-main-head">Product information:</h4>
			<h6 class="sub-head-product-details">Honey Onyx 1" Rhomboid comes on meshed backing for easy installation. This dynamic yellow, brown and cream tiles are exquisite and unique and ideal for walls applications including kitchen backsplashes and bathroom surrounds.</h6>
			<h4 class="product-det-sub-main-head">Detailed Specifications:</h4>
			<h6 class="sub-head-product-details">This Product have high quality and high secured.</h6>
			<h4 class="product-det-sub-main-head">Color:</h4>
			<h6 class="sub-head-product-details">Red</h6>
			<h4 class="product-det-sub-main-head">Size:</h4>
			<h6 class="sub-head-product-details">XXL</h6>
		</div>
	</div> -->
	<div class="container-main category-section">
		<div class="row">
			<div class="col-lg-12">
				<div class="top-categories">
					<h3 class="heading-category">Related Products</h3>
					<!-- <a href="#" class="view-all-home">View All <img src="./images/arrow-home.png" alt="arrow"></a> -->
				</div>
				<hr style="margin-top: 0px !important;margin-bottom: 25px !important;">
			</div>

			@foreach($relprod as $rl)
      	<div class="col-lg-3 col-md-4 col-12">
				<div class="populer-product">
					<a href="/v1/productsingle/{{encrypt($rl->id)}}">
						<img class="populer-product-image" src="{{url($rl->image)}}" alt="populer-product">
						<div class="product-details">
							<h4 class="product-name">{{$rl->name}}</h4>
							<!-- <h4 class="product-name">52% OFF</h4> -->
							<div class="product-sub-details">
								<h5 class="product-size" style="text-decoration: line-through">Price : ₹{{$rl->price}}</h5>
								<h5 class="product-rate" style="float:right;">Offer Price : ₹{{$rl->offerprice}}</h5>
							</div>
							<a style="cursor:pointer;" onclick="AddToCart('{{$rl->id}}')" class="btn labham-primary-bg add-to-cart-btn">ADD TO CART</a>
						</div>
					</a>
				</div>
			</div>
			@endforeach
     
     
      
    
		</div>
	</div>

	<!-- js link -->

	<script>


		function MinusCount()
		{
			var cnt=$('input#limit').val();
			if(cnt>1)
			{
			var newcnt=parseInt(cnt)-1;

			$('#limit').val(newcnt);
				}

		}

		function PlusCount()
		{
			var cnt=$('input#limit').val();
			var newcnt=parseInt(cnt)+1;

			$('#limit').val(newcnt);
		}



		function AddCart()
{

	qty=$('input#limit').val();

   $.ajax({
     type: "POST",
     url: "/add-cart",
     data: {
        "_token": "{{ csrf_token() }}",
        "pid": '{{$prod->id}}',
        "qty": qty,
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
						  	$('#ct1').hide();
						  	$('#ct2').show();
						 
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




		// script.js
		const largeImages = document.querySelectorAll('.large-image');
    const zoomedView = document.getElementById('zoomed-view');

   largeImages.forEach((image) => {
    image.addEventListener('mousemove', (event) => {
        const { left, top, width, height } = image.getBoundingClientRect();
        const x = (event.clientX - left) / width;
        const y = (event.clientY - top) / height;

        zoomedView.style.backgroundImage = `url('${image.src}')`;
        zoomedView.style.backgroundPosition = `${x * 100}% ${y * 100}%`;

        // Apply styles to modify zoomed-in view appearance

        zoomedView.style.zIndex = '9999 !important';  // Set a higher z-index
        zoomedView.style.width = '500px';  // Increase width
        zoomedView.style.height = '538px';
        zoomedView.style.border = '1px solid #CCC';
    });

    image.addEventListener('mouseout', () => {
        zoomedView.style.backgroundImage = 'none';
        zoomedView.style.zIndex = '-1';  // Reset z-index
        zoomedView.style.width = '0';    // Reset width
        zoomedView.style.height = '0';   // Reset height
    });
});


		const imgs = document.querySelectorAll('.img-select a');
			const imgBtns = [...imgs];
			let imgId = 1;

			imgBtns.forEach((imgItem) => {
					imgItem.addEventListener('click', (event) => {
							event.preventDefault();
							imgId = imgItem.dataset.id;
							slideImage();
					});
			});

			function slideImage(){
					const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

					document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
			}

			window.addEventListener('resize', slideImage);
		</script>

			@endsection

