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
</script>
<div class="container">
	<div id="sschat">
		<div id="sschat_lines">
			<ul></ul>
		</div
		><div id="sschat_connected">
		</div
		><div id="sschat_entry">
			<p id="sschat_hint">Type your nickname and press enter:</p>
			<!-- <input type="text" id="sschat_input"> -->
			<textarea id="sschat_input" rows=2></textarea>
		</div>
	</div>
</div>
@endsection