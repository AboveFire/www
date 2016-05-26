<?php
namespace App\Http\Controllers;
use Log;
use DB;

class ChatController extends Controller
{
	public function getPoolListByType($type){
		var_dump(DB::table("pool_poo")->select("POO_SEQNC", "POO_NOM")->where("POO_TYP_SEQNC",$type)->get());
	}
	
	public function getResultsByPoolId(){
		
	}
}