<?php

Route::group(['prefix' => 'admin'], function () {
	
    Route::redirect('/', '/admin/dashboard');
	Route::get('/login', 'Admin\Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Admin\Auth\AdminLoginController@logout')->name('admin.logout');
    //Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
});




Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

	
	Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    //Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');

    // other admin routes...

});

?>