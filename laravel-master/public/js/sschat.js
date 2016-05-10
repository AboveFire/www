//quand tu t'appelle " " sa crash
//tu peux avoir des emotes dans ton nom
var nickname = '';
$number = 1;
$(document).ready(function(){
	listener();
	nickname = $("#code").val().replace(/[^-a-z0-9]/ig,'');;
	$.post(sschat_serverurl, {action: 'join', nickname: nickname, channel: sschat_channel}, function(data){
		//LIST CONNECTED : DATA IS JSON OF USERS CONNECTED
		$('#sschat_input').val('');
		$('#sschat_input').removeAttr("disabled" );
		$('#sschat_hint').html('Type a line of chat and press enter to speak:');
		$('#sschat_input').focus();
		addten();
		//TEMP
		/*$obj = JSON.parse(data);
		for($key in $obj){
			if($obj[$key].indexOf('<span class="nick">'+nickname+':</span>') > -1){
				$obj[$key] = $obj[$key].replace('<li><span class="nick">', '<li class="mymessage"><span class="bubble me"><span class="nick">');
				$obj[$key] = $obj[$key].replace('</li>', '</span></li>');
			}else{
				$obj[$key] = $obj[$key].replace('<li><span class="nick">', '<li class="yourmessage"><span class="bubble you"><span class="nick">');
				$obj[$key] = $obj[$key].replace('</li>', '</span></li>');
			}
			$('#sschat_lines ul').append(linkify($obj[$key]));
			$('#sschat_lines').scrollTop($('#sschat_lines')[0].scrollHeight);
		}*/
	});
	$("#sschat_lines ul").ajaxError(function() {
  	$(this).html('<li>Sorry there was an error! Please reload the page and re-enter the chatroom.');
	});
 
	$('#sschat_input').focus();
	$('#sschat_input').keyup(function(e) {
		if (e.keyCode == 13) {
			if (nickname == '') {
				if ($('#sschat_input').val() != '') {
					listener();
					nickname = $('#sschat_input').val();
					nickname = nickname.replace(/[^-a-z0-9]/ig,'');
					$('#sschat_input').attr('disabled', 'disabled');
					$.post(sschat_serverurl, {action: 'join', nickname: nickname, channel: sschat_channel}, function(data){
						$('#sschat_input').val('');
						$('#sschat_input').removeAttr("disabled" );
						$('#sschat_hint').html('Type a line of chat and press enter to speak:');
						$('#sschat_input').focus();
					});
					/*$.ajax({
					  type: 'POST',
					  url: sschat_serverurl,
					  data: {action: 'join', nickname: nickname, channel: sschat_channel},
					  beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
					  success: function(){
						$('#sschat_input').val('');
						$('#sschat_input').attr('disabled', '');
						$('#sschat_hint').html('Type a line of chat and press enter to speak:');
						}
					});*/
				}
			} else {
				var sendline = $('#sschat_input').val();
				if (sendline != '') {
					$('#sschat_input').attr('disabled', 'disabled');
					$('#sschat_input').val('sending...');
					serverSend('<span class="nick">'+nickname+':</span> '+sendline);
				}
			}
		}
	});
	
	$(window).bind("beforeunload", function(){
		if (nickname != '') {
			$.post(sschat_serverurl, {action: 'part', nickname: nickname, channel: sschat_channel});
		}
	});
	window.setInterval(function(){ connected(); },30000);
	connected();
});

function addten(){
	$.post(sschat_serverurl, {action: 'addten', nickname: nickname, channel: sschat_channel, number: $number}, function(data){
		//TEMP
		$obj = JSON.parse(data);
		for($key in $obj){
			if($obj[$key].indexOf('<span class="nick">'+nickname+':</span>') > -1){
				$obj[$key] = $obj[$key].replace('<li><span class="nick">', '<li class="mymessage"><span class="bubble me"><span class="nick">');
				$obj[$key] = $obj[$key].replace('</li>', '</span></li>');
			}else{
				$obj[$key] = $obj[$key].replace('<li><span class="nick">', '<li class="yourmessage"><span class="bubble you"><span class="nick">');
				$obj[$key] = $obj[$key].replace('</li>', '</span></li>');
			}
			$('#sschat_lines ul').prepend(linkify($obj[$key]));
			//$('#sschat_lines').scrollTop($('#sschat_lines')[0].scrollHeight);
		}
	});
	$number++;
}

function serverSend(sendtext) {
	$.post(sschat_serverurl, {action: 'send', text: sendtext.replace(/(\r\n|\n|\r)/gm," "), channel: sschat_channel}, function(data){
		$('#sschat_input').val('');
		$('#sschat_input').removeAttr("disabled" );
		$('#sschat_input').focus();
	});
}

function listener() {
	$.post(sschat_serverurl, {action: 'listen', channel: sschat_channel}, function(data){
		if(data.indexOf('<span class="nick">'+nickname+':</span>') > -1){
			data = data.replace('<li><span class="nick">', '<li class="mymessage"><span class="bubble me"><span class="nick">');
			data = data.replace('</li>', '</span></li>');
		}else{
			data = data.replace('<li><span class="nick">', '<li class="yourmessage"><span class="bubble you"><span class="nick">');
			data = data.replace('</li>', '</span></li>');
		}
		$('#sschat_lines ul').append(linkify(data));
		$('#sschat_lines').scrollTop($('#sschat_lines')[0].scrollHeight);
		listener();
	});
}

function connected(){
	$.post(sschat_serverurl, {action: 'checkconnected', channel: sschat_channel}, function(data){
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

