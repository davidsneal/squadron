@extends('squadron.assets.index', [
					'folder' => $folder,
					'children' => $children,
					'parents' => $parents
					])

@section('folder_contents')

	@if(count($children) > 0)
		<ol class="assets-list">
	  	@foreach($children as $child)
	  		<li class="assets-folder-li">
				<div class="assets-folder-item"><a href="/{{ Config('settings.admin_prefix') }}/assets/folder/{{ $child->id }}"><i class="fa fa-folder-o assets-folder-icon"></i></a>
				</div>
				<span class="assets-folder-name">{{ $child->name }}</span>
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