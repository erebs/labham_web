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
            <h3 class="card-title">Units for Product: {{$product->name}}</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-bordered table-extra" id="rtable" style="font-size: 15px !important;">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>Unit Name</th>
                  <th>Price</th>
                  <th>Offer Price</th>
                  <th>Display Order</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @if(count($units) > 0)
                @foreach($units as $key => $value)
                <tr>
                  <td align="center"><?php echo $key + 1; ?></td>
                  <td>{{$product->name}}</td>
                  <td>{{$value->name}}</td>
                  <td align="right">₹ {{$value->price}}</td>
                  <td align="right">₹ {{$value->offerprice}}</td>
                  <td align="center">{{$value->disp_order}}</td>
                  <td align="center">
                    <div class="row">
                      <div class="col-4" align="center">
                        <select id="status" class="form-control" onchange="setStatus(this.value, '{{$value->id}}')" style="max-width:120px; min-width:110px;">
                          <option value="Enabled" @if($value->status == 'Enabled') selected @endif >Enabled</option>
                          <option value="Disabled" @if($value->status == 'Disabled') selected @endif >Disabled</option>
                        </select>
                      </div>
                      <div class="col-4" align="center">
                        <a href="" class="btn btn-sm btn-warning" title="Edit Units" data-toggle="modal" data-target="#edit-model" onclick="$('#eid').val('{{$value->id}}'); $('#ename').val('{{$value->name}}'); $('#eprice').val('{{$value->price}}'); $('#eofferprice').val('{{$value->offerprice}}'); $('#edisp_order').val('{{$value->disp_order}}');" style="font-size:16px; ">
                          <i class="fa fa-edit"></i> Edit
                        </a>
                      </div>
                      
                      <div class="col-4" align="center">
                        <form action="{{url('/admin/products/units/delete/'.$value->productid)}}" method="POST" role="form" id="delform{{$value->id}}">
                          <input type="hidden" name="did" value="{{$value->id}}">
                          {!! csrf_field() !!}
                          <button type="button" class="btn btn-sm btn-danger" title="Delete Units" data-toggle="modal" data-target="#modal-delete" onclick="mkeDelModal('{{$value->id}}','{{$value->name}}');" style="font-size:16px">
                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="7" align="center">No Results Found!</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Add new user link -->
    <a href="" title="Add Units" data-toggle="modal" data-target="#add-model" >
      <i class="fa fa-plus-circle fa-add-new" aria-hidden="true"></i>
    </a>
  </div>
</div>

<div class="modal fade" id="add-model">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Product Units</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{url('/admin/products/units/save/'.$productid)}}" id="addForm" method="POST">
          {{ csrf_field() }}
          <input type="hidden" id="productid" name="productid" value="{{$productid}}">

          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label text-right">Unit Name:</label>
            <div class="col-sm-8">
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter Unit Name">
              <div class="invalid-feedback">Unit Name Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="price" class="col-sm-3 col-form-label text-right">Price:</label>
            <div class="col-sm-8">
              <input type="number" name="price" id="price" class="form-control" placeholder="Enter Unit Price" min="1" >
              <div class="invalid-feedback">Unit Price Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="offerprice" class="col-sm-3 col-form-label text-right">Offer Price:</label>
            <div class="col-sm-8">
              <input type="number" name="offerprice" id="offerprice" class="form-control" placeholder="Enter Unit Offer Price" min="1" >
              <div class="invalid-feedback">Unit Offer Price Required.</div>
            </div>
          </div>

          <div class="form-group row">
           <label for="disp_order" class="col-sm-3 col-form-label text-right">Display Order:</label>
            <div class="col-sm-8">
              <input type="number" name="disp_order" id="disp_order" class="form-control" placeholder="Enter Display Order" min="1" value="{{$disporder}}">
              <div class="invalid-feedback">Display Order Required.</div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="addBtn" class="btn btn-primary"> Save </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit-model">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Product Units</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{url('/admin/products/units/update/'.$productid)}}" id="editForm" method="POST">
          {{ csrf_field() }}
          <input type="hidden" id="productid" name="productid" value="{{$productid}}">
          <input type="hidden" id="eid" name="eid" value="0">

          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label text-right">Unit Name:</label>
            <div class="col-sm-8">
              <input type="text" name="name" id="ename" class="form-control" placeholder="Enter Unit Name">
              <div class="invalid-feedback">Unit Name Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="offerprice" class="col-sm-3 col-form-label text-right">Price:</label>
            <div class="col-sm-8">
              <input type="number" name="price" id="eprice" class="form-control" placeholder="Enter Unit Price" min="1" >
              <div class="invalid-feedback">Unit Price Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="offerprice" class="col-sm-3 col-form-label text-right">Offer Price:</label>
            <div class="col-sm-8">
              <input type="number" name="offerprice" id="eofferprice" class="form-control" placeholder="Enter Unit Offer Price" min="1" >
              <div class="invalid-feedback">Unit Offer Price Required.</div>
            </div>
          </div>

          <div class="form-group row">
        <label for="disp_order" class="col-sm-3 col-form-label text-right">Display Order:</label>
            <div class="col-sm-8">
              <input type="number" name="disp_order" id="edisp_order" class="form-control" placeholder="Enter Display Order" min="1" value="{{$disporder}}">
              <div class="invalid-feedback">Display Order Required.</div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="editBtn" class="btn btn-primary"> Save </button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

  <div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="deltitle">Delete</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>Are You Sure?</h5>
          <p>Do you Really want to Delete this Unit.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" onclick="delForm()">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="delId">
@include('admin.layouts.footer')
@include('admin.layouts.js')
@include('admin.layouts.messages')

<script type="text/javascript">
  $('#addBtn').click(function() {
    var error = 0

    if($('#offerprice').val() == '' || $('#offerprice').val() < 1){
      $('#offerprice').addClass('is-invalid');
      error = 1;
    } else {
      $('#offerprice').removeClass('is-invalid');
    }

    if($('#price').val() == '' || $('#price').val() < 1){
      $('#price').addClass('is-invalid');
      error = 1;
    } else {
      $('#price').removeClass('is-invalid');
    }

    if($('#disp_order').val() == '' || $('#disp_order').val() < 1){
      $('#disp_order').addClass('is-invalid');
      error = 1;
    } else {
      $('#disp_order').removeClass('is-invalid');
    }

    if(error == 0) {
      $('#addForm').submit();
    }
  });

  $('#editBtn').click(function() {
    var error = 0

    if($('#eofferprice').val() == '' || $('#eofferprice').val() < 1){
      $('#eofferprice').addClass('is-invalid');
      error = 1;
    } else {
      $('#eofferprice').removeClass('is-invalid');
    }

    if($('#eprice').val() == '' || $('#eprice').val() < 1){
      $('#eprice').addClass('is-invalid');
      error = 1;
    } else {
      $('#eprice').removeClass('is-invalid');
    }

    if($('#edisp_order').val() == '' || $('#edisp_order').val() < 1){
      $('#edisp_order').addClass('is-invalid');
      error = 1;
    } else {
      $('#edisp_order').removeClass('is-invalid');
    }

    if(error == 0) {
      $('#editForm').submit();
    }
  });

  function mkeDelModal(id, name) {
    $('#deltitle').html('Delete ' + name);
    $('#delId').val(id);
  }

  function delForm() {
    $('#delform'+$('#delId').val()).submit();
  }


  function setStatus(status, id) {
    $.ajax({
      type: "GET",
      url: "{{url('/ajax/productunit/status')}}",
      data : { status:status, id:id },
      success: function(data){
        var obj = JSON.parse(data);
        if(obj.sts == '01') {
          toastr.success ('Status Updated');
        } else {
          toastr.error ('Something Went Wrong!');
        }
      }
    });
  }
</script>

@endsection