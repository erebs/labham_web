
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
	</ul>
	<ul class="navbar-nav ml-auto ">
		<li class="nav-item">
			<a class="nav-link" href="#">
				<i class="fa fa-user" aria-hidden="true"></i>
				 &nbsp;{{$authuser->name}}
				</a>
		</li>
		<li class="nav-item" >
			<a class="nav-link" href="{{url('/admin/logout')}}">
				<i class="fas fa-sign-out-alt"></i> &nbsp;Logout
			</a>
		</li>
	</ul>
</nav>
<!-- /.navbar -->