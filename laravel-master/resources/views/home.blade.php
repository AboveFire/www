@extends('layouts.app')
@section('title', 'Live Pool')
@section('content')
<link type="text/css" rel="stylesheet"
	href="{{ URL::asset('css/home.css') }}"></link>
<div class="container">
	<div class="option_home">
		<a href="{{ url('/results') }}"> <i class="fa fa-star"></i>
			<h1>Résultats</h1>
		</a>
		<p>Bacon ipsum dolor amet pig corned beef jerky kevin salami porchetta
			short ribs, andouille alcatra spare ribs. Biltong capicola ground
			round, boudin tongue chuck cupim swine picanha</p>
	</div>
	<div class="option_home">
		<a href="{{ url('/results-classic') }}"> <i class="fa fa-gamepad"></i>
			<h1>Pool classique</h1>
		</a>
		<p>Bacon ipsum dolor amet pig corned beef jerky kevin salami porchetta
			short ribs, andouille alcatra spare ribs. Biltong capicola ground
			round, boudin tongue chuck cupim swine picanha</p>
	</div>
	<div class="option_home">
		<a href="{{ url('/results-playoff') }}"> <i class="fa fa-crosshairs"></i>
			<h1>Pool playoff</h1>
		</a>
		<p>Bacon ipsum dolor amet pig corned beef jerky kevin salami porchetta
			short ribs, andouille alcatra spare ribs. Biltong capicola ground
			round, boudin tongue chuck cupim swine picanha</p>
	</div>
	<div class="option_home">
		<a href="{{ url('/results-survivor') }}"> <i class="fa fa-sitemap"></i>
			<h1>Pool survivor</h1>
		</a>
		<p>Bacon ipsum dolor amet pig corned beef jerky kevin salami porchetta
			short ribs, andouille alcatra spare ribs. Biltong capicola ground
			round, boudin tongue chuck cupim swine picanha</p>
	</div>
	<div class="option_home">
		<a href="{{ url('/chat') }}"> <i class="fa fa-comments"></i>
			<h1>Clavardage</h1>
		</a>
		<p>Bacon ipsum dolor amet pig corned beef jerky kevin salami porchetta
			short ribs, andouille alcatra spare ribs. Biltong capicola ground
			round, boudin tongue chuck cupim swine picanha</p>
	</div>
</div>
@endsection
