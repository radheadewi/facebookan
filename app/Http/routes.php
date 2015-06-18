<?php
Route::get('/', function(){ return redirect('/image'); });

Route::resource('/image', 'ImageController'); 

Route::resource('/image/create', 'ImageController@create');

Route::resource('/image/store', 'ImageController@store');

/*Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
