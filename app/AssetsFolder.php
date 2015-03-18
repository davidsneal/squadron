<?php namespace App;

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
