@extends('admin.layouts.header')

@section('adminheader')
<div class="wrapper">
  @include('admin.layouts.navbar')
  @include('admin.layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('admin.layouts.content-header')
    <div class="row m-20">
      <div class="col-sm-4">
        <input type="text" id="search" placeholder="Search Something Here..." value="{{ $search }}" class="form-control">
      </div>

      <div class="col-sm-1">
        <input type="button" id="searchBtn" class="btn btn-primary" value="Search">
      </div>
    </div>

    <div class="row m-20">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Notifications List</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-bordered table-extra">
              <thead>
              <tr>
                <th>Heading</th>
                <th>Sub-Heading</th>
                <th>URL</th>
                <th>Created On</th>
                <th>Actions</th>
              </tr>
              </thead>
              <tbody>
                @if(count($notifications) > 0)
                  @foreach($notifications as $key => $value)
                  <tr>
                    <td>{{$value->title}}</td>
                    <td>{{$value->sub_title}}</td>
                    <td>{{$value->url}}</td>
                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('y M d H:i') }}</td>
                    <td align="center">
                      <form action="{{url('/admin/notifications/delete/'.$value->id)}}" method="POST" role="form" id="delform{{$value->id}}">
                        {!! csrf_field() !!}
                        <button type="button" class="btn btn-danger" title="Delete Notification" data-toggle="modal" data-target="#modal-delete" onclick="mkeDelModal('{{$value->id}}', 'Notifications');">
                          <i class="fa fa-trash" style="font-size:16px" aria-hidden="true"></i> <b>Delete</b>
                        </button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="5" align="center">No Results Found</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix ">
            @if(count($notifications) > 0)
              {{$notifications->appends( array("q" => $search))->links()}}
            @endif
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Add new Banner link -->
    <a href="" data-toggle="modal" data-target="#modal-add" title="Add New Banner" onclick="mkeAddForm();">
      <i class="fa fa-plus-circle fa-add-new" aria-hidden="true"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <!-- banner add model -->
  <div class="modal fade" id="modal-add">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <form action="{{url('/admin/notifications/create')}}" method="POST" id="addform" role="form" enctype="multipart/form-data">
          {!! csrf_field() !!}
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="imageOld" id="imageOld" value="">

          <div class="modal-header">
            <h4 class="modal-title" id="bannerHeading">Add New Notification</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
            <div class="card-body">
              <div class="form-group row">
                <label for="heading" class="col-sm-3 col-form-label text-right">Heading:</label>
                <div class="col-sm-9">
                  <textarea class="form-control" placeholder="Enter Notification Heading" name="heading" id="heading" rows="2"></textarea>
                  <span class="invalid-feedback">Please enter Notification Heading.</span>
                </div>
              </div>

              <div class="form-group row">
                <label for="sub_heading" class="col-sm-3 col-form-label text-right">Sub-Heading:</label>
                <div class="col-sm-9">
                  <textarea class="form-control" placeholder="Enter Notification Sub-Heading" name="sub_heading" id="sub_heading" rows="3"></textarea>
                  <span class="invalid-feedback">Please enter Sub-Heading.</span>
                </div>
              </div>

              <div class="form-group row">
                <label for="url" class="col-sm-3 col-form-label text-right">URL:</label>
                <div class="col-sm-9">
                  <input class="form-control" placeholder="Enter Notification URL" name="url" type="text" value="{{url('/')}}" id="url">
                  <span class="invalid-feedback">Please enter Notification URL.</span>
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
          <p>Do you want to Delete this Notification.</p>
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
<script>
  $('#searchBtn').click(function() {
    var url = '/admin/notifications?q=' + $('#search').val();
    window.location.href = url;
  });

  $(function () {
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });


  function validate() {
    var error = 0;
    if($('#heading').val() == '') {
      $('#heading').addClass('is-invalid');
      error = 1;
    } else {
      $('#heading').removeClass('is-invalid');
    }

    if($('#sub_heading').val() == '') {
      $('#sub_heading').addClass('is-invalid');
      error = 1;
    } else {
      $('#sub_heading').removeClass('is-invalid');
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

@endsection