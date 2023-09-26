@extends('layouts.Frontend')
@section('title')
 categories
  @endsection 
 
@section('contentss')
	<!-- sidebar end  -->
	<!-- category section  -->
	<div class="category-main" style="background-image: url('{{ asset('frontend/images/category-bg-main.png') }}');background-repeat: no-repeat;background-size: 100% auto;padding: 3% 0 3% 0;background-position: center;background-repeat: no-repeat;background-size: cover;height: -webkit-fill-available;">
		<div class="container-main">
			<h1 class="text-center text-white category-main-head">Explore Tiles by categories</h1>
			<div class="row">


				@foreach($cat as $c)
				<div class="col-lg-3 col-md-4 col-sm-6 col-6" onclick="window.location.href='/v1/category-products/{{encrypt($c->id)}}'" style="cursor:pointer;">
					<div class="inner-col-category">
						<img src="{{url($c->image)}}" alt="caregory-image">
						<!-- <h4 class="category-name text-white">{{$c->name}}</h4> -->
					</div>
					<center>
					<h4 class="category-name text-white">{{$c->name}}</h4>
					</center>

				</div>
				@endforeach
				
				
				
			</div>
		</div>
	</div>
	@endsection