<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use DateTime;
use DateTimeZone;
use DB;
use Schema;

class NFLController extends BaseController
{
	public function obtenStep()
	{
		return DB::select ('select step from demo where nom =  "STAT"')[0]->step;
	}
	
	public function demo0()
	{
		if(Schema::hasTable('demo'))
		{
			DB::insert('insert into demo (nom) values (\'STAT\')');
			dd('ok0');
		}
		else 
		{
			dd('create table pls');
		}
	}
	
	public function demo1 ()
	{
		if ($this->obtenStep() == 0)
		{
			DB::update('UPDATE saison_sai SET SAI_DATE_DEBUT = DATE_SUB(SAI_DATE_DEBUT, INTERVAL 4 MONTH), SAI_DATE_FIN = DATE_SUB(SAI_DATE_FIN, INTERVAL 4 MONTH)');
			DB::update('UPDATE semaine_sem SET SEM_DATE_DEBUT = DATE_SUB(SEM_DATE_DEBUT, INTERVAL 4 MONTH), SEM_DATE_FIN = DATE_SUB(SEM_DATE_FIN, INTERVAL 4 MONTH)');
			DB::update('UPDATE partie_par SET PAR_DATE = DATE_SUB(PAR_DATE, INTERVAL 4 MONTH), PAR_COTE = (FLOOR(RAND() * (10 - 0 + 1)) + 0)');
			DB::update('UPDATE partie_equipe_peq SET PEQ_SCORE = (FLOOR(RAND() * (100 - 0 + 1)) + 0)');
			DB::update('update demo set step = 1 where nom = "STAT"');
			dd('ok1');
		}
		else
		{
			dd('1 = wrong step');
		}
	}
	
	public function demo2 ()
	{
		if ($this->obtenStep() == 1)
		{
			$seasonId = DB::table('saison_sai')->select('SAI_SEQNC')->orderBy('SAI_DATE_DEBUT', 'desc')->get()[0]->SAI_SEQNC;
			DB::table('semaine_sem')->insert(['SEM_SEQNC' => 132, 'SEM_NUMR' => 22,'SEM_DATE_DEBUT' => '2016-06-19 08:30:00','SEM_DATE_FIN' => '2016-06-25 08:30:00','SEM_SAI_SEQNC' => $seasonId]);
			
			DB::table('partie_par')->insert(['PAR_SEQNC' => 1000, 'PAR_SEM_SEQNC' => 132,'PAR_DATE' => '2016-06-19 08:30:00']);
			DB::table('partie_par')->insert(['PAR_SEQNC' => 2000, 'PAR_SEM_SEQNC' => 132,'PAR_DATE' => '2016-06-20 08:30:00']);
			DB::table('partie_par')->insert(['PAR_SEQNC' => 3000, 'PAR_SEM_SEQNC' => 132,'PAR_DATE' => '2016-06-21 08:30:00']);
			DB::table('partie_par')->insert(['PAR_SEQNC' => 4000, 'PAR_SEM_SEQNC' => 132,'PAR_DATE' => '2016-06-22 08:30:00']);
			DB::table('partie_par')->insert(['PAR_SEQNC' => 5000, 'PAR_SEM_SEQNC' => 132,'PAR_DATE' => '2016-06-23 08:30:00']);
			DB::table('partie_par')->insert(['PAR_SEQNC' => 6000, 'PAR_SEM_SEQNC' => 132,'PAR_DATE' => '2016-06-24 08:30:00']);
			
			
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 1000, 'PEQ_PAR_SEQNC' => 1000,'PEQ_EQP_SEQNC' => 1, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => 0]);
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 1001, 'PEQ_PAR_SEQNC' => 1000,'PEQ_EQP_SEQNC' => 2, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => 0]);
			
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 2000, 'PEQ_PAR_SEQNC' => 2000,'PEQ_EQP_SEQNC' => 3, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => 0]);
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 2001, 'PEQ_PAR_SEQNC' => 2000,'PEQ_EQP_SEQNC' => 4, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => 0]);
			
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 3000, 'PEQ_PAR_SEQNC' => 3000,'PEQ_EQP_SEQNC' => 5, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => 0]);
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 3001, 'PEQ_PAR_SEQNC' => 3000,'PEQ_EQP_SEQNC' => 6, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => 0]);
			
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 4000, 'PEQ_PAR_SEQNC' => 4000,'PEQ_EQP_SEQNC' => 7, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => 0]);
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 4001, 'PEQ_PAR_SEQNC' => 4000,'PEQ_EQP_SEQNC' => 8, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => 0]);
			
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 5000, 'PEQ_PAR_SEQNC' => 5000,'PEQ_EQP_SEQNC' => 9, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => 0]);
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 5001, 'PEQ_PAR_SEQNC' => 5000,'PEQ_EQP_SEQNC' => 10, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => 0]);
			
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 6000, 'PEQ_PAR_SEQNC' => 6000,'PEQ_EQP_SEQNC' => 11, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => 0]);
			DB::table('partie_equipe_peq')->insert(['PEQ_SEQNC' => 6001, 'PEQ_PAR_SEQNC' => 6000,'PEQ_EQP_SEQNC' => 12, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => 0]);
			
			DB::update('update demo set step = 2 where nom = "STAT"');
			dd('ok2');
		}
		else
		{
			dd('2 = wrong step');
		}
		
	}
	
	public function demo3 ()
	{
		if ($this->obtenStep() == 2)
		{
			$seasonId = DB::table('saison_sai')->select('SAI_SEQNC')->orderBy('SAI_DATE_DEBUT', 'desc')->get()[0]->SAI_SEQNC;
			DB::update('update semaine_sem set SEM_DATE_DEBUT = DATE_SUB(SEM_DATE_DEBUT, INTERVAL 1 WEEK), SEM_DATE_FIN = DATE_SUB(SEM_DATE_FIN, INTERVAL 1 WEEK) where SEM_SEQNC = ?',
				[132]);
			DB::update('update partie_par set PAR_DATE = DATE_SUB(PAR_DATE, INTERVAL 1 WEEK) where PAR_SEM_SEQNC = ?',
					[132]);
			DB::update('UPDATE partie_equipe_peq SET PEQ_SCORE = (FLOOR(RAND() * (100 - 0 + 1)) + 0)');
			DB::update('update demo set step = 3 where nom = "STAT"');
			dd('ok3');
		}
		else
		{
			dd('3 = wrong step');
		}
		
	}
	
	public function demoFin ()
	{
		if ($this->obtenStep() == 3)
		{
			DB::delete('delete from demo');
			dd('okFin');
		}
		else
		{
			dd('Fin = wrong step');
		}
	}
	
	public function alimenterData()
	{
		ini_set('max_execution_time', 0);
		$this->fillMatch();
		ini_set('max_execution_time', 3000);
	}
	
	public function testPOST()
	{
		$this->fillPlayOffs();
	}
	public function fillTeam(){
		$temp;
		$counter = 1;
		do {
			$temp = $this->getWeekData(date('Y'),$counter);
			foreach ($temp as $value){
				if(empty(DB::table('equipe_eqp')->select('EQP_CODE')->where('EQP_CODE', '=', $value['home'])->get())){
					$code = $value['home'];
					if ($code == 'NYJ' || $code == 'NYG'){
						$code = 'NY';
					}
					$code = DB::table('region_rgn')->select('RGN_SEQNC')->where('RGN_CODE', '=', $code)->get()[0]->RGN_SEQNC;
					DB::table('equipe_eqp')->insert(['EQP_CODE' => $value['home'], 'EQP_NOM' => 'DEFAULT', 'EQP_LUGC_ID' => '0', 'EQP_RGN_SEQNC' => $code]);
				}
				if(empty(DB::table('equipe_eqp')->select('EQP_CODE')->where('EQP_CODE', '=', $value['visitor'])->get())){
					$code = $value['visitor'];
					if ($code == 'NYJ' || $code == 'NYG'){
						$code = 'NY';
					}
					$code = DB::table('region_rgn')->select('RGN_SEQNC')->where('RGN_CODE', '=', $code)->get()[0]->RGN_SEQNC;
					DB::table('equipe_eqp')->insert(['EQP_CODE' => $value['visitor'], 'EQP_NOM' => 'DEFAULT', 'EQP_LUGC_ID' => '0', 'EQP_RGN_SEQNC' => $code]);
				}
			}
			$counter++;
			}while(!empty($temp));
	}
	public function fillPlayOffs(){
		$temp = $this->getWeekData(date('Y'),22, 'POST');
		$firstOfWeek = true;
		$dateFinSemaine;
		$weekId = 0;
		$counter = 22;
		
		foreach ($temp as $value){
			if($firstOfWeek){
				$seasonId = DB::table('saison_sai')->select('SAI_SEQNC')->where('SAI_DATE_DEBUT', '=', $value['date']->format('Y-m-d H:i:s'))->get()[0]->SAI_SEQNC;
			}
			$weekDone = false;
			if($firstOfWeek){
				//insert semaine
				$weekId = DB::table('semaine_sem')->select('SEM_SEQNC')->where('SEM_NUMR', '=', $counter)->where('SEM_SAI_SEQNC', '=', $seasonId)->get();
				if(empty($weekId)){
					DB::table('semaine_sem')->insert(['SEM_NUMR' => $counter,'SEM_DATE_DEBUT' => $value['date']->format('Y-m-d H:i:s'),'SEM_DATE_FIN' => $value['date']->format('Y-m-d H:i:s'),'SEM_SAI_SEQNC' => $seasonId]);
					$weekId = DB::getPdo()->lastInsertId();
				}else{
					$weekId = $weekId[0]->SEM_SEQNC;
					$weekDone = true;
				}
			}
			if(!$weekDone){
				//insert partie
				$eid = DB::table('partie_par')->select('PAR_LUGC_ID', 'PAR_SEQNC')->where('PAR_LUGC_ID', $value['eid'])->where('PAR_SEM_SEQNC', $weekId)->get();
				if(empty($eid)){
					DB::table('partie_par')->insert(['PAR_DATE' => $value['date']->format('Y-m-d H:i:s'),'PAR_LUGC_ID' => $value['eid'],'PAR_SEM_SEQNC' => $weekId]);
					$partieId = DB::getPdo()->lastInsertId();
					$equipeH = DB::table('equipe_eqp')->select('EQP_SEQNC')->where('EQP_CODE', '=', $value['home'])->get();
					$equipeV = DB::table('equipe_eqp')->select('EQP_SEQNC')->where('EQP_CODE', '=', $value['visitor'])->get();
					//insert liens
					$score = $this->getMatchData($value['eid']);
					DB::table('partie_equipe_peq')->insert(['PEQ_PAR_SEQNC' => $partieId,'PEQ_EQP_SEQNC' => $equipeH[0]->EQP_SEQNC, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => $score['home']]);
					DB::table('partie_equipe_peq')->insert(['PEQ_PAR_SEQNC' => $partieId,'PEQ_EQP_SEQNC' => $equipeV[0]->EQP_SEQNC, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => $score['visitor']]);
				}else{
					$score = $this->getMatchData($eid[0]->PAR_LUGC_ID);
					DB::table('partie_equipe_peq')->where('PEQ_PAR_SEQNC', $eid[0]->PAR_SEQNC)->where('PEQ_INDIC_HOME', 'O')->update(['PEQ_SCORE' => $score['home']]);
					DB::table('partie_equipe_peq')->where('PEQ_PAR_SEQNC', $eid[0]->PAR_SEQNC)->where('PEQ_INDIC_HOME', 'N')->update(['PEQ_SCORE' => $score['visitor']]);
				}
			}
			$dateFinSaison = $value['date'];
			$dateFinSemaine = $value['date'];
			$firstOfWeek = false;
		}
		//update semaine date fin
		DB::table('semaine_sem')->where('SEM_SEQNC', $weekId)->update(['SEM_DATE_FIN' => $dateFinSemaine->format('Y-m-d H:i:s')]);
		
	}
	public function fillMatch(){
		$temp;
		$counter = 1;
		$dateFinSaison;
		$seasonId = 0;
		do {
			$temp = $this->getWeekData(date('Y'),$counter);
			$firstOfWeek = true;
			$dateFinSemaine;
			$weekId = 0;
			foreach ($temp as $value){
				if($counter == 1 && $firstOfWeek){
					//insert saison
					$seasonId = DB::table('saison_sai')->select('SAI_SEQNC')->where('SAI_DATE_DEBUT', '=', $value['date']->format('Y-m-d H:i:s'))->get();
					if(empty($seasonId)){
						DB::table('saison_sai')->insert(['SAI_DATE_DEBUT' => $value['date']->format('Y-m-d H:i:s'),'SAI_DATE_FIN' => $value['date']->format('Y-m-d H:i:s')]);
						$seasonId = DB::getPdo()->lastInsertId();
					}else{
						$seasonId = $seasonId[0]->SAI_SEQNC;
					}
				}
				$weekDone = false;
				if($firstOfWeek){
					//insert semaine
					$weekId = DB::table('semaine_sem')->select('SEM_SEQNC')->where('SEM_NUMR', '=', $counter)->get();
					if(empty($weekId)){
						DB::table('semaine_sem')->insert(['SEM_NUMR' => $counter,'SEM_DATE_DEBUT' => $value['date']->format('Y-m-d H:i:s'),'SEM_DATE_FIN' => $value['date']->format('Y-m-d H:i:s'),'SEM_SAI_SEQNC' => $seasonId]);
						$weekId = DB::getPdo()->lastInsertId();
					}else{
						$weekId = $weekId[0]->SEM_SEQNC;
						$weekDone = true;
					}
				}
				if(!$weekDone){
					//insert partie
					$eid = DB::table('partie_par')->select('PAR_LUGC_ID', 'PAR_SEQNC')->where('PAR_LUGC_ID', $value['eid'])->where('PAR_SEM_SEQNC', $weekId)->get();
					if(empty($eid)){
						DB::table('partie_par')->insert(['PAR_DATE' => $value['date']->format('Y-m-d H:i:s'),'PAR_LUGC_ID' => $value['eid'],'PAR_SEM_SEQNC' => $weekId]);
						$partieId = DB::getPdo()->lastInsertId();
						$equipeH = DB::table('equipe_eqp')->select('EQP_SEQNC')->where('EQP_CODE', '=', $value['home'])->get();
						$equipeV = DB::table('equipe_eqp')->select('EQP_SEQNC')->where('EQP_CODE', '=', $value['visitor'])->get();
						//insert liens
						$score = $this->getMatchData($value['eid']);
						DB::table('partie_equipe_peq')->insert(['PEQ_PAR_SEQNC' => $partieId,'PEQ_EQP_SEQNC' => $equipeH[0]->EQP_SEQNC, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => $score['home']]);
						DB::table('partie_equipe_peq')->insert(['PEQ_PAR_SEQNC' => $partieId,'PEQ_EQP_SEQNC' => $equipeV[0]->EQP_SEQNC, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => $score['visitor']]);
					}else{
						$score = $this->getMatchData($eid[0]->PAR_LUGC_ID);
						DB::table('partie_equipe_peq')->where('PEQ_PAR_SEQNC', $eid[0]->PAR_SEQNC)->where('PEQ_INDIC_HOME', 'O')->update(['PEQ_SCORE' => $score['home']]);
						DB::table('partie_equipe_peq')->where('PEQ_PAR_SEQNC', $eid[0]->PAR_SEQNC)->where('PEQ_INDIC_HOME', 'N')->update(['PEQ_SCORE' => $score['visitor']]);
					}
				}
				$dateFinSaison = $value['date'];
				$dateFinSemaine = $value['date'];
				$firstOfWeek = false;
			}
			//update semaine date fin
			DB::table('semaine_sem')->where('SEM_SEQNC', $weekId)->update(['SEM_DATE_FIN' => $dateFinSemaine->format('Y-m-d H:i:s')]);
			$counter++;
		}while(!empty($temp));
		//update saison date fin
		$dateFinSaison = date('Y-m-d', strtotime("+4 months", strtotime($dateFinSaison->format('Y-m-d H:i:s'))));
		DB::table('saison_sai')->where('SAI_SEQNC', $seasonId)->update(['SAI_DATE_FIN' => $dateFinSaison]);
		
	}
	public function fillCote(){
		$obj = $this->getSpreadData();
		foreach ($obj as $value){
			//SELECT * FROM partie_par WHERE PAR_DATE = '2016-09-08 08:30:00' AND PAR_SEQNC IN (SELECT PEQ_PAR_SEQNC FROM partie_equipe_peq, equipe_eqp WHERE PEQ_EQP_SEQNC = EQP_SEQNC AND EQP_NOM = 'Broncos' AND PEQ_INDIC_HOME = 'O') AND PAR_SEQNC IN (SELECT PEQ_PAR_SEQNC FROM partie_equipe_peq, equipe_eqp WHERE PEQ_EQP_SEQNC = EQP_SEQNC AND EQP_NOM = 'Panthers' AND PEQ_INDIC_HOME = 'N')
			$tempNameHome = explode(" ", $value['home']);
			$tempNameVisitor = explode(" ", $value['visitor']);
			$tempNameHome = $tempNameHome[count($tempNameHome)-1];
			$tempNameVisitor = $tempNameVisitor[count($tempNameVisitor)-1];
			$subquery1 = DB::table('partie_equipe_peq')
			->join('equipe_eqp', 'PEQ_EQP_SEQNC', '=', 'EQP_SEQNC')
			->select('PEQ_PAR_SEQNC')
			->where('EQP_NOM', $tempNameHome)
			->where('PEQ_INDIC_HOME', 'O');
			
			$subquery2 = DB::table('partie_equipe_peq')
			->join('equipe_eqp', 'PEQ_EQP_SEQNC', '=', 'EQP_SEQNC')
			->select('PEQ_PAR_SEQNC')
			->where('EQP_NOM', $tempNameVisitor)
			->where('PEQ_INDIC_HOME', 'N');
			
			$value['date']->setTimezone(new DateTimeZone('America/Toronto'));
			$id = DB::table('partie_par')
			->select('PAR_SEQNC', 'PAR_LUGC_ID')
			->where('PAR_DATE', $value['date']->format('Y-m-d h:i:s'))
			->whereIn('PAR_SEQNC', $subquery1)
			->whereIn('PAR_SEQNC', $subquery2)->get();
			if(!empty($id)){
				DB::table('partie_par')->where('PAR_SEQNC', $id[0]->PAR_SEQNC)->update(['PAR_COTE' => $value['homeSpread']]);
				/*$temp = $this->getMatchData($id[0]->PAR_LUGC_ID);
				var_dump($temp);
				DB::table('partie_equipe_peq')->where('PEQ_PAR_SEQNC', $id[0]->PAR_SEQNC)->where('PEQ_INDIC_HOME', 'O')->update(['PEQ_SCORE' => $temp['home']]);
				DB::table('partie_equipe_peq')->where('PEQ_PAR_SEQNC', $id[0]->PAR_SEQNC)->where('PEQ_INDIC_HOME', 'N')->update(['PEQ_SCORE' => $temp['visitor']]);*/
			}
		}
	}
	
	public function getCurrentWeek()
	{
		$xml = file_get_contents('http://www.nfl.com/liveupdate/scorestrip/ss.xml');
		$obj = $this->xmlstr_to_array($xml);
		return $obj['gms']['@attributes']['w'];
	}
	
	public function getCurrentPostSeasonWeek()
	{
		$xml = file_get_contents('http://www.nfl.com/liveupdate/scorestrip/postseason/ss.xml');
		$obj = $this->xmlstr_to_array($xml);
		return $obj['gms']['@attributes']['w'];
	}
	
	public function getWeekData($year, $week, $seasonType = "REG")
	{
		if ($seasonType == "POST"){
			$xml = file_get_contents('http://www.nfl.com/liveupdate/scorestrip/postseason/ss.xml');
		}else{
			$xml = file_get_contents('http://www.nfl.com/ajax/scorestrip?=' . $year . '&seasonType=' . $seasonType . '&week=' . $week);
		}
		$obj = $this->xmlstr_to_array($xml);
		$info = array();
		if(!empty($obj)){
			foreach ($obj['gms']['g'] as $value){
				$temp['eid'] = $value['@attributes']['eid'];
				$s = substr($temp['eid'], 0, 4) . '-' . substr($temp['eid'], 4, 2) . '-' . substr($temp['eid'], 6, 2) . ' ' . $value['@attributes']['t'] . ':00';
				$temp['date'] = new DateTime($s, new DateTimeZone('America/Toronto'));
				$temp['home'] = $value['@attributes']['h'];
				$temp['visitor'] = $value['@attributes']['v'];
				$info[] = $temp;
			}
		}
		return $info;
	}
	public function getMatchData($eid)
	{
		try {
			$json = file_get_contents('http://www.nfl.com/liveupdate/game-center/' . $eid . '/' . $eid . '_gtd.json');
			$obj = json_decode($json, true);
			return array('home' => $obj[$eid]['home']['score']['T'], 'visitor' => $obj[$eid]['away']['score']['T']);
		}catch(\Exception $e) {
			return array('home' => 0, 'visitor' => 0);
		}
	}
	public function getSpreadData(){
		$xml = file_get_contents('http://xml.pinnaclesports.com/pinnaclefeed.aspx?sporttype=Football&sportsubtype=nfl');
		$obj = $this->xmlstr_to_array($xml);
		$info = array();
		foreach ($obj['events']['event'] as $value){
			$temp['date'] = new DateTime($value['event_datetimeGMT'], new DateTimeZone('GMT'));
			foreach ($value['participants']['participant'] as $participant){
				if($participant['visiting_home_draw'] == 'Home'){
					$temp['home'] = $participant['participant_name'];
				}else{
					$temp['visitor'] = $participant['participant_name'];
				}
			}
			if(empty($value['periods']) || is_array($value['periods']['period']['spread']['spread_home'])){
				$value['periods']['period']['spread']['spread_home'] = '0';
			}
			if(!isset($value['periods']['period']['spread']['spread_visiting']) || is_array($value['periods']['period']['spread']['spread_visiting'])){
				$value['periods']['period']['spread']['spread_visiting'] = '0';
			}
			$temp['homeSpread'] = $value['periods']['period']['spread']['spread_home'];
			$temp['visitorSpread'] = $value['periods']['period']['spread']['spread_visiting'];
			$info[] = $temp;
		}
		return $info;
	}
	public function xmlstr_to_array($xmlstr) {
		$doc = new \DOMDocument();
		$doc->loadXML($xmlstr);
		return $this->domnode_to_array($doc->documentElement);
	}
	public function domnode_to_array($node) {
		$output = array();
		switch ($node->nodeType) {
			case XML_CDATA_SECTION_NODE:
			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;
			case XML_ELEMENT_NODE:
				for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
					$child = $node->childNodes->item($i);
					$v = $this->domnode_to_array($child);
					if(isset($child->tagName)) {
						$t = $child->tagName;
						if(!isset($output[$t])) {
							$output[$t] = array();
						}
						$output[$t][] = $v;
					}
					elseif($v) {
						$output = (string) $v;
					}
				}
				if(is_array($output)) {
					if($node->attributes->length) {
						$a = array();
						foreach($node->attributes as $attrName => $attrNode) {
							$a[$attrName] = (string) $attrNode->value;
						}
						$output['@attributes'] = $a;
					}
					foreach ($output as $t => $v) {
						if(is_array($v) && count($v)==1 && $t!='@attributes') {
							$output[$t] = $v[0];
						}
					}
				}
				break;
		}
		return $output;
	}
}
