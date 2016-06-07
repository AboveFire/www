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

Route::auth();


/********************** PARAMÈTRES **********************/
Route::get('/switchLangue', 'LangueController@switchLangue');

Route::post('/param/save', ['middleware' => 'auth', 'uses' => 'ParamController@update']);

Route::get('/param',['middleware' => 'auth', function () {
	return view('param');
}]);

/********************** PROFIL **********************/
Route::post('/profil/save',['middleware' => 'auth', 'uses' =>  'ProfilController@update']);

Route::get('/profil',['middleware' => 'auth', function () {
	return view('profil');
}]);


/********************** CHAT **********************/
Route::post('/sschat', ['middleware' => 'auth', 'uses' => 'ChatController@run']);

Route::get('/chat',['middleware' => 'auth', function () {
    return view('chat.sschat');
}]);


/********************** DATA GENERATION **********************/
Route::get('/test', 'NFLController@test');
//Normal route
Route::get('/connection-refused',function () {
	return view('refused');
});


/********************** ABOUT **********************/
Route::get('/about', function () {
	return view('about');
});


/********************** POOLS **********************/
// REQUÊTES GET
Route::get('/results', function () {
	return view('results');
});

Route::get ('/poolClassic', ['middleware' => 'auth', 'uses' => 'PoolController@getPoolClassic']);
Route::get ('/poolPlayoff', ['middleware' => 'auth', 'uses' => 'PoolController@getPoolPlayoff']);
Route::get ('/poolSurvivor', ['middleware' => 'auth', 'uses' => 'PoolController@getPoolSurvivor']);

Route::get ('/voteClassic', ['middleware' => 'auth', 'uses' => 'PoolController@getVoteClassic']);
Route::get ('/votePlayoff', ['middleware' => 'auth', 'uses' => 'PoolController@getVotePlayoff']);
Route::get ('/voteSurvivor', ['middleware' => 'auth', 'uses' => 'PoolController@getVoteSurvivor']);

// REQUÊTES POST
Route::post ('/inscription', ['middleware' => 'auth', 'uses' => 'PoolController@sinscrire']);

Route::post ('/vote', ['middleware' => 'auth', 'uses' => 'PoolController@vote']);

/*********************** RESULTS ***************************/

Route::post('/ssresults', ['middleware' => 'auth', 'uses' => 'ResultsController@ajax']);

/********************** ADMINISTRATION **********************/
Route::get('/admin',['middleware' => 'admin', function () {
	return view('administration.home');
}]);

Route::get('/admin/users',['middleware' => 'admin', 'uses' => 'AdminController@usersView']);
	
Route::get('/admin/pool',['middleware' => 'admin', 'uses' => 'AdminController@poolView']);

Route::post('/admin/users/update',['middleware' => 'admin', 'uses' => 'AdminController@updateUsers']);

Route::post('/admin/pool/create',['middleware' => 'admin', 'uses' => 'AdminController@createPool']);

	
/********************** APPLICATION MOBILE **********************/
Route::get('/mobile/login', 'Auth\AuthController@authenticateMobile');

Route::get('/mobile/logout',['middleware' => 'mobile', 'uses' => 'ProfilController@logoutMobile']);

Route::get('/mobile/profil',['middleware' => 'mobile', 'uses' => 'ProfilController@getProfileMobile']);

Route::get('/mobile/results',['middleware' => 'mobile', 'uses' => 'ResultsController@getMatchMobile']);

Route::get('/mobile/pool-classique',['middleware' => 'mobile', 'uses' => 'PoolController@obtenStatsPoolClasqMobile']);

Route::get('/mobile/chat',['middleware' => 'mobile', function () {
	return view('chat.sschatMobile');
}]);
	
Route::post('/mobile/sschat', 'ChatController@run');

Route::get('/mobile/image',['middleware' => 'mobile', function () {
	return Auth::user()->getImageMobile();
}]);