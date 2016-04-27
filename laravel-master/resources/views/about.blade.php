@extends('layouts.app')
@section('title', 'À propos')

@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/about.css') }}"></link>
<div class="main">
	<img src="{{ URL::asset('images/logo.png') }}" alt="Logo" class="logo">
	<h1 class="realise">	Réalisé par	</h1>
	<span>Olivier Parent<br />
		Simon Côté<br />
		Samuel Foisy<br />
		Samuel Dansereau<br />
	</span>
	<p>
		Tous les logos des équipes et leurs nom sont une propriété de la NFL.<br />
		Toutes les informations proviennent du site officiel de la NFL.
	</p>
	<p>Pour plus d'information, contacter monsieur Samuel Dansereau (Samuel.Dansereau@outlook.com)</p>
</div>
@endsection
