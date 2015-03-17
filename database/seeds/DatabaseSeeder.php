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
		
		//---------------------------- CREATE INITIAL USER ---------------------------//
		
		// initial super admin user
		$user = new App\User();
		
		// SET THESE DETAILS HERE FOR FIRST SUPER ADMIN USER
		$user->name 	= '';
		$user->email 	= '';
		$user->password = Hash::make('');
		// SET THESE DETAILS HERE FOR FIRST SUPER ADMIN USER
		
		// save first user
		$user->save();

		
		//----------------------- CREATE SUPER ADMIN ROLE ----------------------------//

		// create admin role and assign it to the new admin user
		$roleSuperAdmin = new App\Role();
		$roleSuperAdmin->name         = 'super_admin';
		$roleSuperAdmin->display_name = 'Super Administrator'; // optional
		$roleSuperAdmin->description  = 'User is allowed to do/access anything available'; // optional
		$roleSuperAdmin->save();

		
		//------------------- GIVE SUPER ADMIN TO INITIAL USER  ----------------------//
		
		// eloquent's original technique
		$user->roles()->attach($user->id); // id only
		
		
		//    ___               _       _             
		//   | _ \___ _ _ _ __ (_)_____(_)___ _ _  ___
		//   |  _/ -_) '_| '  \| (_-<_-< / _ \ ' \(_-<
		//   |_| \___|_| |_|_|_|_/__/__/_\___/_||_/__/
		//   
		
		//---------------------------- SYSTEM -----------------------------------------//
		
		// can access squadron
		$permAccessSquadron = new App\Permission();
		$permAccessSquadron->name         = 'access_squadron';
		$permAccessSquadron->display_name = 'Access Squadron';
		$permAccessSquadron->description  = 'Access Squadron CMS';
		$permAccessSquadron->save();
		
		// can change system settings
		$permSystemSettings = new App\Permission();
		$permSystemSettings->name         = 'manage_system_settings';
		$permSystemSettings->display_name = 'Manage System Settings';
		$permSystemSettings->description  = 'Can manage Squadron settings';
		$permSystemSettings->save();
		
		//---------------------------- USERS -----------------------------------------//
		
		// manage users
		$permManageUsers = new App\Permission();
		$permManageUsers->name         = 'manage_users';
		$permManageUsers->display_name = 'Manage Users';
		$permManageUsers->description  = 'Manage users';
		$permManageUsers->save();
		
		// can login as anyone
		$permFakeLogin = new App\Permission();
		$permFakeLogin->name         = 'fake_login';
		$permFakeLogin->display_name = 'Fake Login';
		$permFakeLogin->description  = 'Fake login as another user';
		$permFakeLogin->save();
		
		//---------------------------- ARTICLES ----------------------------------------//
		
		// access articles
		$permAccessArticles = new App\Permission();
		$permAccessArticles->name         = 'access_articles';
		$permAccessArticles->display_name = 'Access Articles';
		$permAccessArticles->description  = 'Access articles section';
		$permAccessArticles->save();
		
		// manage draft articles
		$permManageDraftArticles = new App\Permission();
		$permManageDraftArticles->name         = 'manage_draft_articles';
		$permManageDraftArticles->display_name = 'Manage Draft Articles';
		$permManageDraftArticles->description  = 'Create and edit draft articles';
		$permManageDraftArticles->save();
		
		// publish articles
		$permPublishArticles = new App\Permission();
		$permPublishArticles->name         = 'publish_articles';
		$permPublishArticles->display_name = 'Publish Articles';
		$permPublishArticles->description  = 'Publish articles';
		$permPublishArticles->save();
		
		// delete articles
		$permDeleteArticles = new App\Permission();
		$permDeleteArticles->name         = 'delete_articles';
		$permDeleteArticles->display_name = 'Delete Articles';
		$permDeleteArticles->description  = 'Delete articles';
		$permDeleteArticles->save();
		
		//------------------------------ ASSETS ----------------------------------------//
		
		// can use assets
		$permUseAssets = new App\Permission();
		$permUseAssets->name         = 'use_assets';
		$permUseAssets->display_name = 'Use Assets';
		$permUseAssets->description  = 'Use assets';
		$permUseAssets->save();
		
		// can upload assets
		$permUploadAssets = new App\Permission();
		$permUploadAssets->name         = 'upload_assets';
		$permUploadAssets->display_name = 'Upload Assets';
		$permUploadAssets->description  = 'Upload assets';
		$permUploadAssets->save();
		
		// can delete assets
		$permDeleteAssets = new App\Permission();
		$permDeleteAssets->name         = 'delete_assets';
		$permDeleteAssets->display_name = 'Delete Assets';
		$permDeleteAssets->description  = 'Delete assets';
		$permDeleteAssets->save();
		
		
		//    ___     _        
		//   | _ \___| |___ ___
		//   |   / _ \ / -_|_-<
		//   |_|_\___/_\___/__/
		//  

		//------------------------------ ADMIN USER ----------------------------------//

		// standard admin user
		$roleAdmin = new App\Role();
		$roleAdmin->name         = 'admin';
		$roleAdmin->display_name = 'Admin User';
		$roleAdmin->description  = 'User is allowed to perform most tasks';
		$roleAdmin->save();
		
		
		//------------------------- PUBLISH ARTICLE USER -----------------------------//

		// publish article user
		$rolePublishArticles = new App\Role();
		$rolePublishArticles->name         = 'publish_articles';
		$rolePublishArticles->display_name = 'Publish Articles';
		$rolePublishArticles->description  = 'User is allowed to create and published articles';
		$rolePublishArticles->save();
		

		//----------------------- MANAGE DRAFT ARTICLE USER --------------------------//

		// draft article user
		$roleDraftArticles = new App\Role();
		$roleDraftArticles->name         = 'draft_articles';
		$roleDraftArticles->display_name = 'Manage Draft Articles';
		$roleDraftArticles->description  = 'User is allowed to create and edit draft articles';
		$roleDraftArticles->save();
		
		
		//      _          _             ___               _       _             
		//     /_\   _____(_)__ _ _ _   | _ \___ _ _ _ __ (_)_____(_)___ _ _  ___
		//    / _ \ (_-<_-< / _` | ' \  |  _/ -_) '_| '  \| (_-<_-< / _ \ ' \(_-<
		//   /_/ \_\/__/__/_\__, |_||_| |_| \___|_| |_|_|_|_/__/__/_\___/_||_/__/
		//                  |___/                                                
		
		// super admin role permissions
		$roleSuperAdmin->attachPermissions(array(
								// system
								$permAccessSquadron,
								$permSystemSettings,
								
								// users
								$permManageUsers,
								$permFakeLogin,
								
								// articles
								$permAccessArticles,
								$permManageDraftArticles,
								$permPublishArticles,
								$permDeleteArticles,
								
								// assets
								$permUseAssets,
								$permUploadAssets,
								$permDeleteAssets
							));
		
		// standard admin role permissions
		$roleAdmin->attachPermissions(array(
								// system
								$permAccessSquadron,
								
								// users
								$permManageUsers,
								$permFakeLogin,
								
								// articles
								$permAccessArticles,
								$permManageDraftArticles,
								$permPublishArticles,
								$permDeleteArticles,
								
								// assets
								$permUseAssets,
								$permUploadAssets,
								$permDeleteAssets
							));
		
		// publish articles role permissions
		$rolePublishArticles->attachPermissions(array(
								// system
								$permAccessSquadron,
								
								// articles
								$permAccessArticles,
								$permManageDraftArticles,
								$permPublishArticles,
								$permDeleteArticles,
								
								// assets
								$permUseAssets,
								$permUploadAssets,
								$permDeleteAssets
							));
		
		// manage draft articles role permissions
		$roleDraftArticles->attachPermissions(array(
								// system
								$permAccessSquadron,
								
								// articles
								$permAccessArticles,
								$permManageDraftArticles,
								
								// assets
								$permUseAssets,
								$permUploadAssets,
							));
	}

}
