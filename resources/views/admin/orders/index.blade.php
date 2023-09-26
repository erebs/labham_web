@extends('admin.layouts.header')

@section('adminheader')
<div class="wrapper">
	@include('admin.layouts.navbar')
	@include('admin.layouts.sidebar')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@include('admin.layouts.content-header')
		<div class="row m-10">
 
      <div class="col-sm-2 mb-10">
        <select id="status" class="form-control select2bs4" style="width:100%;">
          <option value="All">Select Status</option>
          <option value="New" @if($status == 'New') selected @endif >New</option>
          <option value="Accepted" @if($status == 'Accepted') selected @endif >Accepted</option>
          <option value="Processing" @if($status == 'Processing') selected @endif >Processing</option>
          <option value="Cancelled" @if($status == 'Cancelled') selected @endif >Cancelled</option>
          <option value="Delivered" @if($status == 'Delivered') selected @endif >Delivered</option>
          <option value="Rejected" @if($status == 'Rejected') selected @endif >Rejected</option>
        </select>
      </div> 

      <div class="col-sm-2 mb-10">
        <select id="paytype" class="form-control select2bs4" style="width:100%;">
          <option value="All">Select Status</option>
          <option value="CoD" @if($paytype == 'CoD') selected @endif >CoD</option>
          <option value="Bank Transfer" @if($paytype == 'Bank Transfer') selected @endif >Bank Transfer</option>
        </select>
      </div> 

    <div class="col-sm-2 mb-10">
        <select id="paystatus" class="form-control select2bs4" style="width:100%;">
          <option value="All">Select Status</option>
          <option value="Success" @if($paystatus == 'Success') selected @endif >Success</option>
          <option value="Pending" @if($paystatus == 'Pending') selected @endif >Pending</option>
          <option value="Failed" @if($paystatus == 'Failed') selected @endif >Failed</option>
        </select>
      </div> 

      <div class="col-sm-3 mb-10">
        <input type="text" class="form-control" id="search" placeholder="Search Order Id" value="{{$search}}">
      </div> 

      <div class="col-sm-1 mb-10">
        <select id="limit" class="form-control">
          <option value="10" @if($limit == '1') selected @endif >10</option>
          <option value="25" @if($limit == '25') selected @endif >25</option>
          <option value="50" @if($limit == '50') selected @endif >50</option>
          <option value="100" @if($limit == '100') selected @endif >100</option>
        </select>
      </div> 

      <div class="col-sm-1 mb-10">
        <input type="button" id="searchBtn" class="btn btn-primary" value="Search">
      </div>
    </div>

    <div class="row m-10">
      <div class="col-12">
        <div class="card card-primary">
          <!-- <div class="card-header">
            <h3 class="card-title">My Orders</h3>
          </div> -->
          <div class="card-body">
            <table class="table table-striped" id="example1" style="width:100%" style="font-size: 15px !important;">
              <thead>
                <tr>
                  <th>ID</th>
                  <!-- <th>Image</th> -->
                  <th>Order Details</th>
                  <th>Customer Details</th>
                  <!-- <th>Amount Details</th> -->
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @if(count($orders) > 0)
                @foreach($orders as $key => $value)
                
                <tr>
                  <td align="center">{{$value->id}}</td>
                  <!-- <td align="center">
                    <a href="">
                      <img src="" class="img-thumbnail" style="max-width: 70px;">
                    </a>
                  </td> -->
                  <td style="white-space: normal !important;word-wrap: break-word !important;">
                    
                    Payment Type: <b>{{$value->paytype}}</b><br>
                    Reference Id :<b>{{$value->paymentid}}</b><br>
                    Note :<b>{{$value->details}}</b><br>
                    Order On: 
                    <b>{{ \Carbon\Carbon::parse($value->order_on)->format('d-M-Y H:i') }}</b>
                  </td>
                  <td style="white-space: normal !important;word-wrap: break-word !important;">
                    <?php $address = App\Http\Controllers\AdminCustomerController::getAddress($value->addressid); ?>
                    Name: 
                    <b>{{$address->name}}</b><br>
                    Number: 
                    <b>{{$address->mobile}}, {{$address->phone}}</b><br>
                    Email: 
                    <b>{{$address->email}}</b><br>
                    Address: 
                    <b>{{$address->address}}</b>
                  </td>
                  <!-- <td>
                    Price: <b>₹{{$value->price}}</b><br>
                    Offer Price: <b>₹{{$value->offerprice}}</b><br>
                    Quantity: <b>{{$value->quantity}}</b><br>
                    Total: <b class="text-primary">₹<?php echo $value->quantity * $value->offerprice; ?></b>
                  </td> -->
                  <td>
                    <small>Order Status:</small><br>
                    @if($value->status == 'Cancelled')
                      <select id="status" class="form-control btn-danger" onchange="changeOrderStatus(this.value, '{{$value->id}}')"  style="max-width:140px; min-width: 100px; padding: 2px; height: auto;">
                        <option value="Cancelled" @if($value->status == 'Cancelled') selected @endif >Cancelled</option>
                      </select>
                    @else
                      <select id="status" class="form-control @if($value->status == 'New') btn-primary @elseif($value->status == 'Accepted') btn-info @elseif($value->status == 'Processing') btn-info @elseif($value->status == 'Delivered') btn-success @elseif($value->status == 'Rejected') btn-danger @endif " onchange="changeOrderStatus(this.value, '{{$value->id}}')"  style="max-width:140px; min-width: 100px; padding: 2px; height: auto;">
                        <option value="New" @if($value->status == 'New') selected @endif >New</option>
                        <option value="Accepted" @if($value->status == 'Accepted') selected @endif >Accepted</option>
                        <option value="Processing" @if($value->status == 'Processing') selected @endif >Processing</option>
                        <option value="Delivered" @if($value->status == 'Delivered') selected @endif >Delivered</option>
                        <option value="Rejected" @if($value->status == 'Rejected') selected @endif >Rejected</option>
                         <!-- <option value="Returned" @if($value->status == 'Returned') selected @endif >Returned</option> -->
                      </select>
                    @endif
                    <small>Payment Status:</small><br>
                    <select id="status" class="form-control" onchange="changePaymentStatus(this.value, '{{$value->id}}')"  style="max-width:140px; min-width: 100px; padding: 2px; height: auto;">
                      <option value="Success" @if($value->paystatus == 'Success') selected @endif >Success</option>
                      <option value="Pending" @if($value->paystatus == 'Pending') selected @endif >Pending</option>
                      <option value="Failed" @if($value->paystatus == 'Failed') selected @endif >Failed</option>
                    </select>
                    <small>Return Status:</small><br>
                    <select id="rstatus" class="form-control" onchange="changeReturnStatus(this.value, '{{$value->id}}')"  style="max-width:140px; min-width: 100px; padding: 2px; height: auto;">
                      <option value="Pending" @if($value->return_status == 'Pending') selected @endif >Pending</option>
                      <option value="Return Requested" @if($value->return_status == 'Return Requested') selected @endif >Return Requested</option>
                      <option value="Return Approved" @if($value->return_status == 'Return Approved') selected @endif >Return Approved</option>
                      <option value="Return Rejected" @if($value->return_status == 'Return Rejected') selected @endif >Return Rejected</option>
                    </select>

                    <a href="{{url('/admin/orders/'.$value->id)}}" class="btn btn-secondary btn-sm" title="Edit Product" style="color: white; font-size:15px; font-weight: 600; margin:2px;">
                      <i class="fa fa-eye" style="font-size:16px"></i> View Details
                    </a>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="11" align="center">No Results Found</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            @if(count($orders) > 0)
            {{$orders->appends(['status' => $status, 'search' => $search, 'paytype' => $paytype, 'limit' => $limit, 'paystatus' => $paystatus])->links()}}
            @endif
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

</div>
@include('admin.layouts.footer')
@include('admin.layouts.js')
@include('admin.layouts.messages')
<style>
 .col-sm-3 {
  padding-right: 5px;
  padding-left: 5px;
}
.btn-group-sm>.btn, .btn-sm {
  padding: .125rem .4rem;
}
</style>
<script type="text/javascript">   
  $('#sshop').select2({
    theme: 'bootstrap4',
    placeholder: "Select Shop",
    ajax: {
      url: '{{url('/ajax/search/shops')}}',
      data: function (params) {
        return params;
      },
      dataType: 'json',
    }
  });

  function changeOrderStatus(status, id) {
    $.ajax({
      type: "GET",
      url: "{{url('/ajax/order/status')}}",
      data : { status:status, id:id },
      success: function(data){
        var obj = JSON.parse(data);
        if(obj.sts == '01') {
          toastr.success (obj.msg);
        } else {
          toastr.error ('Something Went Wrong!');
        }
      }
    });
  }

    function changeReturnStatus(status, id) {
    $.ajax({
      type: "GET",
      url: "{{url('/ajax/return/status')}}",
      data : { status:status, id:id },
      success: function(data){
        var obj = JSON.parse(data);
        if(obj.sts == '01') {
          toastr.success (obj.msg);
        } else {
          toastr.error ('Something Went Wrong!');
        }
      }
    });
  }


  function changeOrderDboy(did, id) {
    $.ajax({
      type: "GET",
      url: "{{url('/ajax/order/changedboy')}}",
      data : { did:did, id:id },
      success: function(data){
        var obj = JSON.parse(data);
        if(obj.sts == '01') {
          toastr.success (obj.msg);
        } else {
          toastr.error ('Something Went Wrong!');
        }
      }
    });
  }


  function changePaymentStatus(status, id) {
    $.ajax({
      type: "GET",
      url: "{{url('/ajax/payment/status')}}",
      data : { status:status, id:id },
      success: function(data){
        var obj = JSON.parse(data);
        if(obj.sts == '01') {
          toastr.success (obj.msg);
        } else {
          toastr.error ('Something Went Wrong!');
        }
      }
    });
  }

  $('#searchBtn').click(function() {
    var shopname = $("#ssuser option:selected").text();
    var url = '{{('/admin/orders')}}?status=' + $('#status').val() + '&search=' + $('#search').val() + '&paytype=' + $('#paytype option:selected').val() + '&slimit=' + $('#slimit').val() + '&paystatus=' + $("#paystatus option:selected").text();
    window.location.href = url;
  });

  $(function () {
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
  });
</script>
@endsection
