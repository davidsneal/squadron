@extends('squadron.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h1 class="pull-left heading-search">
				@if($folder->id)
					{{ $folder->name }}
				@else
					Assets
				@endif
			</h1>
			<form class="navbar-form pull-right" role="search" action="" method="get">
		        <div class="form-group">
		        	<input name="search" type="text" class="form-control" placeholder="Search" value="{{ $search }}">
		        </div>
		        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
		    </form>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<ul class="breadcrumb">
				<li><a href="/{{ Config('settings.admin_prefix') }}/assets">Assets</a></li> 
				@foreach($parents as $name => $id)
					@if($id !== $folder->id)
						<li><a href="/{{ Config('settings.admin_prefix') }}/assets/folder/{{ $id }}">{{ $name }}</a></li>
					@else
						<li class="active">{{ $name }}</li>
					@endif
				@endforeach
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			@yield('folder_contents')
		</div>
	</div>
</div>

<div class="admin-bar">
	@if(Entrust::can('upload_assets'))
		<button data-toggle="modal" data-target="#addAssetModal" data-folder-id="{{ $folder->id }}" class="add-asset-btn btn btn-primary pull-right">Add Asset</button>
	@endif
	@if(Entrust::can('manage_asset_folders'))
		<button data-toggle="modal" data-target="#addFolderModal" data-folder-id="{{ $folder->id }}" class="add-folder-btn btn btn-primary pull-right">Add Folder</button>
	@endif
</div>

@if(Entrust::can('upload_assets'))
<!-- addAssetModal -->
<div class="modal fade" id="addAssetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Asset</h4>
      </div>
      <div class="modal-body">
	  		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary btn-save">Save</button>
      </div>
    </div>
  </div>
</div>
@endif

@if(Entrust::can('manage_asset_folders'))
<!-- addFolderModal -->
<form id="folder-edit" class="form-horizontal" method="post" action="/{{ Config::get('settings.admin_prefix') }}/assets/create" role="form" data-toggle="validator">
<div class="modal fade" id="addFolderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Folder</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="parent-folder-id" value="{{ $folder->id }}">
			<fieldset>
			    <div class="form-group">
			      <label for="title" class="col-lg-2 control-label label-required">Name</label>
			      <div class="col-lg-10">
			        <input type="text" class="form-control" id="name" name="name" value="" maxlength="45" placeholder="Folder name" required>
			        <div class="help-block with-errors"></div>
			      </div>
			    </div>
			    <div class="form-group">
			      <label for="content" class="col-lg-2 control-label">Description</label>
			      <div class="col-lg-10">
			        <textarea class="form-control" name="desc" id="desc" rows="2"></textarea>
			        <div class="help-block with-errors"></div>
			      </div>
			    </div>
			</fieldset>			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-save">Save</button>
      </div>
    </div>
  </div>
</div>
</form>
@endif
@endsection
