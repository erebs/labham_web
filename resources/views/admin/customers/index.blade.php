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
        <input type="text" id="search" placeholder="Search Customers Name or Number" value="{{ $search }}" class="form-control">
      </div>

      <div class="col-sm-1">
        <input type="button" id="searchBtn" class="btn btn-primary" value="Search">
      </div>
    </div>

    <div class="row m-20">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Customers List</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-bordered table-extra">
              <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Join On</th>
              </tr>
              </thead>
              <tbody>
                @if(count($customers) > 0)
                  @foreach($customers as $key => $value)
                  <tr>
                    <td align="center">{{$value->id}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->phone}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{ \Carbon\Carbon::parse($value->join_on)->format('y-M-d H:i') }}</td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="6" align="center">No Customers Found</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix ">
            @if(count($customers) > 0)
              {{$customers->appends( array("q" => $search))->links()}}
            @endif
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  @include('admin.layouts.footer')
</div>
@include('admin.layouts.js')
@include('admin.layouts.messages')
<script>
  $('#searchBtn').click(function() {
    var url = '/admin/customers?q=' + $('#search').val();
    window.location.href = url;
  });

  $(function () {
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });

</script>
@endsection