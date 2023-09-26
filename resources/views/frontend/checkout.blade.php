@extends('layouts.Frontend')
@section('title')
 products
  @endsection 
 
@section('contentss')

<style type="text/css">
  .place-orderpage {
  background-color: #f5f5f5;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.orderr {
  font-size: 24px;
  font-weight: bold;
  color: #333;
  margin-bottom: 20px;
}

.product-list {
  border-top: 1px solid #ddd;
  margin-top: 10px;
  padding-top: 10px;
}

.heading-product-list {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.product-name {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.sub-total-price {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  margin-top: 10px;
  margin-bottom: 10px;
}

.grnn {
  color: green;
}

.product-list-two {
  margin-top: 20px;
}

input[type="radio"] {
  margin-right: 10px;
  transform: translateY(2px);
}

label {
  font-size: 14px;
  color: #333;
  cursor: pointer;
}

#cashdiv {
  margin-top: 10px;
}

#refid {
  width: 100%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 10px;
}

#note {
  width: 100%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.proceed-btn-cart {
 
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.proceed-btn-cart:hover {
  background-color: #444;
}
.adresses {
  display: flex;
  align-items: center;
  background-color: #fff;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-bottom: 10px;
  transition: border-color 0.3s;
}

.adresses:hover {
  border-color: #999;
}

.leftadrss {
  flex: 0 0 auto;
  margin-right: 10px;
}

input[type="radio"] {
  margin: 0;
  vertical-align: middle;
}

.cntr-adrss {
  flex: 1 1 auto;
}

h6 {
  margin: 0;
  font-size: 14px;
  color: #333;
  line-height: 1.8; /* Increased line height for better readability */
}

.rgt-adrss {
  flex: 0 0 auto;
}
.bank-card {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    max-width: 600px; /* Set your desired maximum width */
    margin: 0 auto; /* Center the card horizontally */
}


</style>


	<section class="address">
  <div class="container-main">
    <div class="row">




      <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-4">
         
        <h4 style="font-weight: 600;color:  #464646;">Your Addresses</h4>
        @foreach($addresses as $address)
        <div class="adresses">
          <div class="leftadrss">
          <input type="radio" id="{{$address->id}}" id="address" name="address" value="{{$address->id}}" @if($address->default==1) checked @endif>
          </div>
          <div class="cntr-adrss">
            <label for="{{$address->id}}">
              <h6>{{$address->name}}</h6>
              <h6>{{$address->mobile}}</h6>
              <h6>{{$address->address}},{{$address->landmark}}, {{$address->district}}, {{$address->state}}, {{$address->pincode}}</h6>
            </label>
          </div>
          <div class="rgt-adrss">
          </div>
        </div>
        @endforeach
        <div style="float: left;" class="adrees-list">
          <button onclick="window.location.href='/addaddress'" class="btn labham-primary-bg text-white proceed-btn-cart">Add address</button>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-4  place-orderpage">
        <h3 class="orderr">Your Order</h3>
        <?php
        $ordertotal = 0;
        $discount   = 0;
		  	$total=0;
		$shipping_charge = 45;
        ?>
        <div class="product-list">
          <div class="heading-product-list product-subtotal">
            <h5>Products</h5>
            <h5>Sub Total</h5>
          </div>
          <hr>
         
          @foreach($cart as $key => $value)
          
          
          <div class="product-name">
            <div class="product-name-lft">

              <p>  <img src="{{url($value->GetProd->image)}}" style="width:50px;border-radius: 10px;"> {{$value->GetProd->name}} <i class="fa fa-times" aria-hidden="true" style="font-size:9px;"></i> {{$value->quantity}}</p>
            </div>
            <div class="product-price-rgt">
              <h5 class="product-size" style="text-decoration: line-through">₹{{$value->GetProd->price*$value->quantity}}</h5>
                <h5 class="product-rate" style="float:right;">₹{{$value->GetProd->offerprice*$value->quantity}}</h5>
              
            </div>
          </div>
          <hr>

          <?php
        $ordertotal = $ordertotal+($value->GetProd->price*$value->quantity);
      
		  	$total=$total+($value->GetProd->offerprice*$value->quantity);
				$shipping_charge = 45;
        ?>
          @endforeach
          
          <div class="sub-total-price">
            <h6>Order Total</h6>
            <h6 class="">₹{{$ordertotal}}</h6>
          </div>
          <!-- <div class="sub-total-price">
            <h6>Shipping</h6>
			  <h6 class="">₹ 45</h6>
          </div> -->
          <div class="sub-total-price">
            <h6>Discounts</h6>
            <h6 class="">₹ {{$ordertotal-$total}}</h6>
          </div>
          <div class="sub-total-price">
            <h5>Subtotal</h5>
            <h5 class="grnn">₹{{$total}}</h5>
          </div>
        </div>
      
        <div class="product-list-two">
              <form action="">
              <input style="width: 15px;height: 15px;" type="radio" id="codorder" name="paymenttype" value="COD" onclick="myFunction()" checked>
              <label for="codorder">Cash on delivery</label><br>
               
                <input style="width: 15px;height: 15px;" type="radio" id="codorder" name="paymenttype" value="Bank Transfer" onclick="myFunctioncredit()">
                <label for="onlineorder"> Bank Transfer</label><br>

                <div id="cashdiv">
                  
                  <div class="bank-card">
    <h6>Bank: {{$bank->bank}}</h6>
    <h6>Beneficiary: {{$bank->name}}</h6>
    <h6>Account Number: {{$bank->account_num}}</h6>
    <h6>IFSC Code: {{$bank->ifsc_code}}</h6>
</div><br>

   
                	<input type="text" name="refid" id="refid" class="form-control" placeholder="Reference Id"><br>
                	<textarea class="form-control" id="note" cols="3" rows="3" style="border:1px solid grey !important;" placeholder="Notes (If any)"></textarea>
                </div>
                  
              </form>
              <hr>
              <!-- <p style="text-align: center;">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a class="grnn" href="{{url('/privacy-policy')}}">privacy policy.</a></p> -->
              <button onclick="placeOrder()" id="ab1" class="btn labham-primary-bg text-white proceed-btn-cart">Place Order</button>
              <button id="ab2" class="btn labham-primary-bg text-white proceed-btn-cart"><i class="fa fa-spinner fa-spin"></i>  Place Order</button>
              <br><br>
        </div>
      </div>
    </div>
  </div>
</section><br><br>


<script type="text/javascript">
	
function myFunction()
{
	$('#cashdiv').hide();
}
function myFunctioncredit()
{
	$('#cashdiv').show();
}


function placeOrder()
{

	var address=$('input[name="address"]:checked').val();
	var paytype=$('input[name="paymenttype"]:checked').val();

	var note=$('#note').val();
	if(paytype=='Bank Transfer')
	{
		var refid=$('input#refid').val();
    
      if(refid=='')
      {
        $('#refid').css('border','1px solid red');
        
        return false;
      }
      else
        $('#refid').css('border','1px solid #CCC');
	}
	else
	{
		var refid='0';
	}

$('#ab2').show();
$('#ab1').hide();

   $.ajax({
     type: "POST",
     url: "/placeorder",
     data: {
        "_token": "{{ csrf_token() }}",
        "address": address,
        "paytype": paytype,
        "refid": refid,
        "note": note,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          // $('#ab1').show();
          // $('#ab2').hide();
          Toastify({
						  text: "Order placed successfully",
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

						  	window.location.href='/';
						 
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