<?php

namespace App\Http\Controllers;

use App\Utilisateur_uti;
use Illuminate\Http\Request;
use View;
use DB;

class AdminController extends Controller
{
    public function usersView (Request $request)
    {
    	$users = Utilisateur_uti::all(['UTI_SEQNC', 'UTI_CODE' , 'UTI_NOM', 'UTI_PRENM', 'UTI_PERMS']);
    	return View::make('administration.users', compact('users',$users));
    }
    
    public function updateUsers (Request $request)
    {
    	$this->validate($request, [
    		'user' => 'required|exists:utilisateur_uti,uti_seqnc',
            'droit' => 'required',
    	]);
    	
    	$ok = false;
    	$message = trans('general.success');
    	
    	$permsCourn = DB::table('utilisateur_uti')->select('UTI_PERMS')->where('UTI_SEQNC', '=', $request['seqnc'])->get()[0]->UTI_PERMS;

    	if ($permsCourn == 'S')
    	{
    		$ok = true;
    	}
    	else if ($permsCourn == 'A')
    	{
    		$permsCible = DB::table('utilisateur_uti')->select('UTI_PERMS')->where('UTI_SEQNC', '=', $request['user'])->get()[0]->UTI_PERMS;
    		
    		if (($request['droit'] == 'A') || ($permsCible == 'A' && $request['droit'] == 'A'))
    		{
    			$ok = true;
    		}
    		else 
    		{
    			$message = trans('admin.erreur_droit');
    		}
    	}

    	if ($ok)
    	{
    		Utilisateur_uti::where('UTI_SEQNC', '=',$request->user)->update([
    				'uti_perms' => $request['droit'],
    		]);
    		
    		return back()->with('status', $message);
    	}
		else {
    		return back()->with('error', $message);
		}
    }
    
    public function poolView (Request $request)
    {
    	$types = DB::table('type_pool_typ')->select('TYP_SEQNC', 'TYP_NOM')->get();
    	return View::make('administration.pool', compact('types',$types));
    }
    
    public function createPool (Request $request)
    {
    	$this->validate($request, [
    			'type' => 'required|exists:type_pool_typ,typ_seqnc',
    			'nom' => 'required|unique:pool_poo,poo_nom',
    	]);

    	$typeFormt = DB::table('type_pool_typ')->select('TYP_NOM')->where('TYP_SEQNC', '=', $request['type'])->get()[0]->TYP_NOM;
    	
    	try {
    		$saison = DB::table('saison_sai')->select("SAI_SEQNC")->orderBy("sai_date_debut")->limit(1)->get();
    		if (isset ($saison[0]))
    		{
    			DB::table('pool_poo')->insert(['POO_NOM' => $request ['nom'],'POO_TYP_SEQNC' => $request['type'], 'POO_SAI_SEQNC' => $saison[0]->SAI_SEQNC]);
	    		$pool = DB::getPdo()->lastInsertId();
    		}
	    	else 
	    	{
    			return back()-> with('error', trans('admin.erreur_saison'));
	    	}
    	} catch(\Illuminate\Database\QueryException $e){
    		return back()-> with('error', trans('admin.erreur_saison'));
    	}
    	//DB::table('utilisateur_pool_utp')->insert(['UTP_UTI_SEQNC' => $request ['seqnc'],'UTP_POO_SEQNC' => $pool]);
    	
    	return back()->with('status', trans('admin.success_createPool', [
    			'nom' => $request ['nom'],
    			'type' => trans('pagination.' .$typeFormt),
    	]));
    }
}
