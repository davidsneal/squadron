<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model {
	
	use SoftDeletes;

    protected $dates = ['deleted_at'];
	
	protected $table = 'articles';

	protected $fillable = ['title', 'lead', 'content', 'uri'];

	protected $guarded = ['id'];

	// get an article from a uri
    public function scopeGetByUri($query, $uri, $id = 0)
    {
	    return $query->where('uri', '=', $uri)
	    			 ->where('id', '!=', $id)
                     ->first();
    }
    
    // get an article from year/month/uri
    public function scopeGetByYMU($query, $year, $month, $uri)
    {
	    return $query->where('uri', '=', $uri)
	    			 ->where('created_at', 'LIKE', $year.'-'.$month.'%')
                     ->first();
    }

	// get an article from a title
    public function scopeGetByTitle($query, $title, $id = 0)
    {
	    return $query->where('title', '=', $title)
	    			 ->where('id', '!=', $id)
                     ->first();
    }
}
