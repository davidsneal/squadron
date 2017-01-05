<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model {
	
	protected $table = 'assets';

	protected $fillable =  [
							'parent_folder_id',
							'name',
							'desc',
							'dirpath'
						];

	protected $guarded = ['id'];

	// each asset has a single folder
	public function folder()
    {
        return $this->hasOne('App\AssetsFolder');
    }

}
