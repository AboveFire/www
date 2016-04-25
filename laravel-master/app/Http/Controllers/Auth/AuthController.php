<?php

namespace App\Http\Controllers\Auth;

use App\Utilisateur_uti;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

use JWTAuth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
	protected $username = 'uti_code';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nom' => 'required|max:80',
            'prenm' => 'required|max:80',
            'code' => 'required|max:255',
            'courl' => 'required|email|max:255|unique:utilisateur_uti,uti_courl',
            'paswd' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Utilisateur_uti::create([
            'uti_nom' => $data['nom'],
            'uti_prenm' => $data['prenm'],
            'uti_code' => $data['code'],
            'uti_courl' => $data['courl'],
            'uti_paswd' => bcrypt($data['paswd']),
        ]);
    }
    
    public function authenticateMobile(Request $request)
    {
    	// grab credentials from the request
    	$credentials = $request->only('uti_code', 'uti_paswd');
    
    	try {
    		// attempt to verify the credentials and create a token for the user
    		if (! $token = JWTAuth::attempt($credentials)) {
    			return response()->json(['error' => 'invalid_credentials'], 401);
    		}
    	} catch (JWTException $e) {
    		// something went wrong whilst attempting to encode the token
    		return response()->json(['error' => 'could_not_create_token'], 500);
    	}
    
    	// all good so return the token
    	return response()->json(compact('token'));
    }
 }
