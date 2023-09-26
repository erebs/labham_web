

<!-- Bootstrap core JavaScript -->
<script src="{{asset('/assets/viosmart/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/assets/viosmart/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- select2 Js -->
<script src="{{asset('/assets/viosmart/vendor/select2/js/select2.min.js')}}"></script>
<!-- Owl Carousel -->
<script src="{{asset('/assets/viosmart/vendor/owl-carousel/owl.carousel.js')}}"></script>
<!-- Custom -->
<script src="{{asset('/assets/viosmart/js/custom.js')}}"></script>
<script src="{{asset('/assets/viosmart/js/hc-offcanvas-nav.js?ver=4.1.1')}}"></script>
<link rel="stylesheet" href="{{asset('/assets/viosmart/js/demo.css?ver=3.4.0')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>

<script>
  $('#beModelClose').click(function() {
    $('#bd-example-modal').modal('hide');
  });
  
  $('#regProceed').click(function() {
    var error = 0;

    if($('#regName').val() == '') {
      $('#regName').addClass('is-invalid');
      error = 1;
    } else {
      $('#regName').removeClass('is-invalid');
    }

    if($('#regMobile').val() == '') {
      $('#regMobile').addClass('is-invalid');
      $('#divRegMobile').html('Mobile Number Required.');
      error = 1;
    } else if($('#regMobile').val().length != 10) {
      $('#regMobile').addClass('is-invalid');
      $('#divRegMobile').html('10 digit Mobile Number Required.');
      error = 1;
    } else {
      $('#regMobile').removeClass('is-invalid');
    }

    if($('#regEmail').val() == '') {
      $('#regEmail').addClass('is-invalid');
      error = 1;
    } else {
      $('#regEmail').removeClass('is-invalid');
    }

    if(error == 0) {
      $.ajax({
        type: "POST",
        url: "{{url('/api/check/customer/number')}}?number=" + $('#regMobile').val(),
        data: '',
        success: function(resp){
          var obj = JSON.parse(resp);
          if(obj.sts == '01') {
            $('#regMobile').addClass('is-invalid');
            $('#divRegMobile').html('Mobile Number Already Exists! Try Another.');
          } else {
            $('#regMobile').removeClass('is-invalid');
            $('#divRegMobile').html('Mobile Number Required.');

            $.ajax({
              type: "POST",
              url: "{{url('/api/check/customer/email')}}?email=" + $('#regEmail').val(),
              data: '',
              success: function(resp){
                var obj = JSON.parse(resp);
                if(obj.sts == '01') {
                  $('#regEmail').addClass('is-invalid');
                  $('#divregEmail').html('Email Address Already Exists! Try Another.');
                } else {
                  $('#regEmail').removeClass('is-invalid');
                  $('#divregEmail').html('Email Address Required.');

                  $.ajax({
                    type: "POST",
                    url: "{{url('/api/customer/sendregotp')}}?email=" + $('#regEmail').val() + "&number=" + $('#regMobile').val() + '&name=' + $('#regName').val(),
                    data: '',
                    success: function(resp){
                      var obj = JSON.parse(resp);
                      if(obj.sts == '01') {
                        toastr.success('OTP Send to Your Mobile Number and Email Address');
                        $('#registerModel').removeClass('active');
                        $('#registerModel').removeClass('show');

                        $('#otpModel').addClass('active');
                        $('#otpModel').addClass('show');
                      } else {
                        toastr.error('Something Went Wrong. Try After!');
                      }
                    }
                  });
                  
                }
              }
            });

          }
        }
      });
    }
  })

  $('#regSubmit').click(function() {
    if($('#regOTP').val().length != 4) {
      $('#regOTP').addClass('is-invalid');
    } else {
      $('#regOTP').removeClass('is-invalid');

      $.ajax({
        type: "POST",
        url: "{{url('/api/customer/verifyotp')}}",
        data: {otp:$('#regOTP').val()},
        success: function(resp){
          var obj = JSON.parse(resp);
          if(obj.sts == '01') {
            toastr.success('OTP Verified.');
            $('#otpModel').removeClass('active');
            $('#otpModel').removeClass('show');

            $('#passwordModel').addClass('active');
            $('#passwordModel').addClass('show');
          } else {
            toastr.error('OTP Does Not Match!');
          }
        }
      });

    }
  })

  $('#regCreate').click(function() {
    var error = 0;
    $('#regCreate').prop('disabled', true);

    if($('#regPassword').val() == '') {
      $('#regPassword').addClass('is-invalid');
      error = 1;
    } else {
      $('#regPassword').removeClass('is-invalid');
    }

    if($('#regCPassword').val() == '') {
      $('#regCPassword').addClass('is-invalid');
      $('#divregCPassword').html('Password Required.');
      error = 1;
    } else {
      $('#regCPassword').removeClass('is-invalid');
      $('#divregCPassword').html('Password Required.');
    }

    if($('#regCPassword').val() != $('#regPassword').val()) {
      $('#regCPassword').addClass('is-invalid');
      $('#divregCPassword').html('Password does not Match.');
      error = 1;
    }

    if(error == 0) {
      if($("#regAgree").prop('checked') == true) {
        $.ajax({
          type: "POST",
          url: "{{url('/api/customer/register')}}",
          data: {
            email: $('#regEmail').val(),
            number: $('#regMobile').val(),
            name: $('#regName').val(),
            password: $('#regPassword').val()
          },
          success: function(resp){
            var obj = JSON.parse(resp);
            if(obj.sts == '01') {
              window.location.reload();
            } else {
              toastr.error('Something Went Wrong. Try After!');
              $('#regCreate').prop('disabled', false);
            }
          }
        });
      } else {
        toastr.error('Agree our Terms and Conditions.');
        $('#regCreate').prop('disabled', false);
      }
    } else {
      $('#regCreate').prop('disabled', false);
    }

  })

  $('#loginBtn').click(function() {
    var error = 0;

    if($('#emailormobile').val() == '') {
      $('#emailormobile').addClass('is-invalid');
      error = 1;
    } else {
      $('#emailormobile').removeClass('is-invalid');
    }

    if($('#password').val() == '') {
      $('#password').addClass('is-invalid');
      error = 1;
    } else {
      $('#password').removeClass('is-invalid');
    }

    if(error == 0) {
      $.ajax({
        type: "POST",
        url: "{{url('/api/customer/login')}}",
        data: {
          emailormobile: $('#emailormobile').val(),
          password: $('#password').val()
        },
        success: function(resp){
          var obj = JSON.parse(resp);
          if(obj.sts == '01') {
            window.location.reload();
          } else {
            toastr.error('Invalid User Details! Try Register');
          }
        }
      });
    }
  })

  $('#setPincode').select2({
    theme: 'bootstrap4',
    placeholder: 'Select Pincode',
    ajax:{
      url: "{{url('/api/pincode/search')}}",
      data: function (params) {
        return {
          term: params.term
        }
      },
      dataType: 'json',
    }
  });

  $('#setPincode').one('select2:open', function(e) {
    $('input.select2-search__field').prop('placeholder', 'Search Pincode');
  });

  $('#setPincode').change(function() {
    $.ajax({
      type: "GET",
      url: "{{url('/api/pincode/search/addpincode')}}",
      data: {
        pin: $('#setPincode').val()
      },
      success: function(resp){
        var obj = JSON.parse(resp);
        if(obj.sts == '01') {
          window.location.reload();
        } else {
          toastr.error('Something Went Wrong!');
        }
      }
    });
  });

  $('#searchProducts').click(function(event) {
    event.stopPropagation();
    $('#ListProducts').removeClass('hide');
    loadSearch();
  });

  $('#searchProducts').keyup(function(event) {
    event.stopPropagation();
    if($('#searchProducts').val().length == 0) { 
      $('#ListProducts').addClass('hide');
    } else {
      $('#ListProducts').removeClass('hide');
    }
    loadSearch();
  });

  $('html').click(function() {
    $('#ListProducts').addClass('hide');
  });

  $('#ListProducts').click(function(event){
    event.stopPropagation();
  });

  function loadSearch() {
    $.ajax({
      type: "GET",
      url: "{{url('/api/search')}}",
      data: {
        search: $('#searchProducts').val()
      },
      success: function(resp){
        $('#ListProducts').html(resp);
      }
    });
  }
</script>

<script>
  (function($) {
    var $main_nav = $('#main-nav');
    var $toggle = $('.toggle');

    var defaultOptions = {
      disableAt: false,
      customToggle: $toggle,
      levelSpacing: 10,
      navTitle: ' @if($userName != '')Hi, {{$userName}} @endif ',
      levelTitles: true,
      levelTitleAsBack: true,
      pushContent: '#container',
      insertClose: 2
    };
    var Nav = $main_nav.hcOffcanvasNav(defaultOptions);
  })(jQuery);
</script>

<style>
.hide {
  display: none !important;
}
.show {
  display: block !important;
}
</style>

@if(Session::has('success'))
  <script>
    toastr.success('{{Session::get('success')}}')
  </script>
@endif

@if(Session::has('error'))
  <script>
    toastr.error('{{Session::get('error')}}')
  </script>
@endif

