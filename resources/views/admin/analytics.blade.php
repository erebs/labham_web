@extends('admin.layouts.header')

@section('adminheader')
<div class="wrapper">
  @include('admin.layouts.navbar')
  @include('admin.layouts.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @include('admin.layouts.content-header')

    <section class="content">
      <div class="container-fluid">

        <div class="card-body" style="background-color: white; padding: 6px;padding-right: 7.5px;padding-left: 7.5px; margin-bottom: 15px;">
          <div class="row">
            <div class="form-group" style="margin-right: 10px; margin-left: 7px;">
              <label>From Date:</label>
              <div class="input-group date" id="reservationdate" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" id="fdate" data-target="#reservationdate" value="{{$sfdate}}">
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div>
            </div>

            <div class="form-group" style="margin-right: 7px; margin-left: 7px;">
              <label>To Date:</label>
              <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" id="tdate" data-target="#reservationdate1" value="{{$stdate}}">
                <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div>
            </div>

            <div class="form-group" style="margin-right: 7px; margin-left: 10px;">
              <button class="btn btn-primary" id="searchBtn" style="margin-top: 31px;">Search</button>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-12 col-sm-6 col-md-3 col-xxl d-flex">
            <div class="card flex-fill">
              <div class="card-body py-3">
                <div class="media">
                  <div class="media-body">
                    <h2 class="mb-2 text-primary">{{$totalorders}}</h2>
                    <p class="mb-2 fw-600 text-primary">Total Orders</p>
                  </div>
                  <div class="d-inline-block ml-3">
                    <div class="stat">
                      <i class="nav-icon fa fa-list-ol text-primary" style="font-size: 23px"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 col-xxl d-flex">
            <div class="card flex-fill">
              <div class="card-body py-3">
                <div class="media">
                  <div class="media-body">
                    <h2 class="mb-2 text-success">{{$totaldorders}}</h2>
                    <p class="mb-2 fw-600 text-success">Delivered Orders</p>
                  </div>
                  <div class="d-inline-block ml-3">
                    <div class="stat">
                      <i class="nav-icon fa fa-list-ol text-success" style="font-size: 23px"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 col-xxl d-flex">
            <div class="card flex-fill">
              <div class="card-body py-3">
                <div class="media">
                  <div class="media-body">
                    <h2 class="mb-2 text-danger">{{$totalcorders}}</h2>
                    <p class="mb-2 fw-600 text-danger">Cancelled Orders</p>
                  </div>
                  <div class="d-inline-block ml-3">
                    <div class="stat">
                      <i class="nav-icon fa fa-list-ol text-danger" style="font-size: 23px"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 col-xxl d-flex">
            <div class="card flex-fill">
              <div class="card-body py-3">
                <div class="media">
                  <div class="media-body">
                    <h2 class="mb-2 text-warning"></h2>
                    <p class="mb-2 fw-600 text-warning">Total Sellers</p>
                  </div>
                  <div class="d-inline-block ml-3">
                    <div class="stat">
                      <i class="nav-icon fa fa-users-cog text-warning" style="font-size: 23px"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 col-xxl d-flex">
            <div class="card flex-fill">
              <div class="card-body py-3">
                <div class="media">
                  <div class="media-body">
                    <h2 class="mb-2 text-info">{{$customers}}</h2>
                    <p class="mb-2 fw-600 text-info">Total Customers</p>
                  </div>
                  <div class="d-inline-block ml-3">
                    <div class="stat">
                      <i class="nav-icon fa fa-users text-info" style="font-size: 23px"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 col-xxl d-flex">
            <div class="card flex-fill">
              <div class="card-body py-3">
                <div class="media">
                  <div class="media-body">
                    <h2 class="mb-2 text-success">{{$totaldproducts}}</h2>
                    <p class="mb-2 fw-600 text-success">Total Products Delivered</p>
                  </div>
                  <div class="d-inline-block ml-3">
                    <div class="stat">
                      <i class="nav-icon fa fa-boxes text-success" style="font-size: 23px"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 col-xxl d-flex">
            <div class="card flex-fill">
              <div class="card-body py-3">
                <div class="media">
                  <div class="media-body">
                    <h2 class="mb-2 text-danger">{{$totalcproducts}}</h2>
                    <p class="mb-2 fw-600 text-danger">Total Products Cancelled</p>
                  </div>
                  <div class="d-inline-block ml-3">
                    <div class="stat">
                      <i class="nav-icon fa fa-boxes text-danger" style="font-size: 23px"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 col-xxl d-flex">
            <div class="card flex-fill">
              <div class="card-body py-3">
                <div class="media">
                  <div class="media-body">
                    <h2 class="mb-2 text-success">{{$totalamount}}</h2>
                    <p class="mb-2 fw-600 text-success">Total Amount</p>
                  </div>
                  <div class="d-inline-block ml-3">
                    <div class="stat">
                      <i class="nav-icon fa fa-rupee-sign text-success" style="font-size: 25px; padding-left: 5px;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-xxl d-flex">
            <div class="card card-danger" style="width:100%;">
              <div class="card-header">
                <h3 class="card-title">Order Report</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 605px;" width="605" height="250" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-6 col-xxl d-flex">
            <div class="card card-danger" style="width:100%;">
              <div class="card-header">
                <h3 class="card-title">Payment Report</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                <canvas id="pieChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 605px;" width="605" height="250" class="chartjs-render-monitor"></canvas>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Order History for Last 30 days</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>



        </div>
      </div>
    </section>

  </div>
</div>
<!-- /.content-wrapper -->
@include('admin.layouts.footer')
@include('admin.layouts.js')

<script>
  $('#searchBtn').click(function() {
    var url = '{{url('/admin/analytics')}}?fdate=' + $('#fdate').val()+'&tdate=' + $('#tdate').val();
    window.location.href = url;
  });

  $('#reservationdate, #reservationdate1').datetimepicker({
    format: 'L'
  });

  var donutData = {
    labels: [
        'Total Orders',
        'Delivered',
        'Cancelled'
    ],
    datasets: [
      {
        data: [ {{$totalorders}}, {{$totaldorders}}, {{$totalcorders}} ],
        backgroundColor : ['#007bff', '#28a745', '#dc3545'],
      }
    ]
  }

  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieData        = donutData;
  var pieOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }

  new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  })

  var donutData = {
    labels: [
        'Pending',
        'Success',
        'Failed'
    ],
    datasets: [
      {
        data: [ {{$totalpporders}}, {{$totalpsorders}}, {{$totalpforders}} ],
        backgroundColor : ['#007bff', '#28a745', '#dc3545'],
      }
    ]
  }

  var pieChartCanvas = $('#pieChart2').get(0).getContext('2d')
  var pieData        = donutData;
  var pieOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }

  new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  })

  <?php
    $begin = new DateTime(date('Y/m/d',strtotime("-30 days")));
    $end   = new DateTime(date('Y/m/d'));

    for($i = $begin; $i <= $end; $i->modify('+1 day')){
      $date = $i->format("Y-m-d");
      $dateArr[$date] = App\Http\Controllers\AdminController::getOrderReport($date);
    }

  ?>

  var areaChartData = {
    labels  : [<?php
      foreach ($dateArr as $key => $value) {
        if($key == date("Y-m-d")) {
          echo "'$key'";
        } else {
          echo "'$key',";
        }
      } 
    ?>],
    datasets: [
      {
        label               : 'No Of Orders/day',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [<?php
          foreach ($dateArr as $key => $value) {
            if($key == date("Y-m-d")) {
              echo "$value";
            } else {
              echo "$value,";
            }
          } 
        ?>]
      }
    ]
  }


  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChartData = $.extend(true, {}, areaChartData)
  var temp0 = areaChartData.datasets[0]
  barChartData.datasets[0] = temp0

  var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
  }

  new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  })


</script>

@endsection

