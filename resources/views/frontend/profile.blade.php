@extends('layouts.Frontend')
@section('title')
 products
  @endsection 
 
@section('contentss')
<style type="text/css">
	.image-container {
    display: inline-block;
    text-align: center;
    margin: 10px;
}

.image-name {
    font-size: 14px;
    margin-top: 5px;
}

</style>
	<!-- sidebar end  -->
	<div  class="box-list container-main">
		<div class="row">
			<div class="col-lg-3 col-xs-12 sidebar-menu-ecmrc">
				<div class="order-list">
					<ul>
							<li  class="selectedLink curentstage" name="about" id="l2" onclick="GetA2()"><img class="icon-img-profile" style="width: 35px !important;" src="{{asset('/frontend/images/cart.png')}}" alt="" > Your Orders</li>

						<li id="l1"  onclick="GetA1()" name="home"><img class="icon-img-profile" style="width: 35px !important;" src="{{asset('/frontend/images/userr.png')}}" alt=""> Profile</li>
						

							<li name="resume" id="l3" onclick="GetA3()"><img class="icon-img-profile" style="width: 35px !important;" src="{{asset('/frontend/images/profile.png')}}" alt="" > Address Book</li>
							<li name="contact"><a style="color:#A0A0A0;cursor: pointer;" onclick="Logout()"><img class="icon-img-profile" style="width: 35px !important;" src="{{asset('/frontend/images/Vector (4).png')}}" alt=""> Logout</a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-9 col-xs-12 lft-page-menu">
				<div style="margin-left: 50px;border: none;" class="card profail-select-bar" id="a1">
					<div class="profail-adrss">
						<div class="profile-sub-div align-items-center">
							<div class="col-profail">
								
								<input type="text" name="name" id="name" class="profaile-items" value="{{auth()->guard('member')->user()->name}}" placeholder="Name">
								<input type="number" name="mobile" id="mobile" class="profaile-items" value="{{auth()->guard('member')->user()->phone}}" placeholder="Mobile number">
								<input type="text" name="mail" id="mail" class="profaile-items" value="{{auth()->guard('member')->user()->email}}" placeholder="Mail Id">

							

							</div>
							<div class="col-lg-12">
				<button type="button" class="labham-primary-bg btn btn-add-address text-white" onclick="EditProfile()">Update</button>
			</div>
						</div> 
					</div>
				</div>
				<div style="margin-left: 50px;border: none;" class="card active profail-select-bar" id="a2">


@foreach($orders as $o)

					@php
					$odet=DB::table('ordered_items')->where('orderid',$o->id)->get();
					 $rimage=DB::table('return_images')->where('orderid',$o->id)->get();
					@endphp
					<div class="order-lists">
						<div class="top-border">
							<div class="top-border-lft">
								<h6>Order ID : #{{$o->id}}</h6>
							</div>
							<div style="display: flex;" class="top-border-rgt">
								@if($o->status=='New')
								<a style="color: #D22020;padding-right: 15px;cursor: pointer;" class="labham-primary-bg btn btn-add-address text-white"  onclick="CancelOrder('{{$o->id}}')">Cancel Order</a>
								@endif
								<!-- <a style="color: #2E6414;padding-right: 20px;padding-left: 10px;" href="#">Track Order</a> -->
							</div>
						</div>


						@foreach($odet as $od)
							@php
					$pdet=DB::table('products')->where('id',$od->productid)->first();
					@endphp
						<div style="width: 100%;padding: 10px 20px;" class="ordermain-div">
							<div class="lft-col-order">
								<div class="order-product">
									<img src="{{url($pdet->image)}}" alt="">
								</div>
								<div class="col-profail">
										<p class="productnamebar">{{$pdet->name}} * {{$od->quantity}}</p>
										<p class="productsizebar">₹{{$od->amount}}</p>
										<p class="productsizebar">{{$pdet->desc}}</p>
										@if($o->status=='Delivered')
						<p class="productsizebar">Delivered On : {{ \Carbon\Carbon::parse($o->delivered_on)->format('d-M-Y') }}</p>
						@php
						$daysToAdd=5;
						$newDate = date("Y-m-d", strtotime($o->delivered_on . " + $daysToAdd days"));
						$todaydt=date('Y-m-d');
						@endphp

							@if($o->status=='Delivered' && $todaydt>$newDate && $o->return_status=='Pending')
						<p class="productsizebar">Return Status : Expired</p>
						@else
						<p class="productsizebar">Return Status : {{$o->return_status}}</p>
						@endif
						@endif
					
								</div>

							</div>
							<div class="prodect-status">
								@if($o->status=='Cancelled' || $o->status=='Rejected' || $o->status=='Returned')
								<h6 class="order-status-cancelled">{{$o->status}}</h6>
								@else
								<h6 class="order-status-deliverd">{{$o->status}}</h6>
								@endif
							</div>

							
						</div>
						

						@endforeach
						
						@if($o->status=='Delivered' && $todaydt<=$newDate && $o->return_status=='Pending')
						
						<hr>
						<center>
						<div>
								<textarea class="form-control" rows="3" cols="3" style="width: 80%;" placeholder="Reason for return" id="retdet"></textarea>
							</div>
						<br>
					
						<input type="file" class="labham-primary-bg btn btn-add-address text-white" name="pdf_file{{$o->id}}" id="pdf_file{{$o->id}}" onchange="Chkformat('{{$o->id}}')">
						<a style="cursor:pointer;" onclick="ReturnOrder('{{$o->id}}')" class="labham-primary-bg btn btn-add-address text-white">Return</a>
						</center>
						<br><br>
						@endif
						<div class="order-product">
							<hr>
							@foreach($rimage as $rm)
							
    <div class="image-container">
        <img src="{{url($rm->image)}}" alt="" style="width: 100px; height: 100px;">
        @if($o->return_status=='Pending')
        <p class="image-name" style="color:red;cursor: pointer;" onclick="DeleteImg('{{$rm->id}}')">delete</p>
        @endif
    </div>
    @endforeach
    
</div>

						
					</div>


						@endforeach



					



					
				</div>
				<div style="margin-left: 50px;border: none;"  class="card resume profail-select-bar" id="a3">
					<div class="edit-address">
					<a href="/addaddress" style="float:right;"><i class="fa fa-plus-circle"></i> Add address</a>
				</div><br><br>


					@foreach($add as $a)
						<div  class="adresses">
							<div class="address-sub-div">
								<div style="margin-right: 30px;" class="leftadrss">
									<form action="">
									
											<input type="radio" onclick="ChangeDefault('{{$a->id}}')" id="def{{$a->id}}" name="def{{$a->id}}" value="1" @if($a->default=='1') checked @endif>
												
									</form>
							</div>
							<div class="cntr-adrss">
									<h4 class="name-user-profile">{{$a->name}}</h4>
									<h6 class="number-user-profile">{{$a->mobile}}</h6>
									<h6 class="address-user-profile">{{$a->address}}</h6>
									<h6 class="address-user-profile">{{$a->district}} , {{$a->state}}</h6>
									<h6 class="address-user-profile">Landmark: {{$a->landmark}}</h6>
									<h6 class="address-user-profile">Pin: {{$a->pincode}}</h6>
							</div>
							</div>
							<div class="edit-delete">
								<div class="edit-address">
									<a href="/editaddress/{{encrypt($a->id)}}"><i class="ri-pencil-line"></i> Edit</a>
								</div>
								<div class="edit-address-delete">
									<a style="cursor:pointer;" onclick="DeleteAddress('{{$a->id}}')"><i class="ri-delete-bin-line"></i> Delete</a>
								</div>
							</div>
						</div>

						@endforeach
						
						
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript">

function GetA1()
{
	$('#a1').show();
	$('#a2').hide();
	$('#a3').hide();
  $('#l2').removeClass('selectedLink curentstage');
  $('#l3').removeClass('selectedLink curentstage');
  $('#l1').addClass('selectedLink curentstage');
}

function GetA2()
{
	$('#a2').show();
	$('#a1').hide();
	$('#a3').hide();
	$('#l1').removeClass('selectedLink curentstage');
  $('#l3').removeClass('selectedLink curentstage');
  $('#l2').addClass('selectedLink curentstage');
}

function GetA3()
{
	$('#a3').show();
	$('#a2').hide();
	$('#a1').hide();
	$('#l1').removeClass('selectedLink curentstage');
  $('#l2').removeClass('selectedLink curentstage');
  $('#l3').addClass('selectedLink curentstage');
}

		
function EditProfile()
{

	 var name=$('input#name').val();
  if(name=='')
  {
    $('#name').focus();
    $('#name').css({'border':'2px solid red'});
    return false;
  }
  else
   $('#name').css({'border':'1px solid #CCC'});

  var mobile=$('input#mobile').val();
  if(mobile=='')
  {
    $('#mobile').focus();
    $('#mobile').css({'border':'2px solid red'});
    return false;
  }
  else
   $('#mobile').css({'border':'1px solid #CCC'});

   var mail=$('input#mail').val();


   $.ajax({
     type: "POST",
     url: "/edit-profile",
     data: {
        "_token": "{{ csrf_token() }}",
        "mobile": mobile,
        "name": name,
        "mail": mail,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          Toastify({
						  text: "Profile updated successfully",
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

						  	window.location.href=window.location.href;
						 
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

        else if(data['err1'])
        {
         Toastify({
						  text:"Mail id already exists",
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



function ChangeDefault(aid)
{

   $.ajax({
     type: "POST",
     url: "/def-address",
     data: {
        "_token": "{{ csrf_token() }}",
        "aid": aid,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          Toastify({
						  text: "Default address updated successfully",
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
     

       
     }
   });
   
}



function DeleteAddress(val)
    {
    
  
 swal({
  title: "Do you want to delete this address ?",
  //text: "Ensure that this student has a valid reason for a this action .",
  icon: "warning",
  buttons: ["No", "Yes"],
})

.then((willDelete) => {
  if (willDelete) {

  var body=val;




$.ajax({

              type:"POST",
              url:'/delete-address',
              data: {
        _token: @json(csrf_token()),
        body: body
       
        },
               
              dataType:"json",
              success:function(data)
                {
                  //$('.loader').hide();
                  //$('.overlay').hide();

                  if(data['success'])
                    {
                       swal({
                              title: "Address deleted successfully.",
                             // text: "This member moved and Password send to your Email",
                              icon: "success",
                              buttons: "Ok",
                               closeOnClickOutside: false
  
                            })

                      .then((willDelete) => {
                       if (willDelete) {
                             window.location.href=window.location.href;
                                  } 

                            });

                     
                    }
                  
                
            }
       })

 } 
  
});

} 


function Logout()
    {
    
  
 swal({
  title: "Do you want to logout ?",
  //text: "Ensure that this student has a valid reason for a this action .",
  icon: "warning",
  buttons: ["No", "Yes"],
})

.then((willDelete) => {
  if (willDelete) {

 window.location.href='/logout'


 } 
  
});

} 




function Chkformat(val) {
  var name = document.getElementById("pdf_file" + val).files[0].name;
  var ext = name.split('.').pop().toLowerCase();
  
  if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
    swal({
      title: "Invalid file format!",
      text: "Upload JPG/JPEG/PNG file",
      icon: "warning",
      buttons: "Ok"
    });
    $('#pdf_file' + val).val(""); // Clear the input field
    return false;
  }
  
  var f = document.getElementById("pdf_file" + val).files[0];
  var fsize = f.size || f.fileSize;
  
  if (fsize > 300000) {
    swal({
      title: "File size is too big!",
      text: "Maximum file size is 300kb.",
      icon: "warning",
      buttons: "Ok"
    });
    $('#pdf_file' + val).val(""); // Clear the input field
    return false;
  }
  
  var img = $('#pdf_file' + val)[0].files[0];
  
  // Create a FormData object to send image data to the server
  var form_data = new FormData();
  form_data.append('img', img);
  form_data.append('oid', val);
  form_data.append('_token', '{{ csrf_token() }}');
  
  $.ajax({
    type: "POST",
    url: '/return-img',
    data: form_data,
    dataType: "json",
    processData: false, // Prevent jQuery from processing data
    contentType: false, // Prevent jQuery from setting content type
    success: function (data) {
      if (data['success']) {
        swal({
          title: "Image uploaded successfully.",
          icon: "success",
          buttons: "Ok",
          closeOnClickOutside: false
        }).then((willDelete) => {
          if (willDelete) {
            window.location.href = window.location.href;
          }
        });
      }
    }
  });
}


function DeleteImg(aid)
{

   $.ajax({
     type: "POST",
     url: "/del-image",
     data: {
        "_token": "{{ csrf_token() }}",
        "aid": aid,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          

						  	window.location.href=window.location.href;
						 
						 
        }
     

       
     }
   });
   
}

function ReturnOrder(aid)
{

	var retdet=$('#retdet').val();
  if(retdet=='')
  {
    $('#retdet').focus();
    $('#retdet').css({'border':'2px solid red'});
    return false;
  }
  else
   $('#retdet').css({'border':'1px solid #CCC'});

   $.ajax({
     type: "POST",
     url: "/return-order",
     data: {
        "_token": "{{ csrf_token() }}",
        "aid": aid,
        "retdet": retdet,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          

					swal({
          title: "Order returned successfully.",
          icon: "success",
          buttons: "Ok",
          closeOnClickOutside: false
        }).then((willDelete) => {
          if (willDelete) {
            window.location.href = window.location.href;
          }
        });
						 
						 
        }
     

       
     }
   });
   
}


function CancelOrder(val)
{

	swal({
  title: "Do you want to cancel this order ?",
  //text: "Ensure that this student has a valid reason for a this action .",
  icon: "warning",
  buttons: ["No", "Yes"],
})

.then((willDelete) => {
  if (willDelete) {

  var body=val;




$.ajax({

              type:"POST",
              url:'/cancel-order',
              data: {
        _token: @json(csrf_token()),
        body: body
       
        },
               
              dataType:"json",
              success:function(data)
                {
                  //$('.loader').hide();
                  //$('.overlay').hide();

                  if(data['success'])
                    {
                       swal({
                              title: "Order cancelled successfully.",
                             // text: "This member moved and Password send to your Email",
                              icon: "success",
                              buttons: "Ok",
                               closeOnClickOutside: false
  
                            })

                      .then((willDelete) => {
                       if (willDelete) {
                             window.location.href=window.location.href;
                                  } 

                            });

                     
                    }
                  
                
            }
       })

 } 
  
});

   
}









	</script>







@endsection