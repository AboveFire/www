<?php

namespace App\Http\Controllers;

use App\Utilisateur_uti;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App;
use JWTAuth;
use Auth;
use DB;
use View;

class PoolController extends Controller
{
    public function sinscrire (Request $request)
    {
    	DB::table('utilisateur_pool_utp')->insert(['UTP_UTI_SEQNC' => Auth::user()->UTI_SEQNC,'UTP_POO_SEQNC' => $request['poolCourant']]);
    }
    
    public function getPool (Request $request)
    {
    	$courn = $request ['poolCourant'];
    	
    	$typePool = $request ['typePool'];

    	$user = Auth::user()->UTI_SEQNC;
    	
    	$lienPools = DB::table('utilisateur_pool_utp')->select('utp_poo_seqnc')->where('utp_uti_seqnc', $user);
    	
    	$pools = DB::table('pool_poo')->select('POO_SEQNC', 'POO_NOM')->whereIn('poo_seqnc', $lienPools)->get();
    	
    	if ($courn == null)
    	{
    		$courn = $pools[1]->POO_SEQNC;
    	}
    	
    	return View::make('/pool/non-inscrit', array('typePool' => $typePool,
    												 'pools' 	=> $pools,
    												 'poolCourant' 	=> $courn,
    	));
    }
}
