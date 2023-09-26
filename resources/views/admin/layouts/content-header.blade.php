<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark"><?php echo $contentHeader ?? 'DashBoard'; ?></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					@if(isset($contentHeader) && $contentHeader != 'Dashboard')
						<li class="breadcrumb-item"><a href="/admin">DashBoard</a></li>
					@else
						<li class="breadcrumb-item">DashBoard</li>
					@endif
					@if(isset($contentHeader) && isset($contentSubHeader) && $contentHeader != 'Dashboard')
						<li class="breadcrumb-item active">
							<a href="{{url('/admin')}}/{{ strtolower($contentHeader) }}">{{$contentHeader}}</a>
						</li>
					@elseif(isset($contentHeader) && $contentHeader != 'Dashboard')
						<li class="breadcrumb-item active">{{$contentHeader}}</li>
					@endif
					@if(isset($contentSubHeader))
						<li class="breadcrumb-item active">{{$contentSubHeader}}</li>
					@endif
				</ol>
		</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->