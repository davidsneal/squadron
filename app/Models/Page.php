<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model {
	
	use SoftDeletes;

    protected $dates = ['deleted_at'];

	protected $table = 'pages';

	protected $fillable = ['title', 'lead', 'content', 'uri'];

	protected $guarded = ['id'];
	
	// get a page from a uri
    public function scopeGet_by_uri($query, $uri, $id = 0)
    {
	    return $query->where('uri', '=', $uri)
	    			 ->where('id', '!=', $id)
                     ->first();
    }

	// get a page from a title
    public function scopeGet_by_title($query, $title, $id = 0)
    {
	    return $query->where('title', '=', $title)
	    			 ->where('id', '!=', $id)
                     ->first();
    }

}
