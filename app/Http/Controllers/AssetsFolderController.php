<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// squadron
use App\Helpers\Squadron;
use App\AssetsFolder;
use App\Asset;

// laravel
use Request;
use Validator;
use Response;
use View;
use Config;
use Markdown;
use Entrust;

class AssetsFolderController extends Controller {
	
	// variables
	public $parents = [];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// access check
		if( ! Entrust::can('access_assets'))
			return Squadron::permissionsError('access_assets');
			
		// get search input
		$search = Request::input('search');
		
		// if a search isset an not empty
		if(isset($search) AND ! empty($search))
		{
			// folders that match search
			$children = AssetsFolder::where('name', 'LIKE', '%'.$search.'%')
							   	   ->orWhere('desc', 'LIKE', '%'.$search.'%')
							   	   ->orderBy('name')
							   	   ->get();
							   	   
			// assets that match search
			$assets = Asset::where('name', 'LIKE', '%'.$search.'%')
						   ->orWhere('desc', 'LIKE', '%'.$search.'%')
						   ->orderBy('name')
						   ->get();
		}
		// no search set
		else
		{
			// get top level folders
			$children = AssetsFolder::where('parent_folder_id', '=', null)
							   	   ->orderBy('name')
							   	   ->get();
							   	   
			// get top level assets
			$assets = Asset::where('assets_folder_id', '=', null)
						   ->orderBy('name')
						   ->get();
		}
		
		// return assets index
		return Response::view('squadron.assets.contents', [
											'folder'	=> new AssetsFolder,
											'children' 	=> $children,
											'assets'  	=> $assets,
											'search'  	=> $search,
											'parents'	=> []
											]);
	}

	/**
	 * Create or edit a folder
	 *
	 * @return Response
	 */
	public function create()
	{
		// get posted inputs
		$data = Request::input('data');
		parse_str($data, $data);

		// prepare for validation
		$validator = Validator::make(
		    array(
		    	'parent_folder_id' 	=> $data['parent-folder-id'],
		    	'name' 				=> $data['name'],
		    	'desc' 				=> $data['desc']
		    ),
		    array(
		    	'parent_folder_id' 	=> 'integer|max:10',
		    	'name' 				=> 'required|max:45|unique:assets_folders',
		    	'desc' 				=> 'max:125'
		    )
		);

		// if validation fails
		if ($validator->fails())
		{
			return Response::json(array(
				'status' => 'error',
				'message' => 'Posted values failed validation',
				'alert_class' => 'alert-warning',
				));
		}
		
		// if no id is set
		if(empty($data['id']))
		{
			// initiate class
			$folder = new AssetsFolder;
		}
		// or we're updating an existing folder
		else
		{
			$folder = AssetsFolder::find($data['id']);
		}
		
		// prepare data
		$folder->parent_folder_id = (empty($data['parent-folder-id']) ? null : $data['parent-folder-id']);
		$folder->name 			  = $data['name'];
		$folder->desc 			  = $data['desc'];
		
		// if saved successfully
		if($folder->save())
		{
			// return success alert and redirect
			return Response::json(array(
				'status' 		=> 'success',
				'redirect'		=> '/'.Config::get('settings.admin_prefix').'/assets/folder/'.$folder->id,
				'message' 		=> 'Folder saved',
				'alert_class' 	=> 'alert-success',
				));
		}
		// failed to save
		else
		{
			return Response::json(array(
				'status' => 'error',
				'message' => 'Failed to save the folder',
				'alert_class' => 'alert-danger',
				));
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// access check
		if( ! Entrust::can('access_assets'))
			return Squadron::permissionsError('access_assets');
			
		// get the folder being viewed
		$folder = AssetsFolder::find($id);
	
		// get child folders
		$children = AssetsFolder::where('parent_folder_id', '=', $id)
						   	   ->orderBy('name')
						   	   ->get();
						   	   
		// get folder's assets
		$assets = Asset::where('assets_folder_id', '=', $id)
					   ->orderBy('name')
					   ->get();
					   
		// get all parents ready
		$this->getParents($id);

		// return assets folder
		return Response::view('squadron.assets.contents', [
											'folder' 	=> $folder,
											'children' 	=> $children,
											'assets'  	=> $assets,
											'search'  	=> null,
											'parents' 	=> array_reverse($this->parents)
											]);
	}
	
	/**
	 * Get an array of parent folders
	 *
	 * @param  int  $id
	 * @return Response
	 */
	private function getParents($folder_id)
	{
		// typecast to be safe
		$folder_id = (int)$folder_id;

		// get the folder provided
		$folder = AssetsFolder::find($folder_id);
	
		// if no matching folder was found stop there
		if( ! $folder->id)
			return $this->parents;
			
		// add the folder to the array of parents
		$this->parents[$folder->name] =  $folder->id;

		// if there's a parent folder
		if( ! empty($folder->parent_folder_id))
		{			
			// call the function recursively to add it to the array
			$this->getParents($folder->parent_folder_id);
		}

		// return
		return true;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
