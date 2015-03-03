<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model {

	protected $table = 'seos';

	protected $fillable = ['page_id', 'article_id', 'title', 'description', 'type'];

	protected $guarded = ['id'];
	
	// get seo from a page id
    public function scopeGet_by_page($query, $page_id, $id = 0)
    {
	    return $query->where('page_id', '=', $page_id)
	    			 ->where('id', '!=', $id)
                     ->first();
    }

	// get seo from an article id
    public function scopeGet_by_article($query, $article_id, $id = 0)
    {
	    return $query->where('article_id', '=', $article_id)
	    			 ->where('id', '!=', $id)
                     ->first();
    }

}
