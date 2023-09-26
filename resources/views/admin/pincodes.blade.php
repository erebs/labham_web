@extends('admin.layouts.header')

@section('adminheader')
<div class="wrapper">
  @include('admin.layouts.navbar')
  @include('admin.layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('admin.layouts.content-header')
     
    <form method="POST" action="{{url('/admin/pincodes')}}" id="addForm">
      @csrf
      <div class="row m-10">
        <div class="col-sm-3">
          <input type="text" id="pincode" name="pincode" placeholder="Enter Pincode" value="" class="form-control">
          <span class="invalid-feedback">6 Digit Pincode Required.</span>
        </div>

        <div class="col-sm-3">
          <input type="text" id="district" name="district" placeholder="Enter District" value="" class="form-control" readonly>
          <span class="invalid-feedback">District Required.</span>
        </div>

        <div class="col-sm-3">
          <input type="text" id="state" name="state" placeholder="Enter State" value="" class="form-control" readonly>
          <span class="invalid-feedback">State Required.</span>
        </div>

        <div class="col-sm-2">
          <input type="button" id="addBtn" class="btn btn-primary btn-block" value="Add Pincode">
        </div>
      </div>
    </form>

    <div class="row m-10">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Pincodes List</h3>
          </div>
          <div class="card-body table-responsive p-2">
            <div class="row">
              @if(count($pincodes) > 0)
                @foreach($pincodes as $key => $value)
                  <div class="col-md-4 mb-2">
                    <ul class="list-group">
                      <li class="list-group-item">{{$value->pincode}}, {{$value->district}}, {{$value->state}}</li>
                    </ul>
                  </div>
                @endforeach
              @else
                <ul class="list-group">
                  <li class="list-group-item">No Results Found!</li>
                </ul>
              @endif
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>



  <input type="hidden" id="delId">

  <!-- /.content-wrapper -->
  @include('admin.layouts.footer')
  @include('admin.layouts.js')
  @include('admin.layouts.messages')
  <style>
    .card-body.p-0 .table thead>tr>th:first-of-type {
      padding-left: .7rem;
      padding-right: .7rem;
    }
  </style>
  @if(isset($model) && $model == 'open')
  <script>
    $('#add-model').modal('show');
  </script>
  @endif
  <script>
    $('#pincode').keyup(function() {
      if($('#pincode').val().length == 6) {
        $('#pincode').removeClass('is-invalid');
        $.ajax({
          type: "GET",
          url: "{{url('/api/getpincodedetails')}}",
          data : { pincode:$('#pincode').val() },
          success: function(resp){
            var obj = JSON.parse(resp);
            if(obj.sts == '01') {
              $('#district').val(obj.District);
              $('#state').val(obj.State);
              $('#district').trigger('change');
              $('#state').trigger('change');
              $('#district').removeClass('is-invalid');
              $('#state').removeClass('is-invalid');
            }
          }
        });
      } else {
        $('#pincode').addClass('is-invalid');
      }
    })

    $('#addBtn').click(function() {
      var error = 0;

      if($('#state').val() == '' || $('#state').val() == null){
        $('#state').addClass('is-invalid');
        error = 1;
      } else {
        $('#state').removeClass('is-invalid');
      }

      if($('#district').val() == '' || $('#district').val() == null){
        $('#district').addClass('is-invalid');
        error = 1;
      } else {
        $('#district').removeClass('is-invalid');
      }

      if($('#pincode').val() == '' || $('#pincode').val().length != 6){
        $('#pincode').addClass('is-invalid');
        error = 1;
      } else {
        $('#pincode').removeClass('is-invalid');
      }

      if(error == 0) {
        $('#addForm').submit();
      }
    });

  </script>
</div>
@endsection
