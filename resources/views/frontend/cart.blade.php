@extends('layouts.Frontend')
@section('title')
 products
  @endsection 
 
@section('contentss')


	<!-- sidebar end  -->
	<!-- navbar end -->
	<div class="cart container-main">
		<h1 class="cart-main-head text-center"><span class="labham-primary-color" style="font-size: unset !important;">My</span> Cart</h1>
		<div class="cart-main-div">
			<h2 class="cart-main-text">Shopping cart</h2>
			<small>deselect all the items</small>
			<hr>
			<div class="row">

				@php
				$itm=0;
				$tot=0;
				@endphp
				@foreach($cart as $c)
				<div class="col-lg-2 col-md-3 col-sm-6">
					<div class="inner-col-cart-img">
						<img class="cart-prdct-image" src="{{url($c->GetProd->image)}}" alt="cart-image">
					</div>
				</div>
				<div class="col-lg-10 col-md-9 col-sm-6">
					<div class="inner-col-cart-img">
						<h3 class="cart-product-name">{{$c->GetProd->name}}</h3>
						<!-- <h6 class="cart-no-stock-status">No stock</h6>		 -->
						<p class="cart-product-details">{{$c->GetProd->desc}}</p>
						<h4 class="cart-product-rate">Price : <span class="cart-rate" style="font-size: unset !important;"></span>  ₹{{$c->GetProd->offerprice}} * {{$c->quantity}}</h4>
						<h4 class="cart-product-rate">Save : <span class="cart-rate" style="font-size: unset !important;"></span>  ₹{{($c->GetProd->price * $c->quantity)-($c->GetProd->offerprice * $c->quantity)}}</h4>
						<h4 class="cart-product-rate">Total Price : <span class="cart-rate" style="font-size: unset !important;"></span>  ₹{{$c->GetProd->offerprice * $c->quantity}} </h4>
						<div class="person-bar-wrap">
							<div class="person-count">
								<div  class="hidden-filter">
									<p class="quantity-main-text">Quantity</p>
									<div style="display: flex;" class="hidden-filter-context">
										<span onclick="MinusCart('{{$c->id}}')" style="margin-right: -6px;z-index: 15;" class="minus-adult minus">-</span >
										<input class="counter " type="number" name="limit{{$c->id}}" id="limit{{$c->id}}" value="{{$c->quantity}}">
										<span onclick="PlusCart('{{$c->id}}')" style="margin-left: -8px;z-index: 15;" class="plus-adult plus">+</span>
									</div>
								</div>
							</div>
							<img class="close-cart" src="{{asset('frontend/images/close-circle-line.png')}}" alt="" style="cursor:pointer;" onclick="Delete('{{$c->id}}')">
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<hr>
				</div>
				@php
				$itm=$itm+$c->quantity;
				$tot=$tot+($c->GetProd->offerprice*$c->quantity);
				@endphp
				@endforeach


				
				
				
			</div>
			
			<div class="total-price-cart">
				<h5 class="subtotal-cart-product text-right pb-2">Subtotal ({{$itm}} items): {{$tot}}</h5> 
				@if($itm>0)
				<a href="/checkout" class="btn labham-primary-bg text-white proceed-btn-cart">Proceed to Buy</a>
				@else
				<a href="" class="btn labham-primary-bg text-white proceed-btn-cart" style="background-color: grey !important;">Proceed to Buy</a>
				@endif
			</div>
		</div>
	</div>


<script type="text/javascript">


	function PlusCart(val)
{

	var qty=$('input#limit'+val).val();

   $.ajax({
     type: "POST",
     url: "/plus-cart",
     data: {
        "_token": "{{ csrf_token() }}",
        "cid": val,
        "qty": qty,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          Toastify({
						  text: "Cart updated successfully",
						  duration: 1000,
						  newWindow: true,
						  // close: true,
						  gravity: "top", // `top` or `bottom`
						  position: "right", // `left`, `center` or `right`
						  stopOnFocus: true, // Prevents dismissing of toast on hover
						  style: {
						    background: "linear-gradient(to right, green, green)",
						  },
						  callback: function () {

						  	window.location.href=window.location.href;
						 
						  },
						}).showToast();
             
        }
      else if(data['err'])
        {
         
        }

        
       
     }
   });
   
}


	function MinusCart(val)
{

	var qty=$('input#limit'+val).val()

	if(qty>1)
	{

   $.ajax({
     type: "POST",
     url: "/minus-cart",
     data: {
        "_token": "{{ csrf_token() }}",
        "cid": val,
        "qty": qty,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          Toastify({
						  text: "Cart updated successfully",
						  duration: 1000,
						  newWindow: true,
						  // close: true,
						  gravity: "top", // `top` or `bottom`
						  position: "right", // `left`, `center` or `right`
						  stopOnFocus: true, // Prevents dismissing of toast on hover
						  style: {
						    background: "linear-gradient(to right, green, green)",
						  },
						  callback: function () {

						  	window.location.href=window.location.href;
						 
						  },
						}).showToast();
             
        }
      else if(data['err'])
        {
         
        }

        
       
     }
   });
   
}
}

	
	function Delete(val)
{


   $.ajax({
     type: "POST",
     url: "/delete-cart",
     data: {
        "_token": "{{ csrf_token() }}",
        "cid": val,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          Toastify({
						  text: "Cart updated successfully",
						  duration: 1000,
						  newWindow: true,
						  // close: true,
						  gravity: "top", // `top` or `bottom`
						  position: "right", // `left`, `center` or `right`
						  stopOnFocus: true, // Prevents dismissing of toast on hover
						  style: {
						    background: "linear-gradient(to right, green, green)",
						  },
						  callback: function () {

						  	window.location.href=window.location.href;
						 
						  },
						}).showToast();
             
        }
      else if(data['err'])
        {
         
        }

        
       
     }
   });
   
}


</script>








@endsection