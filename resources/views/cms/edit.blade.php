@extends('cms/app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-2">
			<form>
				<input name="title" type="text" placeholder="Title?" />
				<textarea name="content" data-provide="markdown" rows="10"></textarea>
				<label class="checkbox">
				<input name="publish" type="checkbox"> Publish
				</label>
				<hr/>
				<button type="submit" class="btn">Submit</button>
			</form>
		</div>
	</div>
</div>
@endsection
