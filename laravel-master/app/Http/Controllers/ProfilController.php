<?php

namespace App\Http\Controllers;

use App\Utilisateur_uti;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App;
use JWTAuth;
use Auth;

class ProfilController extends Controller
{
    public function update(Request $request)
    {
		App::setLocale(strtolower(Auth::user()->getLangue()));
    	 
    	$this->validate($request, [
    		'telph' => 'Regex:/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/',
            'nom' => 'required|max:80',
            'prenm' => 'required|max:80',
            'code' => 'required|max:255',
            'courl' => 'required|email|max:255',
    			
    	]);
    	
    	Utilisateur_uti::where('UTI_SEQNC', '=',$request->seqnc)->update([
            'uti_nom' => $request['nom'],
            'uti_prenm' => $request['prenm'],
            'uti_code' => $request['code'],
            'uti_courl' => $request['courl'],
            'uti_telph' => $request['telph'],
        ]);
    	
    	$path = $request->file('img');
    	$img_data = $type = null;
    	if ($path != '')
    	{
    		$this->validate($request, ['img' => 'image|max:1000',]);
    		ob_start();
    		$content = file_get_contents($path);
    		$size = getimagesize($path);
    		$png = imagepng(imagecreatefromstring($content));
    		$png = ob_get_contents();
    		ob_end_clean();
    		
    		
    		$type = $path->getClientOriginalExtension();
    		$type = 'PNG';
    	
    		Utilisateur_uti::where('UTI_SEQNC', '=',$request->seqnc)->update([
    				'uti_image' => $png,
    				'uti_type_image' => $type,
    		]);
    	}
    	
    	if ($request['paswd'] != '')
    	{
    		$this->validate($request, ['paswd' => 'required|confirmed|min:6',]);
    	
     		Utilisateur_uti::where('UTI_SEQNC', '=',$request->seqnc)->update([
            'uti_paswd' =>  bcrypt($request['paswd']),
        	]);
    	}
    	return back()->with('status', 'Les modifications ont bel et bien été apportées');
    	
    }
    
    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function getResetValidationRules()
    {
    	return [
    			'password' => 'required|confirmed|min:6',
    	];
    }
    
    public function logoutMobile(Request $request)
    {
    	JWTAuth::invalidate();
    }
    
    public function getProfileMobile(Request $request)
    {
    	$user = JWTAuth::toUser($request['token']);
    	return response()->json(array_only($user->toArray(),array('UTI_NOM', 'UTI_PRENM', 'UTI_COURL', 'UTI_TELPH', 'UTI_CODE')));
    }
}
