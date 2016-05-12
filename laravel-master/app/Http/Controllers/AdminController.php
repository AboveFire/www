<?php

namespace App\Http\Controllers;

use App\Utilisateur_uti;
use Illuminate\Http\Request;
use View;

class AdminController extends Controller
{
    public function users (Request $request)
    {
    	$users = Utilisateur_uti::all(['UTI_SEQNC', 'UTI_CODE' , 'UTI_NOM', 'UTI_PRENM']);
    	
    	return View::make('administration.users', compact('users',$users));
    }
    
    public function updateUsers (Request $request)
    {
    	$this->validate($request, [
    		'user' => 'required|exists:utilisateur_uti,uti_seqnc',
            'droit' => 'required',
    	]);
    	return back();
    }
}
