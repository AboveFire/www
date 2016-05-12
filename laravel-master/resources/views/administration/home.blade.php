@extends('layouts.app')
@section('title')
{{ trans('pagination.admin') }}
@endsection
@section('content')
<link type="text/css" rel="stylesheet"
	href="{{ URL::asset('css/admin.css') }}"></link>
<div class="container">
@if (session('status'))
<div class="alert alert-success">
	{{ session('status') }}
</div>
@endif
	<div class="tableau">
		<div class="ligne_option">
			<a class="txtEtImage" href="{{ url('/admin/users') }}"> <i class="fa fa-users"></i>
				<h1 class="titreMenu">{{ trans('pagination.user') }}</h1>
			</a>
		</div>
		<div class="ligne_option">
			<a class="txtEtImage" href="{{ url('/admin/pool') }}"> <i class="fa fa-plus"></i>
				<h1 class="titreMenu">{{ trans('pagination.createPool') }}</h1>
			</a>
		</div>
		<div class="ligne_descr">
			<p class="txtMenu">{{ trans('descr.users') }}</p>
		</div>
		<div class="ligne_descr">
			<p class="txtMenu">{{ trans('descr.createPool') }}</p>
		</div>
	</div>
</div>
@endsection
