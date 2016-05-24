@extends('layouts.app')
@section('title')
{{ trans('pagination.poolClassic') }}
@endsection
@section('content')
<br />
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif

	<span class="image"></span>
</div>
@endsection
