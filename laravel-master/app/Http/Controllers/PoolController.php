<?php

namespace App\Http\Controllers;

use App\Utilisateur_uti;
use Illuminate\Http\Request;
use App;
use Auth;
use DB;
use View;
use Illuminate\Routing\Controller as BaseController;

class PoolController extends BaseController {
	
	private function obten_utils_pool (int $pool)
	{
		return DB::table ( 'utilisateur_uti' )
					->select ( 'UTI_SEQNC', 'UTI_NOM', 'UTI_PRENM' )
					->whereIn ( 'uti_seqnc', DB::table ( 'utilisateur_pool_utp' )
												->select ( 'utp_uti_seqnc' )
												->where ( 'utp_poo_seqnc', $pool ) )
					->get ();
	}
	
	private function obten_parties_pool_utils (int $utils, int $pool)
	{
		return DB::table ( 'partie_equipe_peq' )
					->join ( 'vote_vot', 'vot_peq_seqnc', '=', 'peq_seqnc' )
					->select ('PEQ_PAR_SEQNC')
					->where ('vot_poo_seqnc', $pool)
					->where ('vot_uti_seqnc', $utils)
					->get();
	}
	
	private function obten_points_vote_clasq (int $utils, int $pool, int $partie)
	{
		return DB::select('select case 
								  when indic_win = \'O\' 
							      and ((peq_indic_home = \'O\' and par_cote < 0)
										or (peq_indic_home = \'N\' and par_cote > 0)) then
								   1.5
								 when indic_win = \'O\' 
							      and ((peq_indic_home = \'O\' and par_cote > 0)
										or (peq_indic_home = \'N\' and par_cote < 0)) then
								1
								 when indic_win = \'N\'
									and ((peq_indic_home = \'O\' and par_cote > 0)
									    or (peq_indic_home = \'N\' and par_cote < 0))
									and (dif_valr < par_cote)then
							         0.5
								   else
									 0
								   end
							         score
							  from vote_vot,
								   partie_par,
								   (select peq_seqnc, peq_indic_home, \'O\' indic_win
								     from partie_equipe_peq
								    where PEQ_PAR_SEQNC = ?
								      and peq_score = (select max(peq_score)
								     from partie_equipe_peq
								    where PEQ_PAR_SEQNC = ?)
								   union
								   select peq_seqnc, peq_indic_home, \'N\' indic_win
							  	     from partie_equipe_peq
								    where PEQ_PAR_SEQNC = ?
							 	      and peq_score = (select min(peq_score)
								     from partie_equipe_peq
								    where PEQ_PAR_SEQNC = ?)) reslt,
								   (select max(peq_score) - min(peq_score) dif_valr
							  	      from partie_equipe_peq
								     where PEQ_PAR_SEQNC = ?) dif
							 where peq_seqnc = vot_peq_seqnc
							   and par_seqnc = ?
							   and vot_uti_seqnc = ?
							   and vot_poo_seqnc = ?',
				[$partie,$partie,$partie,$partie,$partie,$partie,$utils,$pool,])[0]->score;
	}
	
	private function obten_score_pool_clasq ($utils, $pool)
	{
		$parties = $this::obten_parties_pool_utils($utils, $pool);
		$score = 0;
		
		foreach ($parties as $partie)
		{
			$score += $this::obten_points_vote_clasq ($utils, $pool, $partie->PEQ_PAR_SEQNC);
		}
		
		return $score;
	}
	
	function sortBySubValue($array, $value, $asc = true, $preserveKeys = false)
	{
		if ($preserveKeys) {
			$c = array();
			if (is_object(reset($array))) {
				foreach ($array as $k => $v) {
					$b[$k] = strtolower($v->$value);
				}
			} else {
				foreach ($array as $k => $v) {
					$b[$k] = strtolower($v[$value]);
				}
			}
			$asc ? asort($b) : arsort($b);
			foreach ($b as $k => $v) {
				$c[$k] = $array[$k];
			}
			$array = $c;
		} else {
			if (is_object(reset($array))) {
				usort($array, function ($a, $b) use ($value, $asc) {
					return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} - $b->{$value}) * ($asc ? 1 : -1);
				});
			} else {
				usort($array, function ($a, $b) use ($value, $asc) {
					return $a[$value] == $b[$value] ? 0 : ($a[$value] - $b[$value]) * ($asc ? 1 : -1);
				});
			}
		}
		return $array;
	}
	
	public function getPool(Request $request) {
		$courn = $request ['poolCourant'];
		$typePool = $request ['typePool'];
		$stats = array();
		
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
		
		$users = $this::obten_utils_pool ($courn);
		
		foreach ($users as $user )
		{
			$stat = array ("utils" => $user->UTI_SEQNC,
							"nom" => $user->UTI_PRENM . ' ' . $user->UTI_NOM,
							"score" => $this::obten_score_pool_clasq($user->UTI_SEQNC, $courn),
							"rang" => 1,
			);
			array_push ($stats, $stat);
		}
		
		$stats = $this::sortBySubValue($stats, "score");
		//dd($stats[0]);
		$stats = array_unique($stats);
		if ((count ($stats) > 2) && $stats[0]["score"] != $stats[1]["score"])
		{
			$i = 1;
		}
		else
		{
			$i = 2;
		}

		$precd = -1;
		foreach($stats as $stat) {
			if ($stat["score"] != $precd)
			{
				$i++;
			}
			
			$stat["rang"] = $i;
			$precd = $stat["score"];
		}
		
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
				'scores' => $stats,
				'partie_precd' => $this->getImagesPartie($partie_precd),
				'partie_suivt' => $this->getImagesPartie($partie_suivt),
		) );
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

	public function sinscrire(Request $request) {
		DB::table ( 'utilisateur_pool_utp' )->insert ( [
				'UTP_UTI_SEQNC' => Auth::user ()->UTI_SEQNC,
				'UTP_POO_SEQNC' => $request ['poolCourant']
		] );
	}
}
