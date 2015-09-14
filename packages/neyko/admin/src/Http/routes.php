<?php 

    Route::group(array('prefix' => 'admin'), function(){
        Route::post('login','\Neyko\Admin\Http\Controller\AdministratorController@login');
        Route::get('login', '\Neyko\Admin\Http\Controller\AdministratorController@showLogin');
    });

	Route::group(array('prefix' => 'admin',"before"=>"adminauth"), function(){
        Route::get('show', '\Neyko\Admin\Http\Controller\AdminController@show');
        Route::get('main', '\Neyko\Admin\Http\Controller\AdminController@main');
        Route::post('ajax/uploadpicture','\Neyko\Admin\Http\Controller\AdminController@uploadPicture');
        Route::post('ajax/uploadfile', '\Neyko\Admin\Http\Controller\AdminController@uploadFile');
        Route::get('/dashboard', '\Neyko\Admin\Http\Controller\AdminController@dashboard');
        Route::get('/','\Neyko\Admin\Http\Controller\AdminController@dashboard');

        Route::post('changepassword', '\Neyko\Admin\Http\Controller\AdministratorController@changePassword');
        Route::post('createadmin', '\Neyko\Admin\Http\Controller\AdministratorController@createAdmin');
        Route::get('logout', '\Neyko\Admin\Http\Controller\AdministratorController@logout');

        Route::get("{module}",'\Neyko\Admin\Http\Controller\AdminController@showList');
        Route::get("{module}/new",'\Neyko\Admin\Http\Controller\AdminController@showNew');
        Route::get("{module}/edit/{id}",'\Neyko\Admin\Http\Controller\AdminController@showEdit');

        Route::post("{module}/edit",'\Neyko\Admin\Http\Controller\AdminController@saveForm');
        Route::get("{module}/delete/{id}",'\Neyko\Admin\Http\Controller\AdminController@delete');
        Route::get("{module}/function/{function}/{id}",'\Neyko\Admin\Http\Controller\AdminController@callFunction');

        Route::post("/post/switch",'\Neyko\Admin\Http\Controller\AdminController@processSwitch');
        
	});

    

    Route::filter('adminauth', function(){
        if (!Session::get('admin')){
            return redirect('/admin/login');
        }
    }); 

?>