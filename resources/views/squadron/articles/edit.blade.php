@extends('squadron.app')

@section('content')
<form id="article-edit" class="form-horizontal" method="post" action="/{{ env('admin_prefix', 'admin') }}/articles/create" role="form" data-toggle="validator">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="{{ $article['id'] }}">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<ul class="nav nav-tabs">
				  <li class="active"><a href="#core" data-toggle="tab" aria-expanded="true">Core</a></li>
				  <li class=""><a href="#seo" data-toggle="tab" aria-expanded="false">Seo</a></li>
				  @if(isset($url))
				  	<a class="pull-right" href="{{ $url }}"><button class="btn btn-default" type="button">View</button></a>
				  @endif
				</ul>
				<div class="tab-content spacer">
					<!-- CORE TAB -->
					<div class="tab-pane fade active in" id="core">
					  	<fieldset>
					    <div class="form-group">
					      <label for="title" class="col-lg-2 control-label label-required">Title</label>
					      <div class="col-lg-10">
					        <input type="text" class="form-control" id="title" name="title" value="{{ $article['title'] }}" maxlength="150" required>
					        <div class="help-block with-errors"></div>
					      </div>
					    </div>
						<div class="form-group">
					      <label for="lead" class="col-lg-2 control-label label-required">Lead</label>
					      <div class="col-lg-10">
					        <textarea class="form-control" rows="3" id="lead" name="lead" required>{{ $article['lead'] }}</textarea>
					        <div class="help-block with-errors"></div>
					      </div>
					    </div>
					    <div class="form-group">
					      <label for="content" class="col-lg-2 control-label label-required">Content</label>
					      <div class="col-lg-10">
					        <textarea class="form-control" name="content" data-provide="markdown" rows="15" required>{{ $article['content'] }}</textarea>
					        <div class="help-block with-errors"></div>
					      </div>
					    </div>
					  </fieldset>
				  	</div>
				  	<!-- END CORE TAB -->
				  	<!-- SEO TAB -->
				  	<div class="tab-pane fade" id="seo">
				    	<fieldset>
					    	<div class="form-group">
								<label for="uri" class="col-lg-2 control-label">URI</label>
								<div class="col-lg-10">
					        	<input type="text" class="form-control" id="uri" name="uri" value="{{ $article['uri'] }}" maxlength="150">
					    		</div>
					    	</div>
					    	<div class="form-group">
								<label for="seo-title" class="col-lg-2 control-label">Title</label>
								<div class="col-lg-10">
					        		<input type="text" class="form-control" id="seo-title" name="seo-title" value="{{ $seo['title'] }}" maxlength="150">
					    		</div>
					    	</div>
					    	<div class="form-group">
								<label for="seo-description" class="col-lg-2 control-label">Description</label>
								<div class="col-lg-10">
									<textarea class="form-control" rows="3" id="seo-description" name="seo-description">{{ $seo['description'] }}</textarea>
					      		</div>
					    	</div>
					    </div>
					  </fieldset>
				  	</div>
				  	<!-- END SEO TAB -->
				</div>
			</div>
		</div>
	</div>
	
	<div class="admin-bar">
		<button type="submit" class="btn-save btn btn-primary pull-right">Save</button>	
		<div class="form-inline pull-right">
	      <div class="col-lg-10">
	        <select class="form-control" id="select" name="status">
	          <option value="Published" {{ (isset($article->status) && $article->status == 'Published' ? 'selected' : null) }}>Published</option>
	          <option value="Draft" {{ (isset($article->status) && $article->status == 'Draft' ? 'selected' : null) }}>Draft</option>
	          <option value="Deleted" {{ (isset($article->status) && $article->status == 'Deleted' ? 'selected' : null) }}>Deleted</option>
	        </select>
	      </div>
	    </div>    
	</div>

</form>
@endsection
