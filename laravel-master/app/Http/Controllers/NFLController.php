<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use DateTime;
use DateTimeZone;
use DB;

class NFLController extends BaseController
{
	public function test()
	{
		$this->fillMatch();
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
					$weekId = DB::table('semaine_sem')->select('SEM_SEQNC')->where('SEM_DATE_DEBUT', '=', $value['date']->format('Y-m-d H:i:s'))->get();
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
					DB::table('partie_par')->insert(['PAR_DATE' => $value['date']->format('Y-m-d H:i:s'),'PAR_LUGC_ID' => $value['eid'],'PAR_SEM_SEQNC' => $weekId]);
					$partieId = DB::getPdo()->lastInsertId();
					$equipeH = DB::table('equipe_eqp')->select('EQP_SEQNC')->where('EQP_CODE', '=', $value['home'])->get()[0]->EQP_SEQNC;
					$equipeV = DB::table('equipe_eqp')->select('EQP_SEQNC')->where('EQP_CODE', '=', $value['visitor'])->get()[0]->EQP_SEQNC;
					//insert liens
					DB::table('partie_equipe_peq')->insert(['PEQ_PAR_SEQNC' => $partieId,'PEQ_EQP_SEQNC' => $equipeH, 'PEQ_INDIC_HOME' => 'O', 'PEQ_SCORE' => 0]);
					DB::table('partie_equipe_peq')->insert(['PEQ_PAR_SEQNC' => $partieId,'PEQ_EQP_SEQNC' => $equipeV, 'PEQ_INDIC_HOME' => 'N', 'PEQ_SCORE' => 0]);
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
		DB::table('saison_sai')->where('SAI_SEQNC', $seasonId)->update(['SAI_DATE_FIN' => $dateFinSaison->format('Y-m-d H:i:s')]);
		
	}
	public function fillCote(){
	
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
		$xml = file_get_contents('http://www.nfl.com/ajax/scorestrip?=' . $year . '&seasonType=' . $seasonType . '&week=' . $week);
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
		$json = file_get_contents('http://www.nfl.com/liveupdate/game-center/' . $eid . '/' . $eid . '_gtd.json');
		$obj = json_decode($json, true);
		return array('home' => $obj[$eid]['home']['score']['T'], 'visitor' => $obj[$eid]['away']['score']['T']);
	}
	public function getSpreadData(){
		$xml = file_get_contents('http://xml.pinnaclesports.com/pinnaclefeed.aspx?sporttype=Football&sportsubtype=nfl');
		$obj = $this->xmlstr_to_array($xml);
		$info = array();
		foreach ($obj['events']['event'] as $value){
			$temp['date'] = new DateTime($value['event_datetimeGMT'], new DateTimeZone('America/Toronto'));
			foreach ($value['participants']['participant'] as $participant){
				if($participant['visiting_home_draw'] == 'Home'){
					$temp['home'] = $participant['participant_name'];
				}else{
					$temp['visitor'] = $participant['participant_name'];
				}
			}
			if(is_array($value['periods']['period']['spread']['spread_home'])){
				$value['periods']['period']['spread']['spread_home'] = '0';
			}
			if(is_array($value['periods']['period']['spread']['spread_visiting'])){
				$value['periods']['period']['spread']['spread_visiting'] = '0';
			}
			$temp['homeSpread'] = $value['periods']['period']['spread']['spread_home'];
			$temp['visitorSpread'] = $value['periods']['period']['spread']['spread_visiting'];
			$info[] = $temp;
		}
		var_dump($info);
		return $xml;
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
