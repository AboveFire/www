//quand tu t'appelle " " sa crash
//tu peux avoir des emotes dans ton nom
var nickname = '';
$number = 1;
var $_GET = {};
$(document).ready(function(){
	document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
	    function decode(s) {
	        return decodeURIComponent(s.split("+").join(" "));
	    }

	    $_GET[decode(arguments[1])] = decode(arguments[2]);
	});
	listener();
	nickname = $("#code").val().replace(/[^-a-z0-9]/ig,'');
	$.post(sschat_serverurl, {action: 'join', nickname: nickname, channel: sschat_channel, _token:tokenMobile, token: $_GET['token']}, function(data){
		//LIST CONNECTED : DATA IS JSON OF USERS CONNECTED
		$('#sschat_input').val('');
		$('#sschat_input').removeAttr("disabled" );
		$('#sschat_hint').html('Type a line of chat and press enter to speak:');
		$('#sschat_input').focus();
		$.post(sschat_serverurl, {action: 'addten', nickname: nickname, channel: sschat_channel, number: $number, getNumber:20, _token:tokenMobile, token: $_GET['token']}, function(data){
			//TEMP
			$obj = JSON.parse(data);
			$oldHeight = $('#sschat_lines')[0].scrollHeight;
			for ($key = $obj.length-1; $key >= 0; $key--) {
				if($obj[$key].indexOf('<span class="nick">'+nickname+':</span>') > -1){
					$obj[$key] = $obj[$key].replace('<li><span class="nick">', '<li class="mymessage"><span class="bubble me"><span class="nick">');
					$obj[$key] = $obj[$key].replace('</li>', '</span></li>');
				}else{
					$obj[$key] = $obj[$key].replace('<li><span class="nick">', '<li class="yourmessage"><span class="bubble you"><span class="nick">');
					$obj[$key] = $obj[$key].replace('</li>', '</span></li>');
				}
				$('#sschat_lines ul').prepend(linkify($obj[$key]));
			}
			adjustScroll($oldHeight);
		});
		$number+=30;
	});
	$("#sschat_lines ul").ajaxError(function() {
  	$(this).html('<li>Désolé, une erreur est survenue. Veuillez rafraîchir votre page.\nSorry there was an error! Please reload the page.');
	});
 
	$('#sschat_input').focus();
	$('#sschat_input').keyup(function(e) {
		if (e.keyCode == 13) {
			if (nickname == '') {
				if ($('#sschat_input').val() != '') {
					//listener();
					nickname = $('#sschat_input').val();
					nickname = nickname.replace(/[^-a-z0-9]/ig,'');
					$('#sschat_input').attr('disabled', 'disabled');
					$.post(sschat_serverurl, {action: 'join', nickname: nickname, channel: sschat_channel, _token:tokenMobile, token: $_GET['token']}, function(data){
						$('#sschat_input').val('');
						$('#sschat_input').removeAttr("disabled" );
						$('#sschat_hint').html('Type a line of chat and press enter to speak:');
						$('#sschat_input').focus();
					});
				}
			} else {
				var sendline = $('#sschat_input').val();
				if (sendline != '' && sendline != '\n') {
					$('#sschat_input').attr('disabled', 'disabled');
					$('#sschat_input').val('sending...');
					serverSend('<span class="nick">'+nickname+':</span> '+sendline);
				}
			}
		}
	});
	
	$(window).bind("beforeunload", function(){
		if (nickname != '') {
			$.post(sschat_serverurl, {action: 'part', nickname: nickname, channel: sschat_channel, _token:tokenMobile, token: $_GET['token']});
		}
	});
	window.setInterval(function(){ connected(); },30000);
	connected();
	$( "#sschat_lines" ).scroll(function() {
		if($( "#sschat_lines" ).scrollTop() == 0)
        {
			addten();
        }
	});
});

function adjustScroll($offset){
	$( "#sschat_lines" ).scrollTop($('#sschat_lines')[0].scrollHeight - $offset);
}

function addten($adjust = true){
	$.post(sschat_serverurl, {action: 'addten', nickname: nickname, channel: sschat_channel, number: $number, _token:tokenMobile, token: $_GET['token']}, function(data){
		//TEMP
		$obj = JSON.parse(data);
		$oldHeight = $('#sschat_lines')[0].scrollHeight;
		for ($key = $obj.length-1; $key >= 0; $key--) {
			if($obj[$key].indexOf('<span class="nick">'+nickname+':</span>') > -1){
				$obj[$key] = $obj[$key].replace('<li><span class="nick">', '<li class="mymessage"><span class="bubble me"><span class="nick">');
				$obj[$key] = $obj[$key].replace('</li>', '</span></li>');
			}else{
				$obj[$key] = $obj[$key].replace('<li><span class="nick">', '<li class="yourmessage"><span class="bubble you"><span class="nick">');
				$obj[$key] = $obj[$key].replace('</li>', '</span></li>');
			}
			$('#sschat_lines ul').prepend(linkify($obj[$key]));
		}
		if($adjust){
			adjustScroll($oldHeight);
		}
		
	});
	$number+=10;
}

function serverSend(sendtext) {
	$.post(sschat_serverurl, {action: 'send', text: sendtext.replace(/(\r\n|\n|\r)/gm," "), channel: sschat_channel, _token:tokenMobile, token: $_GET['token']}, function(data){
		$('#sschat_input').val('');
		$('#sschat_input').removeAttr("disabled" );
		$('#sschat_input').focus();
	});
}

function listener() {
	$.post(sschat_serverurl, {action: 'listen', channel: sschat_channel, _token:tokenMobile, token: $_GET['token']}, function(data){
		if(data.indexOf('<span class="nick">'+nickname+':</span>') > -1){
			data = data.replace('<li><span class="nick">', '<li class="mymessage"><span class="bubble me"><span class="nick">');
			data = data.replace('</li>', '</span></li>');
		}else{
			data = data.replace('<li><span class="nick">', '<li class="yourmessage"><span class="bubble you"><span class="nick">');
			data = data.replace('</li>', '</span></li>');
		}
		$('#sschat_lines ul').append(linkify(data));
		$number++;
		$('#sschat_lines').scrollTop($('#sschat_lines')[0].scrollHeight);
		listener();
	});
}

function connected(){
	$.post(sschat_serverurl, {action: 'checkconnected', channel: sschat_channel, _token: tokenMobile, token: $_GET['token']}, function(data){
		$obj = JSON.parse(data);
		$('#sschat_connected').html("");
		for($key in $obj){
			$('#sschat_connected').html($('#sschat_connected').html() + '<li>' + $obj[$key] + '</li>');
		}
	});
}

function linkify(text){
    if (text) {
        text = text.replace(
            /((https?\:\/\/)|(www\.))(\S+)(\w{2,4})(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/gi,
            function(url){
                var full_url = url;
                if (!full_url.match('^https?:\/\/')) {
                    full_url = 'http://' + full_url;
                }
                return '<a href="' + full_url + '" target="_blank">' + url + '</a>';
            }
        );
    }
    return text;
}

