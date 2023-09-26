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
				<div class="row">

					<div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body" style="padding:4px 20px;">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-md font-weight-bold text-primary text-uppercase mb-1" style="    height: 50px;">
                    Total Customers</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                      {{$totalcusts}}
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fa fa-users  fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body" style="padding:4px 20px;">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-md font-weight-bold text-success text-uppercase mb-1" style="    height: 50px;">
                    New Customers</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                      {{$totalncusts}}
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fa fa-user  fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body" style="padding:4px 20px;">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-md font-weight-bold text-warning text-uppercase mb-1" style="    height: 50px;">
                    Total Products</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                      {{$totalproducts}}
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fa fa-boxes  fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body" style="padding:4px 20px;">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-md font-weight-bold text-info text-uppercase mb-1" style="    height: 50px;">
                    Avalible Products</div>
                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                      {{$totalavalibleproducts}}
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fa fa-box  fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-9">
            <div class="row">
              <div class="col-md-6">
                <div class="card card-widget widget-user-2 shadow-sm" >
                  <div class="widget-user-header bg-primary" style="padding: 8px 24px;">
                    <h5 style="margin: 0px;">Orders</h5>
                  </div>
                  <div class="card-footer p-0">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                        <a href="#" class="nav-link text-danger font-weight-bold">
                          New
                          <span class="float-right badge bg-danger" style="width: 40px; font-size: 15px;">{{App\Http\Controllers\AdminOrderController::getCount('New')}}
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link text-warning font-weight-bold">
                          Accepted 
                          <span class="float-right badge bg-warning" style="width: 40px; font-size: 15px;">
                          {{App\Http\Controllers\AdminOrderController::getCount('Accepted')}}
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link text-primary font-weight-bold">
                          Processing
                          <span class="float-right badge bg-primary" style="width: 40px; font-size: 15px;">
                          {{App\Http\Controllers\AdminOrderController::getCount('Processing')}}
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link text-info font-weight-bold">
                          Cancelled
                          <span class="float-right badge bg-info" style="width: 40px; font-size: 15px;">
                          {{App\Http\Controllers\AdminOrderController::getCount('Cancelled')}}
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link text-success font-weight-bold">
                          Delivered
                          <span class="float-right badge bg-success" style="width: 40px; font-size: 15px;">
                          {{App\Http\Controllers\AdminOrderController::getCount('Delivered')}}
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>
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
<style>
	.table-extra th {
    padding: 8px 4px !important;
    vertical-align: middle !important;
	}
</style>
<script>
  function setStatus(status, id) {
		$.ajax({
      type: "GET",
      url: "{{url('/ajax/admin/status')}}",
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

	$( document ).ready(function() {
		$.ajax({
			type: "GET",
			url: "{{url('/api/recharge/corn')}}",
			data: '',
			success: function(data){
			}
		});
	});
</script>
@if(Auth::user()->type == '1')
<script>
	var donutData = {
		labels: [
		'Success',
		'Pending',
		'Failed',
		],
		datasets: [
		{
			data: [{{App\Http\Controllers\AdminAdminController::getRechStatus('Success')}},{{App\Http\Controllers\AdminAdminController::getRechStatus('Pending')}},{{App\Http\Controllers\AdminAdminController::getRechStatus('Failed')}}],
			backgroundColor : ['#28a745', '#f39c12', '#dc3545'],
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
	});

	var donutData2 = {
		labels: [
		'Prepaid',
		'Postpaid',
		'DTH',
		],
		datasets: [
		{
			data: [{{App\Http\Controllers\AdminAdminController::getRechType('Prepaid')}},{{App\Http\Controllers\AdminAdminController::getRechType('PostPaid')}},{{App\Http\Controllers\AdminAdminController::getRechType('DTH')}}],
			backgroundColor : ['#00c0ef', '#3c8dbc', '#d2d6de'],
		}
		]
	}

	var pieChartCanvas = $('#pieChart2').get(0).getContext('2d')
	var pieData        = donutData2;
	var pieOptions     = {
		maintainAspectRatio : false,
		responsive : true,
	}

	new Chart(pieChartCanvas, {
		type: 'pie',
		data: pieData,
		options: pieOptions
	});


	//-------------
  //- BAR CHART -
  //-------------
  <?php
  	$begin = new DateTime(date('Y/m/d',strtotime("-30 days")));
		$end   = new DateTime(date('Y/m/d'));

		for($i = $begin; $i <= $end; $i->modify('+1 day')){
			$date = $i->format("Y-m-d");
			$dateArr[$date] = App\Http\Controllers\AdminAdminController::getRechStatusDate($date, '');
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
          label               : 'No Of Recharges',
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
  // var temp1 = areaChartData.datasets[1]
  // barChartData.datasets[0] = temp1
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

  //-------------
  //- LINE CHART -
  //-------------

  <?php
  	$begin = new DateTime(date('Y/m/d',strtotime("-30 days")));
		$end   = new DateTime(date('Y/m/d'));

		for($i = $begin; $i <= $end; $i->modify('+1 day')){
			$date = $i->format("Y-m-d");
			$dateArr[$date] = App\Http\Controllers\AdminAdminController::getRechStatusDate($date, '');
			$dateArr1[$date] = App\Http\Controllers\AdminAdminController::getRechStatusDate($date, 'Success');
			$dateArr2[$date] = App\Http\Controllers\AdminAdminController::getRechStatusDate($date, 'Failed');
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
          label               : 'Total',
          backgroundColor     : 'rgba(113,122,129,1)',
          borderColor         : 'rgba(113,122,129,0.9)',
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
        },{
          label               : 'Success',
          backgroundColor     : 'rgba(82, 171, 78, 1)',
          borderColor         : 'rgba(82, 171, 78, 0.9)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php
		      	foreach ($dateArr1 as $key => $value) {
		      	 	if($key == date("Y-m-d")) {
		      	 		echo "$value";
		      	 	} else {
		      	 		echo "$value,";
		      	 	}
		    	 	} 
		      ?>]
        },{
          label               : 'Failed',
          backgroundColor     : 'rgba(222, 71, 86, 1)',
          borderColor         : 'rgba(222, 71, 86, 0.9)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php
		      	foreach ($dateArr2 as $key => $value) {
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

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartData.datasets[2].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })

</script>
@endif

@endsection

<!-- PushAlert -->
<script type="text/javascript">
        (function(d, t) {
                var g = d.createElement(t),
                s = d.getElementsByTagName(t)[0];
                g.src = "https://cdn.pushalert.co/integrate_1e336438e51bdc91ad9ad0a5725ad784.js";
                s.parentNode.insertBefore(g, s);
        }(document, "script"));
</script>
<!-- End PushAlert -->