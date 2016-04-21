<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use DateTime;
use DateTimeZone;

class NFLController extends BaseController
{
	public function test()
	{
		$this->getSpreadData();
	}
	public function fillTeam(){
		
	}
	public function fillMatch(){
	
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
		foreach ($obj['gms']['g'] as $value){
			$temp['eid'] = $value['@attributes']['eid'];
			$s = substr($temp['eid'], 0, 4) . '-' . substr($temp['eid'], 4, 2) . '-' . substr($temp['eid'], 6, 2) . ' ' . $value['@attributes']['t'] . ':00';
			$temp['date'] = new DateTime($s, new DateTimeZone('America/Toronto'));
			$temp['home'] = $value['@attributes']['h'];
			$temp['visitor'] = $value['@attributes']['v'];
			$info[] = $temp;
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
