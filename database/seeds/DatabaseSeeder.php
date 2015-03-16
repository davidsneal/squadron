<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		// initial admin user
		$user = new App\User();
		
		// SET THESE DETAILS HERE FOR FIRST SUPER ADMIN USER
		$user->name 		= '';
		$user->email 		= '';
		$user->password 	= Hash::make('');
		// SET THESE DETAILS HERE FOR FIRST SUPER ADMIN USER
		
		// save first user
		$user->save();

		// create admin role and assign it to the new admin user
		$admin = new App\Role();
		$admin->name         = 'super_admin';
		$admin->display_name = 'Super Administrator'; // optional
		$admin->description  = 'User is allowed to do/access anything available'; // optional
		$admin->save();
		
		// eloquent's original technique
		$user->roles()->attach($user->id); // id only
		
		$createPost = new App\Permission();
		$createPost->name         = 'create-post';
		$createPost->display_name = 'Create Posts'; // optional
		// Allow a user to...
		$createPost->description  = 'Create new blog posts'; // optional
		$createPost->save();
		
		$editUser = new App\Permission();
		$editUser->name         = 'edit-user';
		$editUser->display_name = 'Edit Users'; // optional
		// Allow a user to...
		$editUser->description  = 'Edit existing users'; // optional
		$editUser->save();
		
		$admin->attachPermissions(array($createPost, $editUser));
		// equivalent to $admin->perms()->sync(array($createPost->id, $editUser->id));
	}

}
