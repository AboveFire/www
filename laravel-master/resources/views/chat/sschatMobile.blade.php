<script type="text/javascript" src="{{ URL::asset('js/sschat.js') }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/sschatMobile.css') }}"></link>
<input id="code" type="hidden" value="{{ Auth::user()->UTI_CODE }}">
<script type="text/javascript">
	var sschat_serverurl = 'sschat';
	var sschat_channel = 'general';
	var tokenMobile = "{{ csrf_token() }}";
</script>
<div class="container">
	<div id="sschat">
		<div id="sschat_lines">
			<ul></ul>
		</div
		><div id="sschat_connected">
		</div
		><div id="sschat_entry">
			<p id="sschat_hint"></p>
			<!-- <input type="text" id="sschat_input"> -->
			<textarea id="sschat_input" placeholder="{{ trans('chat.typeText') }}" rows=2></textarea>
			<i id="paperplane" class="fa fa-paper-plane-o"></i>
		</div>
	</div>
</div>