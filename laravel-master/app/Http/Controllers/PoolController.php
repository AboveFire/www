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
use Illuminate\Routing\Controller as BaseController;

class PoolController extends BaseController {
	public function sinscrire(Request $request) {
		DB::table ( 'utilisateur_pool_utp' )->insert ( [ 
				'UTP_UTI_SEQNC' => Auth::user ()->UTI_SEQNC,
				'UTP_POO_SEQNC' => $request ['poolCourant'] 
		] );
	}
	
	public function getImagesPartie($partie)
	{
		if($partie == null and !isset ($partie[0])){
			return null;
		}
		else
		{
			$codes = DB::table ( 'equipe_eqp' )
			->join ( 'partie_equipe_peq', 'eqp_seqnc', '=', 'peq_eqp_seqnc' )
			->join ( 'partie_par', 'par_seqnc', '=', 'peq_par_seqnc' )
			->select ('EQP_CODE')
			->where ('par_seqnc', $partie[0]->PAR_SEQNC)
			->orderBy('peq_score')
			->get();
			
			return array ('image1' => asset('images/teams/' . $codes[0]->EQP_CODE . '.png'),
						  'image2' => asset('images/teams/' . $codes[1]->EQP_CODE . '.png'),
			);
		}
	}
	
	public function getPool(Request $request) {
		$courn = $request ['poolCourant'];
		$typePool = $request ['typePool'];
		$user = Auth::user ()->UTI_SEQNC;
		
		$pools = DB::table ( 'pool_poo' )
					->join ('type_pool_typ', 'typ_seqnc', '=', 'poo_typ_seqnc')
				 	->select ( 'POO_SEQNC', 'POO_NOM' )
				 	->where ('typ_nom', $typePool)
					->get ();
		

		/*->whereIn ( 'poo_seqnc', DB::table ( 'utilisateur_pool_utp' )
				->select ( 'utp_poo_seqnc' )
				->where ( 'utp_uti_seqnc', $user ) )*/
		
		if ($courn == null and isset($pools[0])) {
			$courn = $pools [0]->POO_SEQNC;
		}
		
		$users = DB::table ( 'utilisateur_uti' )
					->select ( 'UTI_SEQNC', 'UTI_NOM' )
					->whereIn ( 'uti_seqnc', DB::table ( 'utilisateur_pool_utp' )
												->select ( 'utp_uti_seqnc' )
												->where ( 'utp_poo_seqnc', $courn ) )
					->get ();
		
		$partie_suivt = DB::table ( 'partie_par' )
							->join ( 'semaine_sem', 'sem_seqnc', '=', 'par_sem_seqnc' )
							->join ( 'saison_sai', 'sai_seqnc', '=', 'sem_sai_seqnc' )
							->join ( 'pool_poo', 'sai_seqnc', '=', 'poo_sai_seqnc' )
							->select ('PAR_SEQNC')
							->whereRaw ('par_date > sysdate()')
							->where ('poo_seqnc', $courn)
                    		->orderBy('par_date')
                    		->take (1)
							->get();
		
		$partie_precd = DB::table ( 'partie_par' )
							->join ( 'semaine_sem', 'sem_seqnc', '=', 'par_sem_seqnc' )
							->join ( 'saison_sai', 'sai_seqnc', '=', 'sem_sai_seqnc' )
							->join ( 'pool_poo', 'sai_seqnc', '=', 'poo_sai_seqnc' )
							->select ('PAR_SEQNC')
							->whereRaw ('par_date < sysdate()')
							->where ('poo_seqnc', $courn)
							->orderBy('par_date', 'desc')
							->take (1)
							->get();
							
		return View::make ( '/pool/non-inscrit', array (
				'typePool' => $typePool,
				'pools' => $pools,
				'poolCourant' => $courn,
				'users' => $users,
				'partie_precd' => $this->getImagesPartie($partie_precd),
				'partie_suivt' => $this->getImagesPartie($partie_suivt),
		) );
	}
}
