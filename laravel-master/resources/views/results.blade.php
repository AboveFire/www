@extends('layouts.app')
@section('title')
{{ trans('pagination.results') }}
@endsection

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/results.js') }}"></script>
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/pool.css') }}"></link>
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/results.css') }}"></link>
<script>
	var tokenMobile = "{{ csrf_token() }}";
</script>
<div class="container">
    <div id="image" class="image">
	</div>
</div>
@endsection
