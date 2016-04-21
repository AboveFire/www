@extends('layouts.app')
@section('title', 'Live Pool')

@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/about.css') }}"></link>
<div class="main">
	<img src="logo.jpg" alt="Logo" class="logo">
	<h1 class="realise">Réalisé par :</h1>
	<ul>
		<li>Olivier Parent</li>
		<li>Simon Côté</li>
		<li>Samuel Foisy</li>
		<li>Samuel Dansereau</li>
	</ul>
	<p>
		Tous les logos des équipes et leurs nom sont une propriété de la NFL.<br />
		Toutes les informations proviennent du site officiel de la NFL.
	</p>
	<p>Pour plus d'information, contacter monsieur Samuel Dansereau (Samuel.Dansereau@outlook.com)</p>
</div>
@endsection
