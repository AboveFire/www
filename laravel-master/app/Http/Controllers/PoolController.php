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
	
	private function obtenTypePool ($pool)
	{
		return DB::table ( 'type_pool_typ' )
		->select ( 'TYP_NOM' )
		->whereIn ( 'typ_seqnc', DB::table ( 'pool_poo' )
				->select ( 'POO_TYP_SEQNC' )
				->where ( 'POO_SEQNC', $pool ) )
				->get ()[0]->TYP_NOM;
	}
	
	private function obtenUtilsPool ($pool)
	{
		return DB::table ( 'utilisateur_uti' )
					->select ( 'UTI_SEQNC', 'UTI_NOM', 'UTI_PRENM', 'UTI_CODE' )
					->whereIn ( 'uti_seqnc', DB::table ( 'utilisateur_pool_utp' )
												->select ( 'utp_uti_seqnc' )
												->where ( 'utp_poo_seqnc', $pool ) )
					->get ();
	}
	
	public function obtenCurrentSeason(){
		return DB::table('saison_sai')->select('SAI_SEQNC')->where('SAI_DATE_DEBUT', '<=', date('Y-m-d H:i:s'))->where('SAI_DATE_FIN', '>=', date('Y-m-d H:i:s'))->get()[0]->SAI_SEQNC;
	}
	
	private function obtenPartiesPoolUtils ($utils, $pool)
	{
		return DB::table ( 'partie_equipe_peq' )
					->join ( 'vote_vot', 'vot_peq_seqnc', '=', 'peq_seqnc' )
					->select ('PEQ_PAR_SEQNC')
					->where ('vot_poo_seqnc', $pool)
					->where ('vot_uti_seqnc', $utils)
					->get();
	}
	
	public function obtenGames($semaineCourante)
	{		
		return DB::table("partie_par")
		->join("partie_equipe_peq AS O", function($join){
			$join->on("partie_par.par_seqnc", "=", "O.peq_par_seqnc")	
			->where("O.peq_indic_home", "=", "O");
		})
		->join('equipe_eqp as EO', 'O.PEQ_EQP_SEQNC', '=', 'EO.EQP_SEQNC' )
		->join("partie_equipe_peq AS N", function($join){
			$join->on("partie_par.par_seqnc", "=", "N.peq_par_seqnc")
			->where("N.peq_indic_home", "=", "N");
		})
		->join('equipe_eqp AS EN', 'N.PEQ_EQP_SEQNC', '=', 'EN.EQP_SEQNC' )
		->join('semaine_sem AS SEM', 'SEM_SEQNC', '=', 'partie_par.PAR_SEM_SEQNC' )
		->select("partie_par.par_seqnc AS PARTIE", "partie_par.par_date AS DATE", "partie_par.par_cote AS COTE","EN.eqp_code AS EQUIPE1","EO.eqp_code AS EQUIPE2")
		->where("SEM.SEM_NUMR", $semaineCourante)
		->orderBy('PAR_DATE')
		->get();
	}
	
	private function obtenSemaines($saisonCourante)
	{
		return DB::table ( 'semaine_sem' )
		->select ( 'SEM_SEQNC', 'SEM_NUMR')
		->where ('SEM_SAI_SEQNC', $saisonCourante)
		->get ();
	}
	
	private function estParticipant ($utils, $pool)
	{
		return 0 < DB::table ( 'utilisateur_pool_utp' )
						->select ('UTP_SEQNC')
						->where ('UTP_POO_SEQNC', $pool)
						->where ('UTP_UTI_SEQNC', $utils)
						->count();
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
	
	public function obtenPoolsSelonType ($type, $utilsInscr = null)
	{
		$pools =  DB::table ( 'pool_poo' )
					->join ('type_pool_typ', 'typ_seqnc', '=', 'poo_typ_seqnc');
		
		if ($utilsInscr != null)
		{
			$pools = $pools->join ('utilisateur_pool_utp', 'utp_poo_seqnc', '=', 'poo_seqnc')
						   ->select ( 'POO_SEQNC', 'POO_NOM' )
						   ->where ('utp_uti_seqnc', $utilsInscr);
		}
		else 
		{
			$pools = $pools->select ( 'POO_SEQNC', 'POO_NOM' );
		}
				 	
		return $pools->where ('typ_nom', $type)
					 ->get ();
	}
	
	public function obtenPoolsSelonTypeMobile(Request $request){
		return json_encode($this->obtenPoolsSelonType($request["type"]));
	}
	
	private function ajoutVote ($pool, $utils, $partieEquipe, $multp = null)
	{
		DB::table ( 'vote_vot' )->insert ( [
				'VOT_POO_SEQNC' => $pool,
				'VOT_UTI_SEQNC' => $utils,
				'VOT_PEQ_SEQNC' => $partieEquipe,
				'VOT_MULTP' => $multp,
		] );
	}
	
	private function obtenPartieDeString ($string)
	{
		$retour = substr($string, 1,  strpos($string, '[') - 1);
		if (!is_numeric($retour))
		{
			$retour = null;
		}
		else
		{
			$retour = intval ($retour); 
		}
		
		return $retour;
	}
	
	private function obtenTeamDeString ($string)
	{
		$code = substr($string, strpos($string, '[') + 1, strpos($string, ']') - strpos($string, '[') - 1);
		return $this::obtenTeamDeCode($code);
	}
	
	private function obtenPartieEquipe ($partie, $equipe)
	{
		return DB::table ( 'partie_equipe_peq' )
					->select ( 'PEQ_SEQNC' )
					->where ('PEQ_PAR_SEQNC', $partie)
					->where ('PEQ_EQP_SEQNC', $equipe)
					->get ()[0]->PEQ_SEQNC;
	}
	
	private function obtenTeamDeCode($code)
	{
		return DB::table ( 'equipe_eqp' )
					->select ( 'EQP_SEQNC' )
					->where ('EQP_CODE', $code)
					->get ()[0]->EQP_SEQNC;
	}
	
	private function obtenTeams()
	{
		return DB::table ( 'equipe_eqp' )
				 	->select ( 'EQP_SEQNC', 'EQP_NOM', 'EQP_CODE' )
					->get ();
	}
	
	/*****************************************************************/
	private function obtenPointsVoteClasq ($utils, $pool, $partie)
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

	private function obtenScorePoolClasq ($utils, $pool)
	{
		$parties = $this::obtenPartiesPoolUtils($utils, $pool);
		$score = 0;
	
		foreach ($parties as $partie)
		{
			$score += $this::obtenPointsVoteClasq ($utils, $pool, $partie->PEQ_PAR_SEQNC);
		}
	
		return $score;
	}
	
	private function obtenStatsPoolClasq ($pool)
	{
		$stats = array();
		$users = $this::obtenUtilsPool ($pool);
			
		foreach ($users as $user )
		{
			$stat = array ("utils" => $user->UTI_SEQNC,
					"nom" => $user->UTI_CODE,
					"score" => $this::obtenScorePoolClasq($user->UTI_SEQNC, $pool),
					"rang" => 1,
			);
			array_push ($stats, $stat);
		}
			
		$stats = $this::sortBySubValue($stats, "score");
			
		if ((count ($stats) < 2) || $stats[0]["score"] != $stats[1]["score"])
		{
			$rang = 0;
		}
		else
		{
			$rang = 1;
		}
			
		$precd = -1;
		for($i = 0; $i < count($stats); $i++) {
			if ($stats[$i]["score"] != $precd)
			{
				$rang++;
			}
				
			$stats[$i]["rang"] = $rang;
			$precd = $stats[$i]["score"];
		}
		
		return $stats;
	}
	
	private function obtenPartiesPrecdSuivt ($pool)
	{
		$partie_suivt = DB::table ( 'partie_par' )
							->join ( 'semaine_sem', 'sem_seqnc', '=', 'par_sem_seqnc' )
							->join ( 'saison_sai', 'sai_seqnc', '=', 'sem_sai_seqnc' )
							->join ( 'pool_poo', 'sai_seqnc', '=', 'poo_sai_seqnc' )
							->select ('PAR_SEQNC')
							->whereRaw ('par_date > sysdate()')
							->where ('poo_seqnc', $pool)
							->orderBy('par_date')
							->take (1)
							->get();
		
		$partie_precd = DB::table ( 'partie_par' )
							->join ( 'semaine_sem', 'sem_seqnc', '=', 'par_sem_seqnc' )
							->join ( 'saison_sai', 'sai_seqnc', '=', 'sem_sai_seqnc' )
							->join ( 'pool_poo', 'sai_seqnc', '=', 'poo_sai_seqnc' )
							->select ('PAR_SEQNC')
							->whereRaw ('par_date < sysdate()')
							->where ('poo_seqnc', $pool)
							->orderBy('par_date', 'desc')
							->take (1)
							->get();
		
		return array ('partie_precd' => $this->getImagesPartie($partie_precd), 
					  'partie_suivt' => $this->getImagesPartie($partie_suivt));
	}
	
	public function obtenStatsPoolClasqMobile (Request $request){
		return json_encode($this->obtenStatsPoolClasq($request["pool"]));
	}
	
	public function getPoolClassic(Request $request) 
	{
		$courn = $request ['poolCourant'];
		$stats = array();
		
		$pools = $this::obtenPoolsSelonType('poolClassic');
					
		if ($courn == null and isset($pools[0])) {
			$courn = $pools [0]->POO_SEQNC;
		}
		if ($courn != null)
		{
			$stats = $this::obtenStatsPoolClasq($courn);
		}
		
		foreach ($stats as $stat)
		{
			if($stat['utils'] == Auth::user()->UTI_SEQNC)
			{
				$scoreCourn = $stat['score'];
				$rangCourn = $stat['rang'];
			}
		}
		
		if ($this::estParticipant(Auth::user()->UTI_SEQNC, $courn))
		{			
			return View::make ( '/pool/classic/inscrit', array_merge (array (
					'pools' => $pools,
					'poolCourant' => $courn,
					'scores' => $stats,
					'scoreCourn' => $scoreCourn,
					'rangCourn' => $rangCourn,
			) ), $this::obtenPartiesPrecdSuivt($courn));
		}
		else
		{
			return View::make ( '/pool/classic/non-inscrit', array_merge (array (
				'pools' => $pools,
				'poolCourant' => $courn,
				'scores' => $stats,
		) ), $this::obtenPartiesPrecdSuivt($courn));
		}
	}
	
	public function getVoteClassic(Request $request)
	{
		$courn = $request ['poolCourant'];
		$semCour = $request ['semaineCourante'];
		$pools = $this::obtenPoolsSelonType('poolClassic', Auth::user()->UTI_SEQNC);
		$semas = $this::obtenSemaines($this::obtenCurrentSeason());
			
		if ($courn == null and isset($pools[0])) {
			$courn = $pools [0]->POO_SEQNC;
		}
		
		if ($semCour == null and isset($semas[0])) {
			$semCour = $semas [0]->SEM_NUMR;
		}
		
		$games = $this::obtenGames($semCour);
	
		return View::make ( '/pool/classic/vote', array (
				'pools' => $pools,
				'games' => $games,
				'semas' => $semas,
				'semaineCourante' => $semCour,
				'poolCourant' => $courn,
				
		));
	}
	
	public function voteClassic (Request $request)
	{
		$courn = $request['poolCourant'];
		$semCour = $request['semaineCourante'];
		$messageRetour = array('type' => 'status',
				'contn' => trans('general.success')
		);
		
		$partiesServeur = array_column($this::obtenGames($semCour), 'PARTIE');
		$partiesVotes = array();
		
		$votes = json_decode($request['votes']);
		
		foreach ($votes as $vote)
		{
			array_push($partiesVotes, $this::obtenPartieDeString($vote));
		}
		
		if ($partiesServeur !== $partiesVotes)
		{
			$messageRetour = array('type' => 'error',
					'contn' => trans('pool.err_vote_classic', ['multp' => $multpErr])
			);
		}
		else
		{
			foreach ($votes as $vote)
			{
				dd($this::obtenPartieEquipe($this::obtenPartieDeString($vote), $this::obtenTeamDeString($vote)));
				$this::obtenTeamDeString($vote);
			}
		}
	
		return $messageRetour;
	}
	
	/*****************************************************************/
	private function obtenTeamsPlayoff($pool)
	{
		return DB::table ( 'equipe_eqp' )
					->join ( 'partie_equipe_peq', 'PEQ_EQP_SEQNC', '=', 'EQP_SEQNC' )
					->join ( 'partie_par', 'peq_par_seqnc', '=', 'par_seqnc' )
					->join ( 'semaine_sem', 'par_sem_seqnc', '=', 'sem_seqnc' )
					->join ( 'saison_sai', 'sem_sai_seqnc', '=', 'sai_seqnc' )
					->join ( 'pool_poo', 'poo_sai_seqnc', '=', 'sai_seqnc' )
					->select ( 'EQP_SEQNC', 'EQP_NOM', 'EQP_CODE' )
					->where ( 'sem_numr', 1 )
					->where ( 'POO_SEQNC', $pool )
					->take(12)
					->get ();
	}
	
	private function obtenMultpVote ($pool, $equipe, $utils)
	{
		$valr =  DB::table ( 'vote_vot' )
					->join ( 'partie_equipe_peq', 'VOT_PEQ_SEQNC', '=', 'PEQ_SEQNC' )
					->select ( 'VOT_MULTP')
					->where ( 'vot_poo_seqnc', $pool )
					->where ( 'vot_uti_seqnc', $utils )
					->where ( 'peq_eqp_seqnc', $equipe )
					->get ();

		if (isset($valr[0]))
		{
			return $valr[0]->VOT_MULTP;
		}
		else 
		{
			return null;
		}
	}
	private function obtenPartiesTeamPlayoff($pool, $team)
	{
		return DB::table ( 'partie_equipe_peq' )
					->join ( 'partie_par', 'peq_par_seqnc', '=', 'par_seqnc' )
					->join ( 'semaine_sem', 'par_sem_seqnc', '=', 'sem_seqnc' )
					->join ( 'saison_sai', 'sem_sai_seqnc', '=', 'sai_seqnc' )
					->join ( 'pool_poo', 'poo_sai_seqnc', '=', 'sai_seqnc' )
					->select ( 'PEQ_SEQNC' )
					->where ( 'sem_numr', 1 )
					->where ( 'peq_eqp_seqnc', $team )
					->where ( 'POO_SEQNC', $pool )
					->get ();
	}
	
	private function obtenPointsVotePlayf ($utils, $pool, $partie)
	{
		return DB::select('select case
								  when indic_win = \'N\'
							      then
								   (reslt.peq_score * vot_multp)
								 when indic_win = \'O\'
							     then
								 (((select min(peq_score) 
							  	      from partie_equipe_peq
								     where PEQ_PAR_SEQNC = ?) + (dif.dif_valr/2))*vot_multp)
								   else
									 0
								   end
							         score
							  from vote_vot,
								   partie_par,
								   (select peq_seqnc, peq_indic_home, peq_score, \'O\' indic_win
								     from partie_equipe_peq
								    where PEQ_PAR_SEQNC = ?
								      and peq_score = (select max(peq_score)
								     from partie_equipe_peq
								    where PEQ_PAR_SEQNC = ?)
								   union
								   select peq_seqnc, peq_indic_home, peq_score, \'N\' indic_win
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
				[$partie,$partie,$partie,$partie,$partie,$partie,$partie,$utils,$pool,])[0]->score;
	}	
	
	private function obtenScorePoolPlayf ($utils, $pool)
	{
		$parties = $this::obtenPartiesPoolUtils($utils, $pool);
		$score = 0;
	
		foreach ($parties as $partie)
		{
			$score += $this::obtenPointsVotePlayf ($utils, $pool, $partie->PEQ_PAR_SEQNC);
		}
	
		return $score;
	}
	
	private function obtenStatsPoolPlayf ($pool)
	{
		$stats = array();
		$users = $this::obtenUtilsPool ($pool);
			
		foreach ($users as $user )
		{
			$stat = array ("utils" => $user->UTI_SEQNC,
					"nom" => $user->UTI_CODE,
					"score" => $this::obtenScorePoolPlayf($user->UTI_SEQNC, $pool),
					"rang" => 1,
			);
			array_push ($stats, $stat);
		}
			
		$stats = $this::sortBySubValue($stats, "score");
			
		if ((count ($stats) < 2) || $stats[0]["score"] != $stats[1]["score"])
		{
			$rang = 0;
		}
		else
		{
			$rang = 1;
		}
			
		$precd = -1;
		for($i = 0; $i < count($stats); $i++) {
			if ($stats[$i]["score"] != $precd)
			{
				$rang++;
			}
	
			$stats[$i]["rang"] = $rang;
			$precd = $stats[$i]["score"];
		}
	
		return $stats;
	}
	
	public function obtenStatsPoolPlayfMobile (Request $request){
		return json_encode($this->obtenStatsPoolPlayf($request["pool"]));
	}
	
	public function getPoolPlayoff(Request $request) 
	{
		$courn = $request ['poolCourant'];
		$stats = array();
		
		$pools = $this::obtenPoolsSelonType('poolPlayoff');
		
		if ($courn == null and isset($pools[0])) {
			$courn = $pools [0]->POO_SEQNC;
		}
		if ($courn != null)
		{
			$stats = $this::obtenStatsPoolPlayf($courn);
		}
		
		foreach ($stats as $stat)
		{
			if($stat['utils'] == Auth::user()->UTI_SEQNC)
			{
				$scoreCourn = $stat['score'];
				$rangCourn = $stat['rang'];
			}
		}
		
		if ($this::estParticipant(Auth::user()->UTI_SEQNC, $courn))
		{			
			return View::make ( '/pool/playoff/inscrit', array_merge (array (
					'pools' => $pools,
					'poolCourant' => $courn,
					'scores' => $stats,
					'scoreCourn' => $scoreCourn,
					'rangCourn' => $rangCourn,
			) ), $this::obtenPartiesPrecdSuivt($courn));
		}
		else
		{
			return View::make ( '/pool/playoff/non-inscrit', array_merge (array (
				'pools' => $pools,
				'poolCourant' => $courn,
				'scores' => $stats,
		) ), $this::obtenPartiesPrecdSuivt($courn));
		}
	}
	
	public function getVotePlayoff (Request $request)
	{		
		$courn = $request ['poolCourant'];
		$voteActif = true;
		$pools = $this::obtenPoolsSelonType('poolPlayoff', Auth::user()->UTI_SEQNC);
			
		if ($courn == null and isset($pools[0])) {
			$courn = $pools [0]->POO_SEQNC;
		}
		
		$teams = $this::obtenTeamsPlayoff($courn);
	
		for ($i = 0; $i < sizeof($teams); $i++)
		{
			$teams[$i]->VOT_MULTP = $this::obtenMultpVote ($courn, $teams[$i]->EQP_SEQNC, Auth::user()->UTI_SEQNC);
			if ($voteActif && $teams[$i]->VOT_MULTP != null)
			{
				$voteActif = false;
			}
		}

		return View::make ( '/pool/playoff/vote', array (
				'pools' => $pools,
				'teams' => $teams,
				'poolCourant' => $courn,
				'voteActif' => $voteActif,
				
		));
	}
	
	public function votePlayoff (Request $request)
	{
		$courn = $request['poolCourant'];
		$arrayVotes = array();
		$multpErr = null;
		$messageRetour = array('type' => 'status',
							   'contn' => trans('general.success')
		);
		
		for ($i = 1;$i <= 12; $i++)
		{
			array_push($arrayVotes, array('valr' => $request['multp' . $i]));
		}
		
		$result = [];
		foreach ($arrayVotes as $item) {
			if (!isset($result[$item['valr']])) {
				$result[$item['valr']] = $item;
				$result[$item['valr']]['ocurn'] = 1;
			} else {
				$result[$item['valr']]['ocurn']++;
			}
		}
		
		foreach ($result as $result)
		{
			if ($result['ocurn'] != 2 )
			{
				$multpErr = $result['valr'];
			}
		}
		
		if ($multpErr != null)
		{
			$messageRetour = array('type' => 'error',
							 'contn' => trans('pool.err_vote_playoff', ['multp' => $multpErr])
			);
		}
		else 
		{
			$teams = $this::obtenTeamsPlayoff($courn);
			for ($i = 0; $i < sizeof($teams); $i++)
			{
				foreach ($this::obtenPartiesTeamPlayoff($courn, $teams[$i]->EQP_SEQNC) as $partieTeam)
				{
					$this::ajoutVote ($courn, Auth::user()->UTI_SEQNC, $partieTeam->PEQ_SEQNC, $arrayVotes[$i]['valr']);
				}
			}
		}
		
		return $messageRetour;
	}
	
	/*****************************************************************/
	private function obtenPointsVoteSurvr ($utils, $pool, $partie)
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

	public function getPoolSurvivorWinningTeamPerWeek($pWeek)
	{
		$match = DB::table("partie_par")
		->join("partie_equipe_peq AS O", function($join){
			$join->on("partie_par.par_seqnc", "=", "O.peq_par_seqnc")
			->where("O.peq_indic_home", "=", "O");
		})
		->join("partie_equipe_peq AS N", function($join){
			$join->on("partie_par.par_seqnc", "=", "N.peq_par_seqnc")
			->where("N.peq_indic_home", "=", "N");
		})
		->select("partie_par.par_seqnc", "partie_par.par_date AS date","O.peq_seqnc AS peq_home", "O.peq_score AS point_home","N.peq_seqnc AS peq_visitor", "N.peq_score AS point_visitor")
		->where("partie_par.par_sem_seqnc", "=", $pWeek)
		->where("partie_par.par_date", "<", date('Y-m-d H:i:s'))
		->get();
		$winning = [];
		foreach($match as $partie){
			if($partie->point_home > $partie->point_visitor){
				$winning[] = $partie->peq_home;
			}elseif($partie->point_home < $partie->point_visitor){
				$winning[] = $partie->peq_visitor;
			}
		}
		return $winning;
	}
	
	public function checkPoolSurvivorUserAlive(){
		$pool = 5;
		$alive = [];
		//$present = [];
		$weeks = DB::select("SELECT * FROM `semaine_sem`, vote_vot WHERE sem_date_fin < NOW() and vot_poo_seqnc = ? and sem_seqnc in (SELECT par_sem_seqnc from partie_par, partie_equipe_peq where par_seqnc = peq_par_seqnc and peq_seqnc = vot_peq_seqnc);", [$pool]);
		foreach($weeks as $vote){
			$temp = $this->getPoolSurvivorWinningTeamPerWeek($vote->SEM_SEQNC);
			if(in_array($vote->VOT_PEQ_SEQNC, $temp)){
				$alive[$vote->SEM_SEQNC]['alive'][] = $vote->VOT_UTI_SEQNC;
				//$present[] = $vote->VOT_UTI_SEQNC;
			}
		}
		/*$players = $this->obtenUtilsPool($pool);
		$saison = DB::table("pool_poo")->where("POO_SEQNC", "=", $pool)->get()[0]->POO_SAI_SEQNC;
		$allWeeks = DB::table("semaine_sem")->where("SEM_SAI_SEQNC","=",$saison)->get();
		foreach($allWeeks as $week){
			if(!array_key_exists($week->SEM_SEQNC, $alive)){
				$alive[$week->SEM_SEQNC]['alive'] = [];
			}
			foreach($players as $player){
				if(!in_array($player->UTI_SEQNC, $alive[$week->SEM_SEQNC]['alive'])){
					$alive[$week->SEM_SEQNC]['dead'][] = $player->UTI_SEQNC;
				}
			}
		}*/
		return $alive;
	}
	
	private function obtenStatsPoolSurvr ($pool)
	{
		//$pool=5;
		$saison = DB::table ('pool_poo')->select('POO_SAI_SEQNC')->where('POO_SEQNC', $pool)->get()[0]->POO_SAI_SEQNC;
		$semaines = DB::table("semaine_sem")->where("sem_sai_seqnc", $saison)->where("sem_date_fin", "<", date('Y-m-d H:i:s'))->get();
		$userAlive = $this->checkPoolSurvivorUserAlive($pool);
		$userInPool = $this->obtenUtilsPool($pool);
		ksort($userAlive, SORT_NUMERIC);
		$dead = [];
		foreach($semaines as $semaine){
			foreach($userInPool as $value){
				if(array_key_exists($semaine->SEM_SEQNC, $userAlive) && in_array($value->UTI_SEQNC, $userAlive[$semaine->SEM_SEQNC]['alive'])){
					if(!array_key_exists($value->UTI_SEQNC, $dead)){
						$dead[$value->UTI_SEQNC] = ["seqnc" => $value->UTI_SEQNC ,"week" => -1, "code" => $value->UTI_CODE];
					}
				}else{
					if(!array_key_exists($value->UTI_SEQNC, $dead) || $dead[$value->UTI_SEQNC]["week"] == -1){
						$dead[$value->UTI_SEQNC] = ["seqnc" => $value->UTI_SEQNC ,"week" => $semaine->SEM_SEQNC, "code" => $value->UTI_CODE];
					}
				}
			}
		}
		return $dead; 
	}
	
	public function obtenStatsPoolSurvrMobile (Request $request){
		return json_encode($this->obtenStatsPoolSurvr($request["pool"]));
	}
	
	public function getPoolSurvivor(Request $request)
	{
		$courn = $request ['poolCourant'];
		$stats = array();
		$rangCourn = 0;
		$scoreCourn = 0;
		
		$pools = $this::obtenPoolsSelonType('poolSurvivor');
			
		if ($courn == null and isset($pools[0])) {
			$courn = $pools [0]->POO_SEQNC;
		}
		if ($courn != null)
		{
			$stats = $this::obtenStatsPoolSurvr($courn);
		}
				
		if ($this::estParticipant(Auth::user()->UTI_SEQNC, $courn))
		{	
			return View::make ( '/pool/survivor/inscrit', array_merge (array (
					'pools' => $pools,
					'poolCourant' => $courn,
					'scores' => $stats,
					'scoreCourn' => $scoreCourn,
					'rangCourn' => $rangCourn,
			) ), $this::obtenPartiesPrecdSuivt($courn));
		}
		else
		{
			return View::make ( '/pool/survivor/non-inscrit', array_merge (array (
				'pools' => $pools,
				'poolCourant' => $courn,
				'scores' => $stats,
		) ), $this::obtenPartiesPrecdSuivt($courn));
		}
	}
	public function getVoteSurvivor(Request $request)
	{
		$courn = $request ['poolCourant'];
	
		$semCour = $request ['semaineCourante'];
	
		$pools = $this::obtenPoolsSelonType('poolSurvivor', Auth::user()->UTI_SEQNC);
	
		$semas = $this::obtenSemaines($this::obtenCurrentSeason());

		if ($courn == null and isset($pools[0])) {
			$courn = $pools [0]->POO_SEQNC;
		}
	
		if ($semCour == null and isset($semas[0])) {
			$semCour = $semas [0]->SEM_NUMR;
		}
		
		$games = $this::obtenGames($semCour);

		return View::make ( '/pool/survivor/vote', array (
				'pools' => $pools,
				'games' => $games,
				'semas' => $semas,
				'semaineCourante' => $semCour,
				'poolCourant' => $courn,
	
		));
	}
	
	public function voteSurvivor (Request $request)
	{
		$courn = $request['poolCourant'];
		$team = $request['team'];
		$partie = $request['partie'];
		$messageRetour = "success";
		//$e = "SEQNC : " . Auth::user ()->UTI_SEQNC . " pool : " . $request['poolCourant'] . " week : " . $request['semaine'];
		
		$e = $this->getVoteOnWeek(Auth::user ()->UTI_SEQNC,$request['poolCourant'], DB::table("semaine_sem")->where("SEM_NUMR", $request['semaine'])->where("SEM_SAI_SEQNC", $this::obtenCurrentSeason())->get()[0]->SEM_SEQNC);
		foreach ($e as $value){
			DB::table("vote_vot")->where("VOT_SEQNC",$value->VOT_SEQNC)->delete();
		}
		$this::ajoutVote ($courn, Auth::user()->UTI_SEQNC, $this->obtenPartieEquipe($request['partie'], $this->obtenTeamDeCode($request['team'])));
		
		return "success";
	}
	
	public function getVoteOnWeek($util, $poo, $week){
		return DB::table("vote_vot")
		->join("partie_equipe_peq", "VOT_PEQ_SEQNC", "=", "PEQ_SEQNC")
		->join("partie_par", "PEQ_PAR_SEQNC", "=", "PAR_SEQNC")
		->where("PAR_SEM_SEQNC", $week)
		->where("VOT_UTI_SEQNC", $util)
		->where("VOT_POO_SEQNC",$poo)
		->select("VOT_SEQNC", "VOT_MULTP", "VOT_DATE", "VOT_PEQ_SEQNC", "VOT_POO_SEQNC", "VOT_UTI_SEQNC")->get();
	}
	
	/*****************************************************************/
	
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
	
	public function vote(Request $request) {
		switch ($this::obtenTypePool($request['poolCourant']))
		{
			case 'poolClassic':
				$messageRetour = $this::voteClassic ($request);
				break;
			case 'poolPlayoff':
				$messageRetour = $this::votePlayoff ($request);
				break;
			case 'poolSurvivor':
				return $this::voteSurvivor ($request);
				break;
		}
		
		return back()->with($messageRetour['type'], $messageRetour['contn']);
	}
	
	public function getChoicesPerWeek(Request $request){
		return json_encode($this->getVoteOnWeek(Auth::user ()->UTI_SEQNC,$request['poolCourant'], DB::table("semaine_sem")->where("SEM_NUMR", $request['semaine'])->where("SEM_SAI_SEQNC", $this::obtenCurrentSeason())->get()[0]->SEM_SEQNC));
	}
}