<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Log;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
    	$this->validate($request, ['uti_courl' => 'required|email']);
    
    	$broker = $this->getBroker();
    
    	$response = Password::broker($broker)->sendResetLink($request->only('uti_courl'), function (Message $message) {
    		$message->subject($this->getEmailSubject());
    	});
    
    		switch ($response) {
    			case Password::RESET_LINK_SENT:
    				return $this->getSendResetLinkEmailSuccessResponse($response);
    
    			case Password::INVALID_USER:
    			default:
    				return $this->getSendResetLinkEmailFailureResponse($response);
    		}
    }
    
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
    	$this->validate($request, $this->getResetValidationRules());

    	$credentials = $request->only(
    			'uti_courl', 'password', 'password_confirmation', 'token'
    			);

    	$broker = $this->getBroker();

    	$response = Password::broker($broker)->reset($credentials, function ($user, $password) {
    		$this->resetPassword($user, $password);
    	});



    		switch ($response) {
    			case Password::PASSWORD_RESET:
    				return $this->getResetSuccessResponse($response);
    
    			default:
    				return $this->getResetFailureResponse($request, $response);
    		}
    }
    
    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function getResetValidationRules()
    {
    	return [
    			'token' => 'required',
    			'uti_courl' => 'required|email',
    			'password' => 'required|confirmed|min:6',
    	];
    }
    
    /**
     * Get the response for after a failing password reset.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function getResetFailureResponse(Request $request, $response)
    {
    	return redirect()->back()
    	->withInput($request->only('uti_courl'))
    	->withErrors(['uti_courl' => trans($response)]);
    }
}
