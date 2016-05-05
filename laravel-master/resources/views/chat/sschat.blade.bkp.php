<!DOCTYPE html>
<html>
	<head>
		<title>Chat</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('js/sschat.js') }}"></script>
		<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/sschat.css') }}"></link>
		<script type="text/javascript">
var sschat_serverurl = 'sschat';
var sschat_channel = 'general';
		</script>
	</head>
	<body>
		<div id="sschat">
			<div id="sschat_lines">
				<ul></ul>
			</div>
			<div id="sschat_entry">
				<p id="sschat_hint">Type your nickname and press enter:</p>
				<input type="text" id="sschat_input">
			</div>
		</div>
	
	</body>
</html>