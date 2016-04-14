<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;

class ChatController extends BaseController
{
	public function run(){
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
		':/'=>'unsure',
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
			/* User has joined a channel */
			$_POST['nickname'] = substr(strip_tags($_POST['nickname']), 0, 16);
			self::writeLine($_POST['channel'], '<span class="notice">'.$_POST['nickname'].' has entered the chatroom</span>');
		elseif ($_POST['action'] == 'send'):
			/* User is saying something */
			$_POST['text'] = strip_tags($_POST['text']);
			foreach ($smileys as $smiley=>$image):
				$_POST['text'] = str_replace($smiley, '<img src="emoticons/'.$image.'.png" class="sschat_emoticon">', $_POST['text']);
			endforeach;
			self::writeLine($_POST['channel'], $_POST['text']);
		elseif ($_POST['action'] == 'listen'):
			/* User is waiting for next line of chat */
			if ($stat = @stat(storage_path() . '/channel/'.$_POST['channel'].'.txt')):
				$lastsize = intval($stat['size']);
			else:
				/* Channel doesn't exist, so create it */
				self::writeLine($_POST['channel'], '<span class="notice">Channel created</span>');
				$lastsize = 0;
			endif;
			set_time_limit(0);
			while (1):
				usleep(100000);
				clearstatcache();
				$stat = stat(storage_path() . '/channel/'.$_POST['channel'].'.txt');
				if (intval($stat['size']) > $lastsize):
					$lines = file(storage_path() . '/channel/'.$_POST['channel'].'.txt');
					echo '<li>'.$lines[sizeof($lines)-1].'</li>';
					die();
				endif;
				//$counter++;
			endwhile;
		elseif ($_POST['action'] == 'part'):
			/* User is leaving */
			self::writeLine($_POST['channel'], '<span class="notice">'.$_POST['nickname'].' has left the chatroom</span>');
		endif;
	}
	/* Add line to channel history for other users to see */
	public static function writeLine($room, $text)
	{
		$fp = fopen(storage_path() . '/channel/'.$room.'.txt', 'a');
		fwrite($fp, $text."\n");
		fclose($fp);
	}
}
