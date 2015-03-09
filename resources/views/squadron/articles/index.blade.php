@extends('squadron/app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h1 class="pull-left heading-search">Articles</h1>
			<form class="navbar-form pull-right" role="search" action="" method="get">
		        <div class="form-group">
		        	<input name="search" type="text" class="form-control" placeholder="Search">
		        </div>
		        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
		    </form>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<table class="table table-striped table-hover ">
				<thead>
			    	<tr>
						<th class="th-table-order" data-order-by="id" data-order="{{ ($orderBy == 'id' && $order == 'asc' ? 'desc' : 'asc') }}">#</th>
						<th class="th-table-order" data-order-by="title" data-order="{{ ($orderBy == 'title' && $order == 'asc' ? 'desc' : 'asc') }}">Title</th>
						<th class="th-table-order" data-order-by="created_at" data-order="{{ ($orderBy == 'created_at' && $order == 'asc' ? 'desc' : 'asc') }}">Date</th>
						<th class="th-table-order" data-order-by="status" data-order="{{ ($orderBy == 'status' && $order == 'asc' ? 'desc' : 'asc') }}">Status</th>
			    	</tr>
			  	</thead>
			  	<tbody>
					@if(count($articles) == 0)
						<tr class="warning text-center">
							<td colspan="4">
								No articles found
								@if($search != '')
									for '<b>{{ $search }}</b>'
								@endif
							</td>
					    </tr>
					@else
					  	@foreach($articles as $article)
					    <tr>
					    	<td>{{ $article->id }}</td>
							<td><a href="/{{ Config('settings.admin_prefix') }}/articles/edit/{{ $article->id }}">{{ $article->title }}</a></td>
							<td>{{ Carbon::parse($article->created_at)->toFormattedDateString() }}</td>
							<td>{{ $article->status }}</td>
					    </tr>
					    @endforeach
					@endif
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
