@extends('layouts.Frontend')
@section('title')
 sign in
  @endsection 
 
@section('contentss')
	<!-- sidebar end  -->
	<!-- navbar end -->
	<div class="container-main signin">
		<form>
			<!-- Email input -->
			<h1 class="signin-main-text text-center pb-3">Register</h1>
			<div class="form-outline mb-2">
				<input type="text" id="name" name="name" placeholder="Name" class="form-control" />
				<label class="form-label" for="form2Example1"></label>
			</div>
			<!-- Password input -->
			<div class="form-outline mb-2">
				<input type="number" id="mobile" name="mobile" placeholder="Mobile number" class="form-control" />
				<label class="form-label" for="form2Example2"></label>
			</div>
			<div class="form-outline mb-4">
				<input type="password" id="pass" name="pass" placeholder="Create Password" class="form-control" />
			</div>
			<div class="form-outline mb-3">
				<input type="password" id="cpass" name="cpass" placeholder="Repeat Password" class="form-control" />
			</div>
			<!-- 2 column grid layout for inline styling -->
			<div class="row  read-agreeement">
				<div class="col d-flex justify-content-center">
					<!-- Checkbox -->
					<div class="form-check agree-dv">
						<input class="form-check-input" type="checkbox" value="" id="agchk" />
						<label class="form-check-label mb-2" for="form2Example34"><span class="labham-primary-color">I’ve read and agree to </span>Terms & Conditions </label>
					</div>
				</div>
			</div>
			

		<center>
        <div class="error" style="font-weight: bold;"></div>
        <div class="success" style="font-weight: bold;"></div>
        </center>
			<!-- Submit button -->
			<!-- <a href="index.html" class="btn labham-primary-bg btn-block mb-4 text-white login-btn-signup" data-target="#exampleModal11" href="exampleModal11" data-toggle="modal">Submit</a> -->

			<a class="btn labham-primary-bg btn-block mb-4 text-white login-btn-signup" style="cursor: pointer;" onclick="Register()">Submit</a>
		</form>
		<h4 class="text-center mb-4" >back to <a class="text-center" href="/signin"> Sign In</a></h4>
	</div>
	<div  class="modal fade"  tabindex="-1" role="dialog" id="exampleModal11"  aria-labelledby="exampleModalLabel11" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content model-sign-in-otp">
				<div class="modal-body modal-loginform-second">
					<div style="float: right;margin-top: 0px;display: table;margin-left: auto;" class=" clossse" class="close" data-dismiss="modal" aria-label="Close"><i style="font-size: 29px !important;" class="fa-regular fa-circle-xmark text-dark"></i></div>
					<h3 class="labham-primary-color" style="margin-top: 32px;">Verify your OTP</h3>
					<p>Sent to <span class="labham-primary-color">XXXXXXX70</span></p>
					<form action="" class="mt-5">
						<input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 >
						<input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 >
						<input class="otp" type="text" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 >
						<input class="otp" type="text" oninput='digitValidate(this)'onkeyup='tabChange(4)' maxlength=1 >
					</form>
					<h4 style="margin-top: 20px;" class="labham-primary-color">Resend Otp</h4>
					<a href="#" class="btn text-white labham-primary-bg login-btn-modal" data-target="#exampleModal12" href="exampleModal12" data-toggle="modal" data-dismiss="modal">Login</a>
					<h6 style="color: #7A7A7A;">DO NOT SHARE THIS OTP WITH ANYONE</h6>
				</div>
			</div>                                    
		</div>              
	</div>
	<div  class="modal fade"  tabindex="-1" role="dialog" id="exampleModal12"  aria-labelledby="exampleModalLabel12" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content model-sign-in-otp">
				<div class="modal-body modal-loginform-second">
					<div style="float: right;margin-top: 0px;display: table;margin-left: auto;" class=" clossse" class="close" data-dismiss="modal" aria-label="Close"><i style="font-size: 29px !important;" class="fa-regular fa-circle-xmark text-dark"></i></div>
					<img class="success-image-sign-in" src="./images/checked (1) 1.png" alt="success-img">
					<h2 class="text-dark pb-3 login-succes-text">Log in <br> Successful</h2>
					<a href="index.html" class="btn btn-continue-sign-in labham-primary-color">Continue</a>
				</div>
			</div>                                    
		</div>              
	</div>

<script type="text/javascript">
	
function Register()
 {
 	
 $('.error').hide();
  $('.success').hide();
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

   var pass=$('input#pass').val();
  if(pass=='')
  {
    $('#pass').focus();
    $('#pass').css({'border':'2px solid red'});
    return false;
  }
  else
   $('#pass').css({'border':'1px solid #CCC'});

   var cpass=$('input#cpass').val();
  if(cpass=='')
  {
    $('#cpass').focus();
    $('#cpass').css({'border':'2px solid red'});
    return false;
  }
  else if(pass!=cpass)
  {
  	Toastify({
						  text: "Password are not matching",
						  duration: 2000,
						  newWindow: true,
						  // close: true,
						  gravity: "bottom", // `top` or `bottom`
						  position: "center", // `left`, `center` or `right`
						  stopOnFocus: true, // Prevents dismissing of toast on hover
						  style: {
						    background: "linear-gradient(to right, red, red)",
						  },
						  callback: function () {
						 
						  },
						}).showToast();
    return false;
  }
  else
   $('#cpass').css({'border':'1px solid #CCC'});




   if($("#agchk").prop('checked') == false)
   {
   	Toastify({
						  text: "Agree Our Terms & Conditions",
						  duration: 2000,
						  newWindow: true,
						  // close: true,
						  gravity: "bottom", // `top` or `bottom`
						  position: "center", // `left`, `center` or `right`
						  stopOnFocus: true, // Prevents dismissing of toast on hover
						  style: {
						    background: "linear-gradient(to right, red, red)",
						  },
						  callback: function () {
						 
						  },
						}).showToast();
   	return false;
      
    }
    else
    


   $.ajax({
     type: "POST",
     url: "/signup",
     data: {
        "_token": "{{ csrf_token() }}",
        "name": name,
        "mobile": mobile,
        "pass": pass
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          $('.success').show();
          $('.success').html(data['success']);
          $('.success').css({"color":"green"});
          setTimeout(function () {
                     window.location.href='/signin';
                 }, 2000);

       //      $('#a2').hide();
       // $('#a1').show();
             
        }
      else if(data['err'])
        {
          $('.error').show();
          $('.error').html(data['err']);
          $('.error').css({"color":"red"});
       //     $('#a2').hide();
       // $('#a1').show();
        }
       
     }
   });
	
}


</script>



	@endsection