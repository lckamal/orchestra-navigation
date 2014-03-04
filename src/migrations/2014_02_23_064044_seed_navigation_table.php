<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Orchestra\Support\Facades\Acl;
use Orchestra\Support\Facades\App;
use Orchestra\Model\Role;
class SeednavigationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$admin  = Role::admin();
        $member = Role::member();
        $acl    = Acl::make('lckamal/navigation');

        $acl->roles()->attach(array($member->name, $admin->name));
        $acl->actions()->attach(array(
            'create navigation', 'update navigation', 'delete navigation', 'manage navigation',
        ));

        $acl->allow($member->name, array(
            'create navigation', 'update navigation', 'delete navigation',
        ));

        $acl->allow($admin->name, array(
            'create navigation', 'update navigation', 'delete navigation', 'manage navigation',
        ));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		App::memory()->forget('acl_lckamal/navigation');
	}

}
