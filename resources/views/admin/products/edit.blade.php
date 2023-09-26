@extends('admin.layouts.header')

@section('adminheader')
@include('admin.layouts.navbar')
@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  @include('admin.layouts.content-header')
  <div class="row m-10">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Update Product</h3>
        </div>
        <!-- form start -->
        <form action="{{ action('AdminProductsController@update', $product->id) }}" method="POST" role="form" id="quickForm" enctype="multipart/form-data">
    @csrf
        <div class="card-body">

          <div class="form-group row" >
            <label for="shopid" class="col-sm-3 col-form-label text-right">Category :</label>

            <div class="col-sm-6">
              <select class="form-control" style="width: 100%;" name="cat_id" id="cat_id">
                <option value="">Select Category</option>
                @if($category)
                  @foreach($category as $id => $name)
                    <option value="{{$id}}" @if($product->cat_id == $id) selected @endif >{{$name}}</option>
                  @endforeach
                @endif
              </select>
              <div class="invalid-feedback">Product Category Required.</div>
            </div>
            <div class="col-sm-3">
              <a class="btn btn-light btn-link" href="{{url('/admin/category?o=1')}}" target="_blank">
                Add New Category
              </a>
            </div>
          </div>

        <!--   <div class="form-group row" >
            <label for="subcat_id" class="col-sm-3 col-form-label text-right">Sub-Category :</label>

            <div class="col-sm-6">
              <select class="form-control" style="width: 100%;" name="subcat_id" id="subcat_id">
                <option value="">Select Sub-Category</option>
                @if($subcategory)
                  @foreach($subcategory as $id => $name)
                    <option value="{{$id}}" @if($product->subcat_id == $id) selected @endif >{{$name}}</option>
                  @endforeach
                @endif
              </select>
              <div class="invalid-feedback">Product Category Required.</div>
            </div>
            <div class="col-sm-3">
              <a class="btn btn-light btn-link" href="{{url('/admin/subcategory?o=1')}}" target="_blank">
                Add New Sub-Category
              </a>
            </div>
          </div> -->

          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label text-right">Name :</label>

            <div class="col-sm-6">
              <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Enter Product Name">

              <div id="name-span" class="invalid-feedback">Product Name Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="desc" class="col-sm-3 col-form-label text-right">Description :</label>
            <div class="col-sm-6">
              <textarea class="form-control" placeholder="Enter Product Description" name="desc" id="desc" type="text" rows="3">{{$product->desc}}</textarea>
              <div class="invalid-feedback">Description Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="price" class="col-sm-3 col-form-label text-right">Default Price :</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Enter Product Price" name="price" id="price" value="{{$product->price}}">
              <div class="invalid-feedback">Product Price Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="price" class="col-sm-3 col-form-label text-right">Offer Price :</label>
            <div class="col-sm-6">
              <input type="number" class="form-control" placeholder="Enter Offer Product Price" name="offerprice" id="offerprice"  value="{{$product->offerprice}}">
              <div class="invalid-feedback">Product Offer Price Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="best_seller" class="col-sm-3 col-form-label text-right">Show in Best Seller :</label>
            <div class="col-sm-6">
              <div class="form-check form-check-inline" style="margin-top: 8px;">
                <input class="form-check-input" type="radio" name="best_seller" id="best_seller1" value="1" @if($product->best_seller == '1') checked @endif >
                <label class="form-check-label" for="best_seller1">Yes</label>
              </div>
              <div class="form-check form-check-inline" style="margin-top: 8px;">
                <input class="form-check-input" type="radio" name="best_seller" id="best_seller2" value="0" @if($product->best_seller == '0') checked @endif >
                <label class="form-check-label" for="best_seller2">No</label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="featured" class="col-sm-3 col-form-label text-right">Show in Featured :</label>
            <div class="col-sm-6">
              <div class="form-check form-check-inline" style="margin-top: 8px;">
                <input class="form-check-input" type="radio" name="featured" id="featured1" value="1" @if($product->featured == '1') checked @endif >
                <label class="form-check-label" for="featured1">Yes</label>
              </div>
              <div class="form-check form-check-inline" style="margin-top: 8px;">
                <input class="form-check-input" type="radio" name="featured" id="featured2" value="0" @if($product->featured == '0') checked @endif >
                <label class="form-check-label" for="featured2">No</label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="trending" class="col-sm-3 col-form-label text-right">Show in Trending :</label>
            <div class="col-sm-6">
              <div class="form-check form-check-inline" style="margin-top: 8px;">
                <input class="form-check-input" type="radio" name="trending" id="trending1" value="1" @if($product->trending == '1') checked @endif >
                <label class="form-check-label" for="trending1">Yes</label>
              </div>
              <div class="form-check form-check-inline" style="margin-top: 8px;">
                <input class="form-check-input" type="radio" name="trending" id="trending2" value="0" @if($product->trending == '0') checked @endif >
                <label class="form-check-label" for="trending2">No</label>
              </div>
            </div>
          </div>


          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label text-right">Status :</label>

            <div class="col-sm-6">
              <select class="form-control select2bs4" style="width: 100%;" name="status" id="status">
                <option value="">Select Status</option>
                <option value="Available" @if($product->status == 'Available') selected @endif >Available</option>
                <option value="Not Available" @if($product->status == 'Not Available') selected @endif >Not Available</option>
              </select>
              <div class="invalid-feedback">Product Status Required.</div>
            </div>
          </div>

          <div class="form-group row">
            <label for="image" class="col-sm-3 col-form-label text-right">Product Image :</label>
            <div class="col-sm-6 col-10">
              <div class="input-group">
                <div class="custom-file">
                  <input class="custom-file-input" id="image" name="image" type="file">
                  <input id="imageOld" name="imageOld" type="hidden" value="{{$product->image}}">
                  <label class="custom-file-label" for="image">Choose file</label>
                </div>
              </div>
              <span class="error span-extra hide text-danger" id="helpimage"></span>
            </div>

            <div class="col-sm-1 col-2">
              <button type="button" class="btn btn-secondary btn-tooltip float-left" data-toggle="tooltip" data-placement="top" title="Product in Aspect Ratio of 4:5 Required. ie Image with Resolution 200 x 250px, 300 x 375px etc.">
                <i class="fa fa-info" aria-hidden="true"></i>
              </button>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-sm-3 offset-sm-3">
              <img id="showimage"  class="img-thumbnail <?php if($product->image == '') echo 'hide'; ?>" src="{{url($product->image)}}" width="75%" height="auto" style="min-width:140px;">
            </div>
          </div>

          <div class="form-group row">
            <label for="image2" class="col-sm-3 col-form-label text-right">Product Image2 :</label>
            <div class="col-sm-6 col-10">
              <div class="input-group">
                <div class="custom-file">
                  <input class="custom-file-input" id="image2" name="image2" type="file">
                  <input id="imageOld2" name="imageOld2" type="hidden" value="{{$product->image2}}">
                  <label class="custom-file-label" for="image2">Choose file</label>
                </div>
              </div>
              <span class="error span-extra hide text-danger" id="helpimage2"></span>
            </div>

            <div class="col-sm-1 col-2">
              <button type="button" class="btn btn-secondary btn-tooltip float-left" data-toggle="tooltip" data-placement="top" title="Product in Aspect Ratio of 4:5 Required. ie Image with Resolution 200 x 250px, 300 x 375px etc.">
                <i class="fa fa-info" aria-hidden="true"></i>
              </button>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-sm-3 offset-sm-3">
              <img id="showimage2"  class="img-thumbnail <?php if($product->image2 == '') echo 'hide'; ?>" src="{{url($product->image2)}}" width="75%" height="auto" style="min-width:140px;">
            </div>
          </div>


          <div class="form-group row">
            <label for="image3" class="col-sm-3 col-form-label text-right">Product Image3 :</label>
            <div class="col-sm-6 col-10">
              <div class="input-group">
                <div class="custom-file">
                  <input class="custom-file-input" id="image3" name="image3" type="file">
                  <input id="imageOld3" name="imageOld3" type="hidden" value="{{$product->image3}}">
                  <label class="custom-file-label" for="image3">Choose file</label>
                </div>
              </div>
              <span class="error span-extra hide text-danger" id="helpimage3"></span>
            </div>

            <div class="col-sm-1 col-2">
              <button type="button" class="btn btn-secondary btn-tooltip float-left" data-toggle="tooltip" data-placement="top" title="Product in Aspect Ratio of 4:5 Required. ie Image with Resolution 200 x 250px, 300 x 375px etc.">
                <i class="fa fa-info" aria-hidden="true"></i>
              </button>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-sm-3 offset-sm-3">
              <img id="showimage3"  class="img-thumbnail <?php if($product->image3 == '') echo 'hide'; ?>" src="{{url($product->image3)}}" width="75%" height="auto" style="min-width:140px;">
            </div>
          </div>


          <div class="form-group row">
            <label for="image4" class="col-sm-3 col-form-label text-right">Product Image4 :</label>
            <div class="col-sm-6 col-10">
              <div class="input-group">
                <div class="custom-file">
                  <input class="custom-file-input" id="image4" name="image4" type="file">
                  <input id="imageOld4" name="imageOld4" type="hidden" value="{{$product->image4}}">
                  <label class="custom-file-label" for="image4">Choose file</label>
                </div>
              </div>
              <span class="error span-extra hide text-danger" id="helpimage4"></span>
            </div>

            <div class="col-sm-1 col-2">
              <button type="button" class="btn btn-secondary btn-tooltip float-left" data-toggle="tooltip" data-placement="top" title="Product Image in Aspect Ratio of 1:1 Required. ie Image with Resolution 500 x 500px, 300 x 300px etc.">
                <i class="fa fa-info" aria-hidden="true"></i>
              </button>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-sm-3 offset-sm-3">
              <img id="showimage4"  class="img-thumbnail <?php if($product->image4 == '') echo 'hide'; ?>" src="{{url($product->image4)}}" width="75%" height="auto" style="min-width:140px;">
            </div>
          </div>
                
        </div>

        <div class="card-footer">
          <a class="btn btn-default offset-sm-3" href="{{url('/admin/products')}}">Back</a>&emsp;
          <button type="button" id="addBtn" class="btn btn-primary"> Save </button>
        </div>
        <!-- /.card-body -->
         @method('PUT')
       </form>
      </div>
      <!-- /.card -->
    </div>
  </div>
</div>
<!-- /.content-wrapper -->
@include('admin.layouts.footer')
@include('admin.layouts.js')
<script>

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

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
  
  var _URL = window.URL || window.webkitURL;
  $('#image').change(function (e) {
    readURL(this, '1');
    $('#image-error').addClass('hide');
    $('#showimage').removeClass('hide');
    var file, img;
    if ((file = this.files[0])) {
      img = new Image();
      img.onload = function () {
        var res = this.width/this.height;
        if (res < 0.80 || res > 1.20) {
          $('#image').addClass('is-invalid').val('');
          $('#showimage').addClass('hide');
          $('#helpimage').html('Product Image in Aspect Ratio of 1:1 Required. ie Image with Resolution 500 x 500px, 300 x 300px etc.').removeClass('hide');
        } else {
          $('#image').removeClass('is-invalid');
          $('#showimage').removeClass('hide');
          $('#helpimage').html('').addClass('hide');
        }
      };
      img.src = _URL.createObjectURL(file);
    }
  });

  $('#image2').change(function (e) {
    readURL(this, '2');
    $('#image-error').addClass('hide');
    $('#showimage2').removeClass('hide');
    var file, img;
    if ((file = this.files[0])) {
      img = new Image();
      img.onload = function () {
        var res = this.width/this.height;
        if (res < 0.80 || res > 1.20) {
          $('#image2').addClass('is-invalid').val('');
          $('#showimage2').addClass('hide');
          $('#helpimage2').html('Product Image in Aspect Ratio of 1:1 Required. ie Image with Resolution 500 x 500px, 300 x 300px etc.').removeClass('hide');
        } else {
          $('#image2').removeClass('is-invalid');
          $('#showimage2').removeClass('hide');
          $('#helpimage2').html('').addClass('hide');
        }
      };
      img.src = _URL.createObjectURL(file);
    }
  });

  $('#image3').change(function (e) {
    readURL(this, '3');
    $('#image-error').addClass('hide');
    $('#showimage3').removeClass('hide');
    var file, img;
    if ((file = this.files[0])) {
      img = new Image();
      img.onload = function () {
        var res = this.width/this.height;
        if (res < 0.80 || res > 1.20) {
          $('#image3').addClass('is-invalid').val('');
          $('#showimage3').addClass('hide');
          $('#helpimage3').html('Product Image in Aspect Ratio of 1:1 Required. ie Image with Resolution 500 x 500px, 300 x 300px etc.').removeClass('hide');
        } else {
          $('#image3').removeClass('is-invalid');
          $('#showimage3').removeClass('hide');
          $('#helpimage3').html('').addClass('hide');
        }
      };
      img.src = _URL.createObjectURL(file);
    }
  });

  $('#image4').change(function (e) {
    readURL(this, '4');
    $('#image-error').addClass('hide');
    $('#showimage4').removeClass('hide');
    var file, img;
    if ((file = this.files[0])) {
      img = new Image();
      img.onload = function () {
        var res = this.width/this.height;
        if (res < 0.80 || res > 1.20) {
          $('#image4').addClass('is-invalid').val('');
          $('#showimage4').addClass('hide');
          $('#helpimage4').html('Product Image in Aspect Ratio of 1:1 Required. ie Image with Resolution 500 x 500px, 300 x 300px etc.').removeClass('hide');
        } else {
          $('#image4').removeClass('is-invalid');
          $('#showimage4').removeClass('hide');
          $('#helpimage4').html('').addClass('hide');
        }
      };
      img.src = _URL.createObjectURL(file);
    }
  });


  function readURL(input, type) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        if(type == 1) {
          $('#showimage').attr('src', e.target.result);
        } else if(type == 2) {
          $('#showimage2').attr('src', e.target.result);
        } else if(type == 3) {
          $('#showimage3').attr('src', e.target.result);
        } else if(type == 4) {
          $('#showimage4').attr('src', e.target.result);
        }
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $('#cat_id').select2({
    theme: 'bootstrap4',
    placeholder: "Select Category",
  });

$('#addBtn').click(function() {
    var error = 0

    if($('#cat_id').val() == '' || $('#cat_id').val() == null){
      $('#cat_id').addClass('is-invalid');
      error = 1;
    } else {
      $('#cat_id').removeClass('is-invalid');
    }

    if($('#name').val() == ''){
      $('#name').addClass('is-invalid');
      error = 1;
    } else {
      $('#name').removeClass('is-invalid');
    }

    if($('#status').val() == ''){
      $('#status').addClass('is-invalid');
      error = 1;
    } else {
      $('#status').removeClass('is-invalid');
    }

    if($('#image').val() == '' && $('#imageOld').val() == ''){
      $('#image').addClass('is-invalid');
      $('#helpimage').removeClass('hide').html('Product Image Required.');
      error = 1;
    } else {
      $('#image').removeClass('is-invalid');
      $('#helpimage').addClass('hide').html('');
    }

    if(error == 0) {
      $('#quickForm').submit();
    }
  });
</script>
@endsection

