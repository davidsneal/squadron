@extends('squadron/app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="alert alert-{{ $alert_class }}">
			  <strong>{{ $alert_message }}</strong>
			</div>
		</div>
	</div>
</div>
@endsection
