<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// custom
use App\Article;
use App\Seo;

// laravel
use Request;
use Validator;
use Response;
use View;
use Config;
use Markdown;

class ArticleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// get articles and paginate
		$articles = Article::paginate(10);

		// prepare data
		$data = array(
						'articles' => $articles,
				);

		// respond with the page
		return Response::view('squadron.articles.index', $data);
	}

	/**
	 * Create or update an article
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
		    	'title' 			=> $data['title'],
		    	'lead' 				=> $data['lead'],
		    	'content' 			=> $data['content'],
		    	'seo_title' 		=> $data['seo-title'],
		    	'seo_description' 	=> $data['seo-description'],
		    ),
		    array(
		    	'title' 		=> 'required|max:150',
		    	'lead' 			=> 'required',
		    	'content' 		=> 'required',
		    	'seo_title' 	=> 'max:150',
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
		
		// create a uri if not set
		if(empty($data['uri']))
		{
			$uri = str_slug($data['title'], "-");
		}
		// or ensure correct formation of entered one
		else
		{
			$uri = str_slug($data['uri'], "-");
		}
		
		// check if the article exists already
		$article = Article::get_by_title($data['title'], $data['id']);

		// if article title is already set
		if(isset($article->id))
		{
			return Response::json(array(
				'status' => 'error',
				'message' => 'Article title already taken',
				'alert_class' => 'alert-warning',
				));
		}
		
		// check if the article exists already
		$article = Article::get_by_uri($uri, $data['id']);

		// if article uri is already set
		if(isset($article->id))
		{
			return Response::json(array(
				'status' => 'error',
				'message' => 'Article URI already taken',
				'alert_class' => 'alert-warning',
				));
		}
		
		// if no id is set
		if(empty($data['id']))
		{
			// initiate classes
			$article = new Article;
			$seo = new Seo;
		}
		// or we're updating an existing article
		else
		{
			$article = Article::find($data['id']);
			$seo = Seo::find($data['id']);
		}
		
		// prepare data
		$article->title		= $data['title'];
		$article->uri 		= $uri;
		$article->lead 		= $data['lead'];
		$article->content	= $data['content'];
		
		// if saved successfully
		if($article->save())
		{
			// prepare seo data
			$seo->article_id  	= $article->id;
			$seo->page_id  	  	= null;
			$seo->title 	  	= $data['seo-title'];
			$seo->description 	= $data['seo-description'];
			
			// save the seo data too
			$seo->save();
			
			// return success alert and redirect
			return Response::json(array(
				'status' 		=> 'success',
				'redirect'		=> '/'.Config::get('settings.admin_prefix').'/articles/edit/'.$article->id,
				'message' 		=> 'Article saved',
				'alert_class' 	=> 'alert-success',
				));
		}
		// failed to save
		else
		{
			return Response::json(array(
				'status' => 'error',
				'message' => 'Failed to save the article',
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
	public function show($year, $month = 0, $uri = 0)
	{
		// check if the article exists already
		$article = Article::get_by_uri($uri);

		// 404 if article uri is not found
		if( ! isset($article->id))
		{
			abort(404);
		}

		// markup the content
		$content = Markdown::convertToHtml($article->content);
		
		// get the seo data
		$seo = Seo::find($article->id);
	
		// prepare data
		$data = [
			'article' 	=> $article,
			'content' 	=> $content,
			'seo'	 	=> $seo
		];

		// show article
		return response()->view('themes.'.Config::get('settings.admin_prefix').'.articles.view', $data); 
	}

	/**
	 * Show the form for editing or creating specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id = 0)
	{
		// typecast if needed
		$id = (int) $id;
		
		// get article
		$article = Article::find($id);
		
		// creating new
		if($id === 0)
		{
			// get null record set
			$seo = Seo::find($id);
			
			$data = [
				'article' => $article,
				'seo' 	  => $seo,
			];

			return response()->view('squadron.articles.edit', $data);
		}
		// editing existing
		elseif( ! empty($article))
		{
			// get seo data
			$seo = Seo::get_by_article($id);

			$data = [
				'article' => $article,
				'seo' 	  => $seo,
			];

			return response()->view('squadron.articles.edit', $data);
		}
		// no article found
		else
		{
			$data = [
				'alert_class' 	=> 'warning',
				'alert_message' => 'Unable to find an article with this ID',
			];

			return response()->view('squadron.errors.general', $data);
		}
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
