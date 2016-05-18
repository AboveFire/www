@extends('layouts.app')
@section('title', 'Clavardage')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/sschat.js') }}"></script>
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/sschat.css') }}"></link>
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
		><ul id="sschat_connected" class="sidebar-nav">
		</ul
		><div id="sschat_entry">
			<p id="sschat_hint">Type your nickname and press enter:</p>
			<!-- <input type="text" id="sschat_input"> -->
			<textarea id="sschat_input" placeholder="Saisissez votre texte" rows=2></textarea>
			<i id="paperplane" class="fa fa-paper-plane-o"></i>
		</div>
	</div>
</div>
@endsection