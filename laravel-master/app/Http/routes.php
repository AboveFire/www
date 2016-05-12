<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Database\Migrations\Migration;

// PLATEFORME WEB
ini_set('xdebug.max_nesting_level', 500);
Route::get('/',['middleware' => 'auth', function () {
	if(Auth::guest())
	{
		return view('/auth/login');		
	}
	else 
	{
    	return view('home');
	}
}]);

Route::get('/switchLangue', 'LangueController@switchLangue');

Route::post('/profil/save',['middleware' => 'auth', 'uses' =>  'ProfilController@update']);

Route::post('/param/save', ['middleware' => 'auth', 'uses' => 'ParamController@update']);

Route::post('/sschat', ['middleware' => 'auth', 'uses' => 'ChatController@run']);
/*Route::get('/chat', function () {
    return view('chat.sschat');
});*/
Route::get('/chat',['middleware' => 'auth', function () {
    return view('chat.sschat');
}]);

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/test', 'NFLController@test');
//Normal route
Route::get('/connection-refused',function () {
	return view('refused');
});
Route::get('/about', function () {
	return view('about');
});

Route::get('/profil',['middleware' => 'auth', function () {
	return view('profil');
}]);

Route::get('/param',['middleware' => 'auth', function () {
	return view('param');
}]);

Route::get('/results', function () {
	return view('results');
});
//Pool route
Route::get('/form-classic',['middleware' => 'auth', function () {
	return view('pool.forms.classic');
}]);
Route::get('/form-playoff',['middleware' => 'auth', function () {
	return view('pool.forms.playoff');
}]);
Route::get('/form-survivor',['middleware' => 'auth', function () {
	return view('pool.forms.survivor');
}]);
Route::get('/results-classic',['middleware' => 'auth', function () {
	return view('pool.results.classic');
}]);
Route::get('/results-playoff',['middleware' => 'auth', function () {
	return view('pool.results.playoff');
}]);
Route::get('/results-survivor',['middleware' => 'auth', function () {
	return view('pool.results.survivor');
}]);
Route::get('/inscription-classic',['middleware' => 'auth', function () {
	return view('pool.results.classic');
}]);
Route::get('/inscription-playoff',['middleware' => 'auth', function () {
	return view('pool.results.playoff');
}]);
Route::get('/inscription-survivor',['middleware' => 'auth', function () {
	return view('pool.inscriptions.survivor');
}]);
//Administration route
Route::get('/admin',['middleware' => 'admin', function () {
	return view('administration.home');
}]);

Route::get('/admin/users',['middleware' => 'admin', 'uses' => 'AdminController@users']);

Route::get('/admin/pool',['middleware' => 'admin', function () {
	return view('administration.pool');
}]);

Route::post('/admin/users/update',['middleware' => 'admin', 'uses' => 'AdminController@updateUsers']);
	
// APPLICATION MOBILE
Route::get('/mobile/login', 'Auth\AuthController@authenticateMobile');

Route::get('/mobile/logout',['middleware' => 'mobile', 'uses' => 'ProfilController@logoutMobile']);

Route::get('/mobile/profil',['middleware' => 'mobile', 'uses' => 'ProfilController@getProfileMobile']);

Route::get('/mobile/sschat',['middleware' => 'mobile', function () {
	return view('chat.sschatMobile');
}]);

Route::get('/mobile/image',['middleware' => 'mobile', function () {
	return Auth::user()->getImageMobile();
}]);