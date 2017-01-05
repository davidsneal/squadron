<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetsFolder extends Model {

	protected $table = 'assets_folders';

	protected $fillable =  [
							'name',
							'desc',
							'alt',
							'filetype',
							'extension',
							'filepath'
						];

	protected $guarded = ['id'];

	// get a dir path for an asset folder
    public function getDirpathAttribute()
    {
        return public_path($this->publicpath);
    }
	
	// an assets folder has many assets
	public function assets()
    {
        return $this->hasMany('App\Asset');
    }
    
    // an assets can have many parents
	public function parents()
    {
        return $this->hasMany('AssetsFolder', 'comment_parent');
    }
}
