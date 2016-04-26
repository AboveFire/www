<?php

namespace App\Http\Controllers;

use App\Utilisateur_uti;
use Illuminate\Http\Request;
use Log;

class ProfilController extends Controller
{
    public function update(Request $request)
    {
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
    		$img_data = file_get_contents($path);
    		
    		$this->validate($request, ['img' => 'image',]);
    		
    		$type = $path->getClientOriginalExtension();
    	
    		Utilisateur_uti::where('UTI_SEQNC', '=',$request->seqnc)->update([
    				'uti_image' => $img_data,
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
}