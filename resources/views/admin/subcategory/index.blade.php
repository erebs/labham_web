@extends('admin.layouts.header')

@section('adminheader')
<div class="wrapper">
  @include('admin.layouts.navbar')
  @include('admin.layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('admin.layouts.content-header')
   <!--  <div class="row m-20">
      <div class="col-sm-3">
        <select id="cats_id" class="form-control" style="width: 100%;">
          <option value="All">Select Category</option>
          @foreach($cats as $id => $name)
            <option value="{{$id}}" @if($cats_id == $id) selected @endif >{{$name}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-sm-3">
        <input type="text" id="search" placeholder="Search Sub-Category..." value="{{ $search }}" class="form-control">
      </div>

      <div class="col-sm-1">
        <input type="button" id="searchBtn" class="btn btn-primary" value="Search">
      </div>
    </div> -->

    <div class="row m-20">
      <div class="col-md-12">
        <div class="card card-primary">
          <!-- <div class="card-header">
            <h3 class="card-title">Sub-Category List</h3>
          </div> -->
          <div class="card-body">
            <table class="table table-striped" id="example" style="width:100%">
              <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>No of Products</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @if(count($categories) > 0)
                  @foreach($categories as $key => $value)
                  <tr>
                    <td align="center">{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>
                      @if(isset($cats[$value->cat_id]))
                        {{$cats[$value->cat_id]}}
                      @endif
                    </td>
                    <?php $count = App\Http\Controllers\AdminCategoryController::countSubCatProducts($value->id); ?>
                    <td align="center">{{$count}}</td>
                    <td align="center">
                      <div class="row">
                        <div class="col-sm-6" align="right">
                          <a href="" class="btn btn-sm btn-warning" title="Edit Sub-Category" data-toggle="modal" data-target="#modal-add" onclick='mkeEditForm("{{$value->id}}", "{{$value->cat_id}}", "{{$value->name}}")' style="color: white;">
                            <i class="fa fa-edit" style="font-size:16px"></i> <b>Edit</b>
                          </a>
                        </div>
                        <div class="col-sm-6" align="left">
                          <form action="{{url('/admin/subcategory/delete/'.$value->id)}}" method="POST" role="form" id="delform{{$value->id}}">
                            {!! csrf_field() !!}
                            <button type="button" class="btn btn-sm btn-danger" title="Delete Sub-Category" data-toggle="modal" data-target="#modal-delete" onclick='mkeDelModal("{{$value->id}}","{{$value->name}}");' @if($count > 0) disabled @endif >
                              <i class="fa fa-trash" style="font-size:16px" aria-hidden="true"></i> <b>Delete</b>
                            </button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
                            
                  @endforeach
                @else
                  <tr>
                    <td colspan="6" align="center">No Results Found!</td>
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
    <!-- Add new Banner link -->
    <a href="" data-toggle="modal" data-target="#modal-add" title="Add New Sub-Category" onclick="mkeAddForm();">
      <i class="fa fa-plus-circle fa-add-new" aria-hidden="true"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <!-- banner add model -->
  <div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{url('/admin/subcategory/create')}}" method="POST" id="addform" role="form" enctype="multipart/form-data">
          {!! csrf_field() !!}
          <input type="hidden" name="id" id="id" value="">

          <div class="modal-header">
            <h4 class="modal-title" id="bannerHeading">Add New Sub-Category</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
            <div class="card-body">
              <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-right">Category*:</label>
                <div class="col-sm-7">
                  <select id="cat_id" name="cat_id" class="form-control" style="width: 100%;">
                    <option value="" selected>Select Sub-Category</option>
                    @foreach($cats as $id => $name)
                      <option value="{{$id}}">{{$name}}</option>
                    @endforeach
                  </select>
                  <span class="invalid-feedback">Please select Category.</span>
                </div>
              </div>

              <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label text-right">Name*:</label>
                <div class="col-sm-7">
                  <input class="form-control" placeholder="Enter Sub-Category Name" name="name" type="text" value="" id="name">
                  <span class="invalid-feedback">Please enter Sub-Category Name.</span>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-6 offset-sm-3">
                  <img id="showImage" class="img-thumbnail hide" width="50%" height="auto" style="min-width:140px;">
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input class="btn btn-primary offset-sm-2" type="button" onclick="validate();" value="Save">
          </div>
        </form>
      </div>
    </div>
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
          <h5>Are You Sure ?</h5>
          <p>If you Delete this Sub-Category, All Products Associated with it may be Effected.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" onclick="delCategory()">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <input type="hidden" id="delId">
  
  @include('admin.layouts.footer')
</div>
@include('admin.layouts.js')
@include('admin.layouts.messages')
<style>
  .table-extra td {
    padding: 0.4rem!important;
  }
</style>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  $('#searchBtn').click(function() {
    var url = '{{url('/admin/subcategory')}}?search=' + $('#search').val() + '&cats_id=' + $('#cats_id').val();
    window.location.href = url;
  });


  $('#cats_id').select2({
    theme: 'bootstrap4',
    placeholder: 'Select Category'
  })


  function mkeAddForm() {
    $('#addform').attr('action', '{{url('/admin/subcategory/create')}}');
    $('#name,#id').val('');
    $('#bannerHeading').html('Add New Sub-Category');
    $('#name').removeClass('is-invalid');
    $('#cat_id').val('');
  }

  function mkeEditForm(id, cat_id, name) {
    $('#name').removeClass('is-invalid');
    $('#addform').attr('action', '{{url('/admin/subcategory/update')}}');
    $('#bannerHeading').html('Update Sub-Category');
    $('#id').val(id);
    $('#name').val(name);
    $('#cat_id').val(cat_id);
  }


  function validate() {
    var error = 0;
    if($('#cat_id').val() == '' || $('#cat_id').val() == null) {
      $('#cat_id').addClass('is-invalid');
      error = 1;
    } else {
      $('#cat_id').removeClass('is-invalid');
    }

    if($('#name').val() == '') {
      $('#name').addClass('is-invalid');
      error = 1;
    } else {
      $('#name').removeClass('is-invalid');
    }

    if(error == 0) {
      $('#addform').submit();
    }
  }

  function mkeDelModal(id, name) {
    $('#deltitle').html('Delete ' + name);
    $('#delId').val(id);
  }

  function delCategory() {
    $('#delform'+$('#delId').val()).submit();
  }
</script>
@if(isset($_GET['o']) && $_GET['o'] == '1')
<script>
  $('#modal-add').modal('show');
</script>
@endif
@endsection