@extends('admin.layouts.header')

@section('adminheader')
<!-- Content Wrapper. Contains page content -->
<div class="row login-page" >
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary" style="border-top: 3px solid #0e2469;">
      <div class="card-header text-center">
        <a href="{{url('/')}}" class="h1" style="color:#0e2469; line-height: 1.5">
          <b> {{config('app.name', '')}}</b>
        </a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="{{ action('AdminController@login') }}" method="POST" role="form" id="quickForm" autocomplete="off">
    @csrf

          <div class="input-group mb-3">
            <input type="text" id="name" name="name" class="form-control" placeholder="User Name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember"> Remember Me</label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" style="background-color: #0e2469; border: 1px solid #0e2469;"><b>Sign In</b></button>
            </div>
            <!-- /.col -->
          </div>
          <br>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
</div>

@include('admin.layouts.js')
@include('admin.layouts.messages')
<style>
  body {
    max-width: 99% !important;
  }
</style>
<script type="text/javascript">
  $(document).ready(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        form.submit();
      }
    });

    $('#quickForm').validate({
      rules: {
        name: {
          required: true
        },
        password: {
          required: true,
          minlength: 4
        }
      },
      messages: {
        name: {
          required: "Please enter User Name"
        },
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 6 characters long"
        }
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });

    $("#showMsg").delay(3600).fadeOut(300);
  });
  </script>
@endsection
