<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// squadron
use App\Helpers\Squadron;
use App\Article;
use App\Seo;

// laravel
use Config;
use DB;
use Entrust;
use Markdown;
use Response;
use Request;
use Validator;
use View;

class ArticleController extends Controller {
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function FE_index()
	{
		// get search input
		$search = Request::input('search');
		
		// if a search isset an not empty
		if(isset($search) AND ! empty($search))
		{
			// get articles and paginate
			$articles = Article::where('status', '=', 'Published')
							   ->where('title', 'LIKE', '%'.$search.'%')
							   ->orWhere('lead', 'LIKE', '%'.$search.'%')
							   ->orderBy('created_at', 'desc')
							   ->paginate(Config::get('settings.articles_per_page'));
			
			// append pagination links to maintain search   
			$articles->appends(['search' => $search]);
		}
		// no search set
		else
		{
			// get articles and paginate
			$articles = Article::where('status', '=', 'Published')
							   ->orderBy('created_at', 'desc')
							   ->paginate(Config::get('settings.articles_per_page'));
		}
		
		// empty array of urls
		$urls = [];
		
		// loop through the articles
		foreach($articles as $article)
		{
			// add the full url to the array
			$urls[$article->id] = $this->get_url($article->id);
		}

		// prepare data
		$data = [
					'articles' 	=> $articles,
					'urls' 		=> $urls,
					'search'   	=> $search
				];

		// respond with the page
		return Response::view('themes.'.Config::get('settings.active_theme').'.articles.index', $data);
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function get_url($id = 0)
	{
		// typecast if needed
		$id = (int) $id;
		
		// get article
		$article = Article::find($id);
		
		// article not found
		if( ! isset($article->id))
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Failed to prepare a URL for the article',
				'alert_class' => 'alert-danger',
				]);
		}
		
		// start url variable
		$url = '/';
		
		// get articles index
		$index = Config::get('settings.articles_index');
		
		// if the index isn't empty
		if( ! empty($index))
		{
			// add it to the url
			$url .= $index.'/';
		}
		
		// switch based on article_url_structure
		switch(Config::get('settings.article_url_structure'))
		{
			case '{year}/{month}/{uri}':
			default:
				
				// get the month and year the article was created
				$year = date('Y', strtotime($article->created_at));
				$month = date('m', strtotime($article->created_at));

				// add to the url
				$url .= $year.'/'.$month.'/'.$article->uri;
			break;
			
			case '{uri}':
				$url .= $article->uri;
			break;
		}

		// respond with the full
		return $url;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// access check
		if( ! Entrust::can('access_articles'))
			return Squadron::permissionsError('access_articles');

		// get inputs
		$search  = Request::input('search');
		$order 	 = Request::input('order');
		$orderBy = Request::input('order-by');
		
		// if $orderBy is empty use default
		if( ! isset($orderBy) OR empty($orderBy))
		{
			$orderBy = 'created_at';
		}
		
		// if $order is empty use default
		if( ! isset($order) OR empty($order))
		{
			$order = 'desc';
		}
		
		// if a search isset an not empty
		if(isset($search) AND ! empty($search))
		{
			// get articles and paginate
			$articles = Article::where('title', 'LIKE', '%'.$search.'%')
							   ->orWhere('lead', 'LIKE', '%'.$search.'%')
							   ->orderBy($orderBy, $order)
							   ->paginate(Config::get('settings.articles_per_page_admin'));

			// append pagination links to maintain search   
			$articles->appends(['search' => $search]);
		}
		// no search set
		else
		{
			// get articles and paginate
			$articles = Article::orderBy($orderBy, $order)
							   ->paginate(Config::get('settings.articles_per_page_admin'));
		}
		
		// if $orderBy is set and not empty
		if(isset($orderBy) AND ! empty($orderBy))
		{
			$articles->appends(['order-by' => $orderBy]);
		}
		
		// if $order is set and not empty
		if(isset($order) AND ! empty($order))
		{
			$articles->appends(['order' => $order]);
		}

		// prepare data
		$data = [
					'articles' => $articles,
					'search'   => $search,
					'orderBy'  => $orderBy,
					'order'    => $order
				];

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
		    [
		    	'status' 			=> $data['status'],
		    	'title' 			=> $data['title'],
		    	'lead' 				=> $data['lead'],
		    	'content' 			=> $data['content'],
		    	'seo_title' 		=> $data['seo-title'],
		    	'seo_description' 	=> $data['seo-description'],
		    ],
		    [
		    	'status' 		=> 'required|max:9',
		    	'title' 		=> 'required|max:150',
		    	'lead' 			=> 'required',
		    	'content' 		=> 'required',
		    	'seo_title' 	=> 'max:150',
		    ]
		);

		// if validation fails
		if ($validator->fails())
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Posted values failed validation',
				'alert_class' => 'alert-warning',
				]);
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
		$article = Article::getByTitle($data['title'], $data['id']);

		// if article title is already set
		if(isset($article->id))
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Article title already taken',
				'alert_class' => 'alert-warning',
				]);
		}
		
		// check if the article exists already
		$article = Article::getByUri($uri, $data['id']);

		// if article uri is already set
		if(isset($article->id))
		{
			return Response::json([
				'status' => 'error',
				'message' => 'Article URI already taken',
				'alert_class' => 'alert-warning',
				]);
		}
		
		// begin a DB transaction so we can rollback if needed
		DB::beginTransaction();
		
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
		$article->status	= $data['status'];
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
			if($seo->save())
			{
				// commit to the DB
				DB::commit();

				// return success alert and redirect
				return Response::json([
					'status' 		=> 'success',
					'redirect'		=> '/'.Config::get('settings.admin_prefix').'/articles/edit/'.$article->id,
					'message' 		=> 'Article saved',
					'alert_class' 	=> 'alert-success',
					]);
			}
			// failed to save
			else
			{
				// rollback so we don't save the article
				DB::rollback();
				
				// return error
				return Response::json([
					'status' => 'error',
					'message' => 'Failed to save the SEO data, article not saved',
					'alert_class' => 'alert-danger',
					]);
			}
		}
		// failed to save
		else
		{
			// return error
			return Response::json([
				'status' => 'error',
				'message' => 'Failed to save the article',
				'alert_class' => 'alert-danger',
				]);
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
	public function show_U($uri = 0)
	{
		// check if the article exists already
		$article = Article::getByUri($uri);

		// 404 if article uri is not found or not published
		if( ! isset($article->id) OR $article->status != 'Published')
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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show_YMU($year = 0, $month = 0, $uri = 0)
	{
		// check if the article exists already
		$article = Article::getByYMU($year, $month, $uri);

		// 404 if article uri is not found or not published
		if( ! isset($article->id) OR $article->status != 'Published')
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
		// access check
		if( ! Entrust::can('manage_draft_articles'))
			return Squadron::permissionsError('manage_draft_articles');

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
			
			// prepare data
			$data = [
				'article' => $article,
				'seo' 	  => $seo
			];
			
			// if the article is published
			if($article->status == 'Published')
			{
				// get and add the URL
				$data['url'] = $this->get_url($id);
			}

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
