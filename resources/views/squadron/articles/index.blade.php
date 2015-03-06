@extends('squadron/app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h1>Articles</h1>
			<div class="pull-right">
				<form class="navbar-form" role="search" action="?search" method="get">
			        <div class="form-group ">
			        	<input type="text" class="form-control" placeholder="Search">
			        </div>
					<button type="submit" class="btn btn-default">Submit</button>
			    </form>
			</div>
			<table class="table table-striped table-hover ">
				<thead>
			    	<tr>
						<th>#</th>
						<th>Title</th>
						<th>Date</th>
						<th>Status</th>
			    	</tr>
			  	</thead>
			  	<tbody>
				  	@foreach($articles as $article)
				    <tr>
				    	<td>{{ $article->id }}</td>
						<td><a href="/{{ Config('settings.admin_prefix') }}/articles/edit/{{ $article->id }}">{{ $article->title }}</a></td>
						<td>{{ Carbon::parse($article->created_at)->toFormattedDateString() }}</td>
						<td>{{ $article->status }}</td>
				    </tr>
				    @endforeach
			  </tbody>
			</table>
			<div class="text-center">
				{!! $articles->render() !!}
			</div>
		</div>
	</div>
</div>

<div class="admin-bar">
	<a href="/{{ Config('settings.admin_prefix') }}/articles/edit"><button class="btn btn-primary pull-right">Add new</button></a>    
</div>
@endsection
