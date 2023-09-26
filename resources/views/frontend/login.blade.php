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
			<h1 class="signin-main-text text-center pb-3">Sign in</h1>
			<div class="form-outline mb-2">
				<input type="number" id="mobile" placeholder="Mobile number" class="form-control" />
				<label class="form-label" for="form2Example1"></label>
			</div>
			<!-- Password input -->
			<div class="form-outline mb-2">
				<input type="password" id="pass" placeholder="Password" class="form-control" />
				<label class="form-label" for="form2Example2"></label>
			</div>
			<!-- 2 column grid layout for inline styling -->
			<div class="row mb-4 read-agreeement">
				<div class="col d-flex justify-content-center">
					<!-- Checkbox -->
					<div class="form-check agree-dv">
					<h4 class="text-center mb-4" >Don't have account? <a class="text-center" href="signup"> Sign Up</a></h4>
					</div>
				</div>
			</div>
			<!-- Submit button -->
			<!-- <a href="index.html" class="btn labham-primary-bg btn-block mb-4 text-white login-btn-signup" data-target="#exampleModal12" href="exampleModal12" data-toggle="modal">Login</a> -->

			<center>
        <div class="error" style="font-weight: bold;"></div>
        <div class="success" style="font-weight: bold;"></div>
        </center>
        

			<a class="btn labham-primary-bg btn-block mb-4 text-white login-btn-signup" style="cursor: pointer;" onclick="Login()">Submit</a>
      <h4 class="text-center mb-4" > <a class="text-center" href="/forgot-password"> Forgot Password ?</a></h4>
		</form>
	</div>
	<div  class="modal fade"  tabindex="-1" role="dialog" id="exampleModal12"  aria-labelledby="exampleModalLabel12" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content model-sign-in-otp">
				<div class="modal-body modal-loginform-second">
					<div style="float: right;margin-top: 0px;display: table;margin-left: auto;" class=" clossse" class="close" data-dismiss="modal" aria-label="Close"><i style="font-size: 29px !important;" class="fa-regular fa-circle-xmark text-dark"></i></div>
					<img class="success-image-sign-in" src="{{asset('/frontend/images/checked (1) 1.png')}}" alt="success-img">
					<h2 class="text-dark pb-3 login-succes-text">Log in <br> Successful</h2>
					<a href="index.html" class="btn btn-continue-sign-in labham-primary-color">Continue</a>
				</div>
			</div>                                    
		</div>              
	</div>



<script type="text/javascript">
	
function Login()
{
  $('.error').hide();
  $('.success').hide();
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

   // if($("#remember").prop('checked') == true)
   // {
   //    var rememberStatus=1;
   //  }
   //  else if($("#remember").prop('checked') == false)
   // {
   //    var rememberStatus=0;
   //  }
    
   //   $('#a1').hide();
   //     $('#a2').show();

   $.ajax({
     type: "POST",
     url: "/signin",
     data: {
        "_token": "{{ csrf_token() }}",
        "mobile": mobile,
        "pass": pass,
        },
     dataType: "json",
     success: function (data) {

      if(data['success'])
        {
          $('.success').show();
          $('.success').html(data['success']);
          $('.success').css({"color":"green"});
          setTimeout(function () {
                     window.location.href='/';
                 }, 1000);

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