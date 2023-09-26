@extends('admin.layouts.header')

@section('adminheader')
<div class="wrapper">
  @include('admin.layouts.navbar')
  @include('admin.layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('admin.layouts.content-header')

    <div class="row m-10">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Order ID : #{{$order->id}}</h3>
          </div>
          <div class="card-body table-responsive ">
            <div class="row" style="margin: 0px; padding: 0px;">
              <div class="col-md-5">
                <?php $address = App\Http\Controllers\AdminCustomerController::getAddress($order->addressid); ?>
                Name: 
                <b>{{$address->name}}</b><br>
                Number: 
                <b>{{$address->mobile}}</b><br>
                Email: 
                <b>{{$address->email}}</b><br>
                Address: 
                <b>{{$address->address}}</b><br>
                Landmark: 
                <b>{{$address->landmark}}</b><br>
                Place: 
                <b> {{$address->district}}, {{$address->state}}, {{$address->pincode}}</b><br>
                Pincode: 
                <b>{{$address->pincode}}</b><br>
              </div>
              <div class="col-md-3"  style="border-left: 1px solid #bbb;">
                @php
                $tot=0;
                 @endphp
                @foreach($prod as $p)

                Name: <b>{{$p->GetProd->name}}</b><br>
                <!-- Price: <b>₹{{$p->GetProd->price}}</b><br>
                Offer Price: <b>₹{{$p->GetProd->offerprice}}</b><br> -->
                Quantity: <b>{{$p->quantity}}</b><br>
                Total: <b class="text-primary">₹{{$p->amount}}</b><br>

                @php
                $tot=$tot+$p->amount;
                 @endphp

                @endforeach
                
            
                <hr>
                Total Amount : <b>₹{{$tot}}</b>

              </div>
              
              <div class="col-md-4" style="border-left: 1px solid #bbb;">
                <div class="row" >
                  <div class="col-md-12" style="margin-top:4px;">Payment Type: <b>{{$order->paytype}}</b></div>
                  <div class="col-md-12" style="margin-top:4px;">Reference Id: <b>{{$order->paymentid}}</b></div>
                  <div class="col-md-12" style="margin-top:4px;">Note: <b>{{$order->details}}</b></div>
                  @if($order->status == 'Delivered')
                  <div class="col-md-12" style="margin-top:4px;">Delivered On:  <b>{{ \Carbon\Carbon::parse($order->delivered_on)->format('d-M-Y H:i') }}</b></div>
                  @endif
                  <div class="col-md-6" style="margin-top:4px;">Order Status:</div>
                  <div class="col-md-6" style="margin-top:4px;">
                    @if($order->status == 'Cancelled')
                      <select id="status" class="form-control btn-danger" onchange="changeOrderStatus(this.value, '{{$order->id}}')"  style="max-width:140px; min-width: 100px; padding: 2px; height: auto;">
                        <option value="Cancelled" @if($order->status == 'Cancelled') selected @endif >Cancelled</option>
                      </select>
                    @else
                      <select id="status" class="form-control @if($order->status == 'New') btn-primary @elseif($order->status == 'Accepted') btn-info @elseif($order->status == 'Processing') btn-info @elseif($order->status == 'Delivered') btn-success @elseif($order->status == 'Rejected') btn-danger @endif " onchange="changeOrderStatus(this.value, '{{$order->id}}')"  style="max-width:140px; min-width: 100px; padding: 2px; height: auto;">
                        <option value="New" @if($order->status == 'New') selected @endif >New</option>
                        <option value="Accepted" @if($order->status == 'Accepted') selected @endif >Accepted</option>
                        <option value="Processing" @if($order->status == 'Processing') selected @endif >Processing</option>
                        <option value="Delivered" @if($order->status == 'Delivered') selected @endif >Delivered</option>
                        <option value="Rejected" @if($order->status == 'Rejected') selected @endif >Rejected</option>
                        <!-- <option value="Returned" @if($order->status == 'Returned') selected @endif >Returned</option> -->
                      </select>
                    @endif
                  </div>
                  <div class="col-md-6" style="margin-top:4px;">Payment Status:</div>
                  <div class="col-md-6" style="margin-top:4px;">
                    <select id="status" class="form-control" onchange="changePaymentStatus(this.value, '{{$order->id}}')" style="max-width:140px; min-width: 100px; padding: 4px; height: auto;">
                      <option value="Success" @if($order->paystatus == 'Success') selected @endif >Success</option>
                      <option value="Pending" @if($order->paystatus == 'Pending') selected @endif >Pending</option>
                      <option value="Failed" @if($order->paystatus == 'Failed') selected @endif >Failed</option>
                    </select>
                  </div>

                  <div class="col-md-6" style="margin-top:4px;">Return Status:</div>
                  <div class="col-md-6" style="margin-top:4px;">
                    <select id="rstatus" class="form-control" onchange="changeReturnStatus(this.value, '{{$order->id}}')" style="max-width:140px; min-width: 100px; padding: 4px; height: auto;">
                      <option value="Pending" @if($order->return_status == 'Pending') selected @endif >Pending</option>
                      <option value="Return Requested" @if($order->return_status == 'Return Requested') selected @endif >Return Requested</option>
                      <option value="Return Approved" @if($order->return_status == 'Return Approved') selected @endif >Return Approved</option>
                      <option value="Return Rejected" @if($order->return_status == 'Return Rejected') selected @endif >Return Rejected</option>
                    </select>
                  </div>
                  
                </div>
              </div>







            </div>
            <hr>
@if($order->return_status != 'Pending')
             <div class="col-md-12"  style="border-left: 1px solid #bbb;">
               

                Return Details: <b>{{$order->return_det}}</b><br><br>

                @foreach($retimg as $rm)

                <a href="{{url($rm->image)}}" target="_blank"><img src="{{url($rm->image)}}" style="height:100px;width: 100px;"></a>


                @endforeach
                
                
            
                <hr>
               

              </div>
              @endif

          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
  
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Payment Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @if($order->details != '' && $order->txnid != '')
          <table>
            <?php
              $details = json_decode($order->details);
              foreach ($details as $key => $value) { ?>
                <tr>
                  <th>{{$key}}</th>
                  <th>-</th>
                  <th>{{$value}}</th>
                </tr>
              <?php }
            ?>
          </table>
          @endif
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>
@include('admin.layouts.footer')
@include('admin.layouts.js')
@include('admin.layouts.messages')
<script type="text/javascript">
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
          location.reload();
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

  $(function () {
    $('#deliveryboy').select2({
      theme: 'bootstrap4'
    });
  });
</script>
@endsection
