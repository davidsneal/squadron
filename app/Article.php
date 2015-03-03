<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
	
	protected $table = 'articles';

	protected $fillable = ['title', 'lead', 'content', 'uri'];

	protected $guarded = ['id'];
	
	// get an article from a uri
    public function scopeGet_by_uri($query, $uri, $id = 0)
    {
	    return $query->where('uri', '=', $uri)
	    			 ->where('id', '!=', $id)
                     ->first();
    }

	// get an article from a title
    public function scopeGet_by_title($query, $title, $id = 0)
    {
	    return $query->where('title', '=', $title)
	    			 ->where('id', '!=', $id)
                     ->first();
    }
}