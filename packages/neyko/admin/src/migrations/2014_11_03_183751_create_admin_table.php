<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration {

	public function up()
	{

		Schema::create('admins', function($table){
		    $table->increments('id');
		    $table->string('username',100);
		    $table->string('password',100);
		    $table->string('email',100);
		    $table->string('lang',2);
		    $table->rememberToken();
		    $table->timestamps();
		});

		Schema::create('admin_modules', function($table){
		    $table->increments('id');
		    $table->string('name',100);
		    $table->string('label',100);
		    $table->string('singular',100);
		    $table->string('model',100);
		    $table->string('main',30);
		    $table->string('icon',30);
		    $table->integer('position');
		    $table->integer('parent');
		    $table->timestamps();
		});

		Schema::create('admin_access', function($table){
			$table->increments('id');
		    $table->integer('id_admin')->references('id')->on('admins');
		    $table->integer('id_module')->references('id')->on('admin_modules');
		    $table->timestamps();
		});

		Schema::create('admin_logs', function($table){
		    $table->increments('id');
		    $table->string('username',100);
		    $table->text('message');
		    $table->timestamps();
		});
	}


	public function down()
	{	
		Schema::dropIfExists('admins');
		Schema::dropIfExists('admin_modules');
		Schema::dropIfExists('admin_access');
		Schema::dropIfExists('admin_log');		
	}

}
