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
					<h3 class="card-title">Settings</h3>
				</div>
				<!-- form start -->
				<form action="/admin/setsettings" method="POST" role="form" id="addForm" enctype="multipart/form-data">
    @csrf
				<div class="card-body">

          

         

					<div class="form-group row">
						<label for="name" class="col-sm-3 col-form-label text-right">Bank Name :</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" placeholder="Enter bank" name="bank" id="bank" value="{{$settings->bank}}">
							<div id="name-span" class="invalid-feedback">Bank Name Required.</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-sm-3 col-form-label text-right">Beneficiary :</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" placeholder="Enter beneficiary Name" name="beneficiary" id="beneficiary" value="{{$settings->name}}">
							<div id="name-span" class="invalid-feedback">Beneficiary Name Required.</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-sm-3 col-form-label text-right">Account Number :</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" placeholder="Enter Account Number" name="acc" id="acc" value="{{$settings->account_num}}">
							<div id="name-span" class="invalid-feedback">Account Number Required.</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="name" class="col-sm-3 col-form-label text-right">IFSC Code :</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" placeholder="Enter IFSC Code" name="ifsc" id="ifsc" value="{{$settings->ifsc_code}}">
							<div id="name-span" class="invalid-feedback">IFSC Code Required.</div>
						</div>
					</div>

					

					

					

					
					

					

					

					
								
				</div>

				<div class="card-footer">
					<a class="btn btn-default offset-sm-3" href="{{url('/admin')}}">Back</a>&emsp;
					<button type="button" id="addBtn" class="btn btn-primary"> Save </button>
				</div>
				<!-- /.card-body -->
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

 

	$('#addBtn').click(function() {
		var error = 0


		if($('#bank').val() == ''){
			$('#bank').addClass('is-invalid');
			error = 1;
		} else {
			$('#bank').removeClass('is-invalid');
		}

		if($('#beneficiary').val() == ''){
			$('#beneficiary').addClass('is-invalid');
			error = 1;
		} else {
			$('#beneficiary').removeClass('is-invalid');
		}

			if($('#acc').val() == ''){
			$('#acc').addClass('is-invalid');
			error = 1;
		} else {
			$('#acc').removeClass('is-invalid');
		}

		if($('#ifsc').val() == ''){
			$('#ifsc').addClass('is-invalid');
			error = 1;
		} else {
			$('#ifsc').removeClass('is-invalid');
		}

		

		if(error == 0) {
			$('#addForm').submit();
		}
	});
</script>
@endsection

