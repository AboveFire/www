<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Log;
use Cache;
use Auth;
use DB;
use JWTAuth;

class ChatController extends Controller
{
	public function run(){
		if(session_status() == PHP_SESSION_ACTIVE){
			session_write_close();
		}
		if(isset($_POST['token']) && $_POST['token'] != ''){
			$user = JWTAuth::toUser($_POST['token']);
		}else{
			$user = Auth::user();
		}
		$smileys = Array(
		':)'=>'smile',
		':-)'=>'smile',
		'(:'=>'smile',
		'(-:'=>'smile',
		'>:('=>'grumpy',
		'>:-('=>'grumpy',
		'):<'=>'grumpy',
		')-:<'=>'grumpy',
		':('=>'frown',
		':-('=>'frown',
		'):'=>'frown',
		')-:'=>'frown',
		'>:o'=>'upset',
		'>:O'=>'upset',
		'>:-o'=>'upset',
		'>:-O'=>'upset',
		'o:<'=>'upset',
		'O:<'=>'upset',
		'o-:<'=>'upset',
		'O-:<'=>'upset',
		':o'=>'gasp',
		':O'=>'gasp',
		':-o'=>'gasp',
		':-O'=>'gasp',
		'o:'=>'gasp',
		'O:'=>'gasp',
		'o-:'=>'gasp',
		'O-:'=>'gasp',
		':D'=>'grin',
		':-D'=>'grin',
		'=D'=>'grin',
		':P'=>'tongue',
		':p'=>'tongue',
		':-P'=>'tongue',
		':-p'=>'tongue',
		';)'=>'wink',
		';-)'=>'wink',
		'(;'=>'wink',
		'(-;'=>'wink',
		':3'=>'curlylips',
		':-3'=>'curlylips',
		':*'=>'kiss',
		':-*'=>'kiss',
		'*:'=>'kiss',
		'*-:'=>'kiss',
		'8)'=>'glasses',
		'8-)'=>'glasses',
		'(8'=>'glasses',
		'(-8'=>'glasses',
		'B)'=>'sunglasses',
		'B-)'=>'sunglasses',
		'O.o'=>'confused',
		'o.O'=>'confused',
		'O_o'=>'confused',
		'o_O'=>'confused',
		'-_-'=>'squint',
		//':/'=>'unsure',
		':-/'=>'unsure',
		':\\'=>'unsure',
		':-\\'=>'unsure',
		'/:'=>'unsure',
		'/-:'=>'unsure',
		'\\:'=>'unsure',
		'\\-:'=>'unsure',
		'^_^'=>'kiki',
		'^_^'=>'kiki',
		'E>'=>'heart',
		':heart'=>'heart'
		);
		/* If magic quotes is enabled, remove slashes from POSTed data */
		if (get_magic_quotes_gpc()):
			foreach ($_POST as $key=>$val):
				$_POST[$key] = stripslashes($val);
			endforeach;
		endif;
		/* Make channel names safe, as they are used as filenames later */
		if (isset($_POST['channel'])):
			$_POST['channel'] = preg_replace("/[^a-z0-9]/i", '', $_POST['channel']);
		endif;
		if ($_POST['action'] == 'join'):
			$temp = Cache::get("connected-once");
			if(is_array($temp)){
				if(!in_array($user->UTI_CODE, $temp)){
					array_push($temp, $user->UTI_CODE);
					Cache::forever("connected-once",$temp);
				}
			}else{
				Cache::forever("connected-once",array($user->UTI_CODE));
			}
			/* User has joined a channel */
			//$expiresAt = Carbon::now()->addMinutes(5);
			//Cache::put('user-is-online' . USERNAME, true, $expiresAt);
			/*$lines = file(storage_path() . '/channel/'.'general'.'.txt');
			$tempArray = array();
			for ($i = 10; $i >= 1; $i--) {
				if($i < sizeof($lines)){
					$tempArray[] = '<li>'.$lines[sizeof($lines)-$i].'</li>';
				}
			}
			echo json_encode($tempArray);*/
			
			$_POST['nickname'] = substr(strip_tags($_POST['nickname']), 0, 16);
			//self::writeLine($_POST['channel'], '<span class="notice">'.$_POST['nickname'].' has entered the chatroom</span>', $user);
		elseif ($_POST['action'] == 'send'):
			/* User is saying something */
			$pattern = '/^\<span class="nick"\>.*\<\/span\>/';
			preg_match($pattern, $_POST['text'], $matches);
			$nick = $matches[0];
			$message = strip_tags(str_replace($matches[0], "", $_POST['text']));
			//$_POST['text'] = strip_tags($_POST['text']);
			foreach ($smileys as $smiley=>$image):
				//$_POST['text'] = str_replace($smiley, '<img src="emoticons/'.$image.'.png" class="sschat_emoticon">', $_POST['text']);
				$message = str_replace($smiley, '<img src="emoticons/'.$image.'.png" class="sschat_emoticon">', $message);
			endforeach;
			//self::writeLine($_POST['channel'], $_POST['text']);
			
			self::writeLine($_POST['channel'], $nick . $message, $user);
		elseif ($_POST['action'] == 'listen'):
			/* User is waiting for next line of chat */
			if ($stat = @stat(storage_path() . '/channel/'.$_POST['channel'].'.txt')):
				$lastsize = intval($stat['size']);
			else:
				/* Channel doesn't exist, so create it */
				self::writeLine($_POST['channel'], '<span class="notice">Channel created</span>', $user);
				$lastsize = 0;
			endif;
			set_time_limit(0);
			while (1):
				Cache::put('user-is-online-' . $user->UTI_CODE, true, 1);
				usleep(100000);
				clearstatcache();
				$stat = stat(storage_path() . '/channel/'.$_POST['channel'].'.txt');
				if (intval($stat['size']) > $lastsize):
					$lines = file(storage_path() . '/channel/'.$_POST['channel'].'.txt');
					echo '<li>'.$lines[sizeof($lines)-1].'</li>';
					Log::info($lastsize);
					if($lastsize > 10000){
						unlink(storage_path() . '/channel/'.$_POST['channel'].'.txt');
						touch(storage_path() . '/channel/'.$_POST['channel'].'.txt');
					}
					die();
				endif;
			endwhile;
		elseif ($_POST['action'] == 'part'):
			/* User is leaving */
			//self::writeLine($_POST['channel'], '<span class="notice">'.$_POST['nickname'].' has left the chatroom</span>', $user);
		elseif ($_POST['action'] == 'checkconnected'):
			$temp = Cache::get("connected-once");
			//Log::info(print_r($temp,true));
			$return = array();
			if(is_array($temp)){
				foreach ($temp as $value){
					if(Cache::get('user-is-online-' . $value)){
						$return[] = $value;
					}
				}
			}
			echo json_encode($return);
		elseif ($_POST['action'] == 'addten'):
			if(isset($_POST['getNumber'])){
				$getNumber = $_POST['getNumber'];
			}else{
				$getNumber = 0;
			}
			$BiggestValue = DB::table('message_msg')->select('MSG_SEQNC')->orderBy('MSG_SEQNC', 'desc')->first()->MSG_SEQNC;
			$lines = DB::table("message_msg")->select('MSG_CONTN')->where('MSG_SEQNC', '<=', $BiggestValue - ($_POST['number']-1))->where('MSG_SEQNC', '>=', $BiggestValue - (9 + $_POST['number'] + $getNumber))->orderBy('MSG_SEQNC', 'asc')->get();//file(storage_path() . '/channel/'.'general'.'.txt');
			$tempArray = array();
			for ($i = 0; $i < sizeof($lines); $i++) {
				$tempArray[] = '<li>'.$lines[$i]->MSG_CONTN.'</li>';
			}
			echo json_encode($tempArray);
		endif;
	}
	/* Add line to channel history for other users to see */
	public static function writeLine($room, $text, $user)
	{
		$fp = fopen(storage_path() . '/channel/'.$room.'.txt', 'a');
		DB::table('message_msg')->insert(['MSG_CONTN' => $text, 'MSG_DATE' => date('Y-m-d h:i:s a', time()), 'MSG_UTI_SEQNC' => $user->UTI_SEQNC]);
		fwrite($fp, $text."\n");
		fclose($fp);
	}
}
