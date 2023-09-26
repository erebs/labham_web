@extends('admin.layouts.header')

@section('adminheader')
<div class="wrapper">
	@include('admin.layouts.navbar')
	@include('admin.layouts.sidebar')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@include('admin.layouts.content-header')
		<div class="row m-10">

     

       <form method="post" enctype="multipart/form-data" action="{{ url('/import_excel/import') }}">
    {{ csrf_field() }}
    <div class="form-group">
     <table class="table">
      <tr>
       <td width="40%" align="right"><label>Select File for Upload</label></td>
       <td width="30">
        <input type="file" name="file" />
       </td>
       <td width="30%" align="left">
        <input type="submit" name="upload" class="btn btn-primary" value="Upload">
       </td>
      </tr>
      <tr>
       <td width="40%" align="right"></td>
       <!-- <td width="30"><span class="text-muted">.xls, .xslx</span></td> -->
       <td width="30%" align="left"></td>
      </tr>
     </table>
    </div>
   </form>

    <form method="post" enctype="multipart/form-data" action="{{ url('/export_excel/export') }}">
    {{ csrf_field() }}
    <div class="form-group">
     <table class="table">
      <tr>
      
       <td width="30%" align="left">
        <input type="submit" name="Export" class="btn btn-primary" value="Export">
       </td>
      </tr>
      
     </table>
    </div>
   </form>
    </div>

    <div class="row m-10">
      <div class="col-12">
        <div class="card card-primary">
          <!-- <div class="card-header">
            <h3 class="card-title">Product List</h3>
          </div> -->
          <div class="card-body">
            <table class="table table-striped" id="example" style="width:100%" style="font-size: 15px !important;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Product Details</th>
                  <th>Price/Stock Details</th>
                  <th>Other Details</th>
                  <!-- <th>Descripton</th> -->
                   <th>Units Details</th>
                  <th>Status/Actions</th>
                </tr>
              </thead>
              <tbody>
                @if(count($products) > 0)
                @foreach($products as $key => $value)
                <tr>
                  <td align="center">{{$value->id}}</td>
                  <td align="center">
                    @if($value->image != '')
                    <img src="{{url($value->image)}}" class="img-thumbnail" style="max-height:80px; max-width: 80px;">
                    @endif 
                  </td>
                  <td style="white-space: normal !important;word-break: break-all !important; max-width: 300px; min-width: 150px;">
                    Name: <b>{{$value->name}}</b><br>
                    Cat: <b>{{$value->GetCat->name}}</b><br>
                    <!-- SubCat: <b>@if(isset($subcategory[$value->subcat_id])){{$subcategory[$value->subcat_id]}}@endif</b> -->
                  </td>
                  <td>
                    Stock Avalible: <b>
                      @if($value->stock_avalible > 3)
                        <span class="text-success">{{$value->stock_avalible}}</span>
                      @else 
                        <span class="text-danger">{{$value->stock_avalible}}</span>
                      @endif
                    </b><br>
                    Price: <b><del>₹{{$value->price}}</del></b><br>
                    Offer price: <b>₹{{$value->offerprice}}</b>
                  </td>
                  <td>
                    Best Seller: <b>@if($value->best_seller == '1') Yes @else No @endif</b><br>
                    Featured: <b>@if($value->featured == '1') Yes @else No @endif</b><br>
                    Trending: <b>@if($value->trending == '1') Yes @else No @endif</b><br>
                  </td>
                  <!-- <td style="white-space: normal !important;word-break: break-all !important; max-width: 220px; min-width: 140px;"> -->
                    <?php /*if(strlen($value->desc) > 150) {
                      echo substr($value->desc, 0, 150).'...';
                    } else {
                      echo $value->desc;
                    }*/?>
                  <!-- </td> -->

                  <td style="padding:0px !important;">
                          <a href="{{url('/admin/product-gallery/'.$value->id)}}" class="btn btn-primary" target="_blank" title="Edit Product" style="color: white; font-size:15px; font-weight: 600; margin:2px;">
                            <i class="fa fa-image" style="font-size:16px"></i> Gallery
                          </a>
                           <a href="{{url('/admin/product-videos/'.$value->id)}}" class="btn btn-primary" target="_blank" title="Edit Product" style="color: white; font-size:15px; font-weight: 600; margin:2px;">
                            <i class="fa fa-play" style="font-size:16px"></i> Videos
                          </a>
                        </td>
                        
                  
                  <td align="left">
                    <table class="table-borderless">
                      <tr>
                        <td style="padding:0px !important;">
                          <select id="status" class="form-control" onchange="setStatus(this.value, '{{$value->id}}')" style="max-width:120px; min-width:110px;">
                            <option value="Available" @if($value->status == 'Available') selected @endif >Available</option>
                            <option value="Not Available" @if($value->status == 'Not Available') selected @endif >Not Available</option>
                          </select>
                        </td>
                        <td style="padding:0px !important;">
                          <button type="button" class="btn btn-info" title="Add Stock" data-toggle="modal" data-target="#modal-stock" onclick="$('#productid').val({{$value->id}});" style="color: white; font-size:15px; font-weight: 600; margin:2px;">
                            <i class="fa fa-layer-group" style="font-size:16px"></i> Mng Stocks
                          </button>
                        </td>
                        <!-- <td colspan="2" style="padding:0px !important;">
                          <a href="{{url('/admin/products/units/'.$value->id)}}" target="_blank" class="btn btn-primary" title="Add Units & Price Details" style="color: white; font-size:15px; font-weight: 600; margin:2px;">
                            <i class="fa fa-plus-square" style="font-size:16px"></i> Units & Price Details
                          </a>
                        </td> -->
                      </tr>
                      <tr>
                        
                        <td style="padding:0px !important;">
                          <a href="{{url('/admin/products/'.$value->id)}}" class="btn btn-warning" target="_blank" title="Edit Product" style="color: white; font-size:15px; font-weight: 600; margin:2px;">
                            <i class="fa fa-edit" style="font-size:16px"></i> View/Edit
                          </a>
                        </td>
                        
                        <td style="padding:0px !important;">
                          <form action="{{url('/admin/products/delete/'.$value->id)}}" method="POST" role="form" id="delform{{$value->id}}">
                            {!! csrf_field() !!}
                            <button type="button" class="btn btn-danger" title="Delete Product" data-toggle="modal" data-target="#modal-delete" onclick="mkeDelModal('{{$value->id}}','{{$value->name}}');" style="color: white; font-size:15px; font-weight: 600; margin:2px;">
                              <i class="fa fa-trash" style="font-size:16px" aria-hidden="true"></i> Delete
                            </button>
                          </form>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="11" align="center">No Results Found!</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
         
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Add new user link -->
    <a href="{{url('/admin/products/create')}}" title="Add New Products">
      <i class="fa fa-plus-circle fa-add-new" aria-hidden="true"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

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
          <h5>Are You Sure ?</h5>
          <p>Do you Really Want to delete this Product.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" onclick="delForm()">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-stock">
    <form action="{{url('/admin/products/stock')}}" method="POST">
      @csrf
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="deltitle">Manage Stock for Product</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="productid" name="productid" value="0">

            <div class="form-group row" >
             <label for="type" class="col-sm-4 col-form-label text-right">Add/Subtract:</label>
              <div class="col-sm-6">
                <select class="form-control" style="width: 100%;" name="type" id="type">
                  <option value="Add" selected>Add Stock</option>
                  <option value="Sub">Minus Stock</option>
                </select>
              </div>
            </div>

            <div class="form-group row">
             <label for="stock_avalible" class="col-sm-4 col-form-label text-right">Add Stock:</label>
              <div class="col-sm-6">
               <input type="number" name="stock_avalible" value="1" class="form-control" placeholder="Enter Stock Number" required min="0">
              </div>
            </div>

          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Add Stock</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <input type="hidden" id="delId"> 
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
  $('#cat_id').select2({
    theme: 'bootstrap4',
    placeholder: "Select Category",
  });

  $('#subcat_id').select2({
    theme: 'bootstrap4',
    placeholder: "Select Sub-Category",
    ajax: {
      url: '{{url('/api/search/subcategory')}}',
      data: function (params) {
        return {
          term: params.term,
          search: 'false',
          cat_id: $('#cat_id').val()
        }
      },
      dataType: 'json',
    }
  });

  function setStatus(status, id) {
    $.ajax({
      type: "GET",
      url: "{{url('/ajax/product/status')}}",
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

  $('#searchBtn').click(function() {
    var url = '{{('/admin/products')}}?status=' + $('#status').val() + '&search=' + $('#search').val() + '&slimit=' + $('#slimit').val() + '&cat_id=' + $('#cat_id').val() + '&subcat_id=' + $('#subcat_id').val() + '&brand_id=' + $('#brand_id').val();
    window.location.href = url;
  });

  $(function () {
    $('.select2bs4').select2({
     theme: 'bootstrap4'
   });
  });


  $('#addChangeBtn').click(function() {
    var error = 0
    if($('#nuser_id').val() == '' || $('#nuser_id').val() == undefined){
     $('#nuser_id').addClass('is-invalid');
     error = 1;
   } else {
     $('#nuser_id').removeClass('is-invalid');
   }

   if($('#npassword').val() == '' || $('#npassword').val() == '0'){
     $('#npassword').addClass('is-invalid');
     error = 1;
   } else {
     $('#npassword').removeClass('is-invalid');
   }

   if(error == 0) {
     $('#addChangeForm').submit();
   }
 });

  function mkeDelModal(id, name) {
    $('#deltitle').html('Delete ' + name);
    $('#delId').val(id);
  }

  function delForm() {
    $('#delform' + $('#delId').val()).submit();
  }
</script>
@endsection
