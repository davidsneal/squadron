@extends('squadron.assets.index', ['folder_id' => $folder_id, 'breadcrumbs' => $breadcrumbs])

@section('folder_contents')

	@if(count($folders) > 0)
		<ol class="assets-list">
	  	@foreach($folders as $folder)
	  		<li class="assets-folder-li">
				<div class="assets-folder-item"><a href="/{{ Config('settings.admin_prefix') }}/assets/folder/{{ $folder->id }}"><i class="fa fa-folder-o assets-folder-icon"></i></a>
				</div>
				<span class="assets-folder-name">{{ $folder->name }}</span>
	  		</li>
	    @endforeach
	    @foreach($assets as $asset)
	  		<li class="assets-folder-li">
				<div class="assets-folder-item"><a href="/{{ Config('settings.admin_prefix') }}/assets/asset/{{ $asset->id }}"><i class="fa fa-picture-o assets-folder-icon"></i></a>
				</div>
				<span class="assets-folder-name">{{ $asset->name }}</span>
	  		</li>
	    @endforeach
		</ol>
	@endif

@endsection