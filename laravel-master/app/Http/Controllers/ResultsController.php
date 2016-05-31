<?php
namespace App\Http\Controllers;
use Log;
use DB;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
	public function ajax(){
		$temp = $this->getPointsMatchPerWeek($_POST['number']);
		if(!empty($temp)){
			foreach($temp as $value){
				$value->image_home = asset('images/teams/' . $value->code_home . '.png');
				$value->image_visitor = asset('images/teams/' . $value->code_visitor . '.png');
				if($value->cote == null){
					$value->cote = "-";
				}
			}
			/*usort($temp, function($a, $b){
			return strtotime($b->date) - strtotime($a->date);
			});*/
			return json_encode($temp);
		}
	}
	public function getMatchMobile(Request $request){
		$temp = $this->getPointsMatchPerWeek($request['number']);
		foreach($temp as $value){
			if($value->cote == null){
				$value->cote = "-";
			}
		}
		return json_encode($temp);
	}
	public function test()
	{
		var_dump($this->getPointsMatch(0,5));
	}
	public function getPoolListByType($type){
		var_dump(DB::table("pool_poo")->select("POO_SEQNC", "POO_NOM")->where("POO_TYP_SEQNC",$type)->get());
	}
	
	public function getResultsByPoolId(){
		
	}
	
	public function getPointsPoolClassique ($user)
	{
		//DB::table
	}
	
	public function getPointsMatchPerWeek ($week)
	{
		$pWeek = DB::table("semaine_sem")->select("sem_seqnc")->where("sem_date_debut", "<", date('Y-m-d H:i:s'))->orderBy("sem_date_debut", "DESC")->limit(1)->offset($week)->get();
		if(!empty($pWeek)){
			$pWeek = $pWeek[0]->sem_seqnc;
		
			$temp = DB::table("partie_par")
			->join("partie_equipe_peq AS O", function($join){
				$join->on("partie_par.par_seqnc", "=", "O.peq_par_seqnc")
				->where("O.peq_indic_home", "=", "O");
			})
			->join("partie_equipe_peq AS N", function($join){
				$join->on("partie_par.par_seqnc", "=", "N.peq_par_seqnc")
				->where("N.peq_indic_home", "=", "N");
			})
			->join("equipe_eqp AS OE", "O.peq_eqp_seqnc", "=", "OE.eqp_seqnc")
			->join("equipe_eqp AS NE", "N.peq_eqp_seqnc", "=", "NE.eqp_seqnc")
			->select("partie_par.par_seqnc", "partie_par.par_date AS date", "partie_par.par_cote AS cote", "O.peq_score AS point_home", "OE.eqp_code AS code_home", "N.peq_score AS point_visitor", "NE.eqp_code AS code_visitor")
			->orderBy("partie_par.par_date")
			->where("partie_par.par_sem_seqnc", "=", $pWeek)
			->where("partie_par.par_date", "<", date('Y-m-d H:i:s'))
			->get();
			return $temp;
		}else{
			return [];
		}
	}
	
	public function getPointsMatch ($start, $number)
	{
		$temp = DB::table("partie_par")
		->join("partie_equipe_peq AS O", function($join){
			$join->on("partie_par.par_seqnc", "=", "O.peq_par_seqnc")
			->where("O.peq_indic_home", "=", "O");
		})
		->join("partie_equipe_peq AS N", function($join){
			$join->on("partie_par.par_seqnc", "=", "N.peq_par_seqnc")
			->where("N.peq_indic_home", "=", "N");
		})
		->join("equipe_eqp AS OE", "O.peq_eqp_seqnc", "=", "OE.eqp_seqnc")
		->join("equipe_eqp AS NE", "N.peq_eqp_seqnc", "=", "NE.eqp_seqnc")
		->select("partie_par.par_seqnc", "partie_par.par_date AS date", "partie_par.par_cote AS cote", "O.peq_score AS point_home", "OE.eqp_code AS code_home", "N.peq_score AS point_visitor", "NE.eqp_code AS code_visitor")
		->orderBy("partie_par.par_date")->limit($number)->offset($start)->get();
		return $temp;
	}
}