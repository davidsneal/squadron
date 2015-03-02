@extends('squadron/app')

@section('content')
<form id="post-edit" class="form-horizontal" method="post" action="/{{ Config::get('settings.admin_prefix') }}/article/create">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="{{ $article['id'] }}">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#core" data-toggle="tab" aria-expanded="true">Core</a></li>
				  <li class=""><a href="#seo" data-toggle="tab" aria-expanded="false">Seo</a></li>
				</ul>
				<div class="tab-content spacer">
					<!-- CORE TAB -->
					<div class="tab-pane fade active in" id="core">
					  	<fieldset>
					    <div class="form-group">
					      <label for="title" class="col-lg-2 control-label">Title</label>
					      <div class="col-lg-10">
					        <input type="text" class="form-control" id="title" name="title" value="{{ $article['title'] }}" maxlength="150" required>
					      </div>
					    </div>
						<div class="form-group">
					      <label for="lead" class="col-lg-2 control-label">Lead</label>
					      <div class="col-lg-10">
					        <textarea class="form-control" rows="3" id="lead" name="lead" required>{{ $article['lead'] }}</textarea>
					      </div>
					    </div>
					    <div class="form-group">
					      <label for="content" class="col-lg-2 control-label">Content</label>
					      <div class="col-lg-10">
					        <textarea class="form-control" name="content" data-provide="markdown" rows="15" required>{{ $article['content'] }}</textarea>
					      </div>
					    </div>
					  </fieldset>
				  	</div>
				  	<!-- SEO TAB -->
				  	<div class="tab-pane fade" id="seo">
				    	<fieldset>
					    <div class="form-group">
					      <label for="uri" class="col-lg-2 control-label">URI</label>
					      <div class="col-lg-10">
					        <input type="text" class="form-control" id="uri" name="uri" value="{{ $article['uri'] }}" maxlength="150">
					      </div>
					    </div>
					  </fieldset>
				  	</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="admin-bar">
		<button type="submit" class="btn-save btn btn-primary pull-right">Save</button>	    
	</div>

</form>
@endsection
