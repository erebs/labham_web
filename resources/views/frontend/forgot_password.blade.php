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
			<h1 class="signin-main-text text-center pb-3">Forgot Password</h1>
			<div class="form-outline mb-2">
				<input type="number" id="mobile" placeholder="Mobile number" class="form-control" />
				<label class="form-label" for="form2Example1"></label>
        <h4 class="text-center mt-2" style="float: right;cursor: pointer;color: blue;" id="stp"> <a class="text-center" onclick="SendOtp()"> Send OTP </a></h4>

        <div class="text-center mt-2" style="color:red;font-size: 12px;float: right;" id="timer"></div>

      
			</div>
      <div class="form-outline mb-2" id="otpdiv">
        <input type="text" id="otp" placeholder="Enter OTP" class="form-control" />
        <label class="form-label" for="form2Example2"></label>
        <p id="otpMessage" style="color:red;font-size: 12px;"></p>
      </div>
      <div class="form-outline mb-2" hidden>
        <input type="text" id="otpresult" placeholder="Enter OTP" class="form-control" />
        <label class="form-label" for="form2Example2"></label>
      </div>
			<!-- Password input -->
			<div class="form-outline mb-2">
				<input type="password" id="pass" placeholder="Password" class="form-control" />
				<label class="form-label" for="form2Example2"></label>
			</div>
      <div class="form-outline mb-2">
        <input type="password" id="confirmpass" placeholder="Confirm Password" class="form-control" />
        <label class="form-label" for="form2Example2"></label>
      </div>

			
        

			<a class="btn labham-primary-bg btn-block mb-4 text-white login-btn-signup" style="cursor: pointer;background-color:gray;pointer-events: none;" onclick="Save()" id="ab1" disabled>Submit</a>
      <a class="btn labham-primary-bg btn-block mb-4 text-white login-btn-signup" style="cursor: pointer;background-color:gray;" id="ab2" disabled><i class="fa fa-spinner fa-spin"></i>   Submit</a>
      <!-- <h4 class="text-center mb-4" > <a class="text-center" href="/forgot-password"> Forgot Password ?</a></h4> -->
		</form>
	</div>
	



<script type="text/javascript">


      $('#otp').on('input', function() {
        var otpnum = $(this).val();

        var otpresult = $('input#otpresult').val();
        // alert(otpnum);
        // alert(otpresult);
        
        if (otpnum==otpresult) {
          Toastify({
              text: "Otp verified successfully",
              duration: 3000,
              newWindow: true,
             
              gravity: "top", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background: "linear-gradient(to right, green, green)",
              },
              onClick: function(){} // Callback after click
            }).showToast();
          $('#otpMessage').hide();
          $("#ab1").css("pointer-events", "auto");
          $('#ab1').css('background-color', '#EF1E42');
          
         
        } else {
            $('#otpMessage').show();
            $('#otpMessage').text('Invalid otp.');
            $("#ab1").css("pointer-events", "none");
            $('#ab1').css('background-color', 'gray');
        }
      });
	
function SendOtp()
  {
    $('#otp').val('');

    var mobile=$('input#mobile').val();
    if(mobile=='')
  {
    $('#mobile').focus();
    $('#mobile').css({'border':'2px solid red'});
    return false;
  }
  else
   $('#mobile').css({'border':'1px solid #EF1E42'});

    // $('#otpbtn1').show();
    // $('#otpbtn').hide();
    // $('#otp').val('');
    // $("#ab1").css("pointer-events", "none");
    //     $('#ab1').css('background-color', 'gray');

        $.post("/send-otp", {mobile: mobile,_token: "{{ csrf_token() }}"}, function(result) 
          {

            
            if(result==1)
            {
                  Toastify({
                  text: "Unregistered Mobile number",
                  duration: 3000,
                  newWindow: true,
                  // close: true,
                  gravity: "top",
                  position: "right",
                  stopOnFocus: true,
                  style: {
                    background: "linear-gradient(to right, red, red)",
                  },
                  onClick: function(){}
                }).showToast();
                // $('#otpbtn').show();
                // $('#otpbtn1').hide();
                

                }
            else
            {

            Toastify({
              text: "Otp sent successfully",
              duration: 3000,
              newWindow: true,
              // close: true,
              gravity: "top", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background: "linear-gradient(to right, green, green)",
              },
              onClick: function(){} // Callback after click
            }).showToast();
                $('#otpresult').val(result.trim());
                $('#otpdiv').show();
                  $('#mobile').prop('disabled', true);
                  $('#stp').hide();
                  $('#timer').show();
                $('#timer').text('Resend OTP in 15 seconds');

                var seconds = 15;
            var timerElement = $('#timer');

            function updateTimer() { 
              if (seconds > 0) {
                timerElement.text('Resend OTP in' + ' ' + seconds + ' ' + 'seconds');
                seconds--;
              } else {
                
               $('#stp').show();
               // $('#stp').text('Resent OTP');
                // performTaskAfterTimeout();
                clearInterval(timerInterval);
                $('#timer').hide();
              }
            }

          var timerInterval = setInterval(updateTimer, 1000);
                
               
            
                }
              }
                );
    }



    function Save()
    {
    
$('#ab2').hide();
     
var pass=$('input#pass').val();
    
      if(pass=='')
      {
        $('#pass').css('border','1px solid red');
        $('#pass').focus();
        return false;
      }
      else
        $('#pass').css('border','1px solid #000');

     var confirmpass=$('input#confirmpass').val();
    
      if(confirmpass=='')
      {
        $('#confirmpass').css('border','1px solid red');
        $('#confirmpass').focus();
        return false;
      }
      else if(confirmpass!=pass)
      {
        Toastify({
              text: "Passwords are not matching",
              duration: 3000,
              newWindow: true,
              // close: true,
              gravity: "top", // `top` or `bottom`
              position: "right", // `left`, `center` or `right`
              stopOnFocus: true, // Prevents dismissing of toast on hover
              style: {
                background: "linear-gradient(to right, red, red)",
              },
              callback: function () {
               
              },
            }).showToast();
        $('#confirmpass').css('border','1px solid red');
        $('#confirmpass').focus();
        $('#confirmpass').blur();
        return false;
      }
      else
        $('#confirmpass').css('border','1px solid #000');

    var mobile=$('input#mobile').val();

     $('#ab1').hide();
      $('#ab2').show();

      data = new FormData();
      data.append('mobile', mobile);
       data.append('pass', pass);

  data.append('_token', "{{ csrf_token() }}");
    
      $.ajax({
    
        type:"POST",
        url:"/password-reset",
         data: data,
        dataType:"json",
        contentType: false,
//cache: false,
processData: false,
       
        success:function(data)
        {
          if(data['success'])
          {
              $('#ab2').hide();
              $('#ab1').show();
              
               Toastify({
              text: "Password changed successfully",
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
               window.location.href='/signin';
              },
            }).showToast();
          }

        }
    
    
    
    
      })
    
    
    
    
    
    
    }






</script>






		@endsection