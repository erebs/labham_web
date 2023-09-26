@extends('layouts.Frontend')
@section('title')
 products
  @endsection 
 
@section('contentss')
	<!-- sidebar end  -->
	<!-- navbar end -->
	@if($banners)
	<div class="banner-main container-main" style="background-image: url('{{ asset($banners->image) }}');background-repeat: no-repeat;background-size: 100% auto;padding: 9% 0 9% 0;background-position: center;background-repeat: no-repeat;background-size: cover;height: -webkit-fill-available;">
		<h1 class="text-center banner-main-head">Trending</h1>
	</div>
	@endif
	<div class="container-main banner-sub-head">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="text-center main-head-products">PRODUCTS</h1>
				<!-- <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled</p> -->
			</div>
		</div>
	</div>
	<!-- products  -->
	<div class="container-main category-section">
		<div class="row">

			@foreach($prod as $p)
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
    
     
     
    
      
		</div>
	</div>


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