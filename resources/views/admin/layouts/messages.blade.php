@if(Session::has('success'))
	<script>
		toastr.success('{{Session::get('success')}}')
	</script>
@endif

@if(Session::has('error'))
	<script>
		toastr.error('{{Session::get('error')}}')
	</script>
@endif

@if(Session::has('warning'))
	<script>
		toastr.warning('{{Session::get('warning')}}')
	</script>
@endif