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

Route::get('/', function () {
	if(Auth::guest())
	{
		return view('/auth/login');		
	}
	else 
	{
    	return view('home');
	}
});

Route::post('/profil/save', 'ProfilController@update');


Route::post('/sschat', 'ChatController@run');
/*Route::get('/chat', function () {
    return view('chat.sschat');
});*/
Route::get('/chat',['middleware' => 'auth.basic', function () {
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
Route::get('/inscription', function () {
	return view('/auth/register');
});
Route::get('/profil',['middleware' => 'auth.basic', function () {
	return view('profil');
}]);

Route::get('/results', function () {
	return view('results');
});
//Pool route
Route::get('/form-classic',['middleware' => 'auth.basic', function () {
	return view('pool.forms.classic');
}]);
Route::get('/form-playoff',['middleware' => 'auth.basic', function () {
	return view('pool.forms.playoff');
}]);
Route::get('/form-survivor',['middleware' => 'auth.basic', function () {
	return view('pool.forms.survivor');
}]);
Route::get('/results-classic', function () {
	return view('pool.results.classic');
});
Route::get('/results-playoff', function () {
	return view('pool.results.playoff');
});
Route::get('/results-survivor', function () {
	return view('pool.results.survivor');
});
//Administration route
Route::get('/admin-home',['middleware' => 'admin', function () {
	return view('administration.home');
}]);
Route::get('/admin-pool',['middleware' => 'admin', function () {
	return view('administration.pool');
}]);
Route::get('/admin-users',['middleware' => 'admin', function () {
	return view('administration.users');
}]);

// APPLICATION MOBILE
Route::get('/mobile/login', 'Auth/AuthController@authenticateMobile');