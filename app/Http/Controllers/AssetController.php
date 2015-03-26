<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;


// squadron
use App\AssetsFolder;
use App\Asset;

// laravel
use Config;
use DB;
use Response;
use Request;
use Validator;

class AssetController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// get posted inputs
		$folder_id = Request::input('folder_id');
		$file 	   = Request::file('asset-upload');

		// typecast to be safe
		$folder_id = (int)$folder_id;
		
		// get csv string of accepted filetypes
		$filetypes = implode(',', Config::get('settings.asset_accepted_extensions'));

		// prepare for validation
		$validator = Validator::make(
		    [
		    	'folder_id' 	=> $folder_id,
		    	'file' 			=> $file
		    ],
		    [
		    	'folder_id' 	=> 'required|integer',
		    	'file' 			=> 'mimes:'.$filetypes
		    ]
		);

		// if validation fails
		if ($validator->fails())
		{
			return Response::json(['error' => 'Posted values failed validation']);
		}
		
		// begin DB transaction
		DB::beginTransaction();
		
		// initiate asset model
		$asset = new Asset;
		
		// file details
		$file_name 		= $file->getClientOriginalName();
		$file_extension = $file->getClientOriginalExtension();
		$file_name 		= str_slug($file_name, "_").'.'.$file_extension;
		
		// get the folder details
		$folder = AssetsFolder::find($folder_id);
		
		// set asset details
		$asset->name 				= $file_name;
		$asset->assets_folder_id 	= $folder_id;
		$asset->extension 			= $file->getClientOriginalExtension();
		$asset->url 				= $folder->publicpath.$file_name.'.'.$file_extension;

		// move tmp file
		if( ! @Request::file('asset-upload')->move($folder->dirpath, $file_name))
		{
			return Response::json(['error' => 'Failed to move the file to the upload directory']);
		}
	
		// commit to DB
		DB::commit();

		// file uploaded successfully
		return Response::json([]);
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
		//
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
