@extends('cms/app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<form>
				<textarea name="content" data-provide="markdown" rows="10"></textarea>
				<hr/>
				<button type="submit" class="btn">Submit</button>
			</form>
		</div>
	</div>
</div>
@endsection
