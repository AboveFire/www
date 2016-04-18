<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Laravel</title>

<!-- Fonts -->
<link
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css"
	rel='stylesheet' type='text/css'>
<link
	href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"
	rel='stylesheet' type='text/css'>

<!-- Styles -->
<link
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
	rel="stylesheet">

<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
{{--
<link href="{{ elixir('css/app.css') }}" rel="stylesheet">
--}}

<!-- <link type="text/css" rel="stylesheet" href="{{ URL::asset('css/main.css') }}"></link> -->
<link type="text/css" rel="stylesheet"
	href="{{ URL::asset('css/main.css') }}"></link>

</head>

<body id="app-layout">
	<nav id="menu" class="side">
		<div class="header">
			<span><a href="#menu-side" class="menu-link"><i class="fa fa-arrow-circle-right"></i></a><h3>Menu</h3></span>
		</div>
		<ul>
			<li><a href="{{ url('/home') }}">Accueil</a></li>
			<li><a href="{{ url('/results') }}">Résultats</a></li>
			<li><a href="{{ url('/results-classic') }}">Pool classique</a></li>
			<ul>
				<li><a href="{{ url('/form-classic') }}">Formulaire classique</a></li>
			</ul>
			<li><a href="{{ url('/results-playoff') }}">Pool playoff</a></li>
			<ul>
				<li><a href="{{ url('/form-playoff') }}">Formulaire playoff</a></li>
			</ul>
			<li><a href="{{ url('/results-survivor') }}">Pool survivor</a></li>
			<ul>
				<li><a href="{{ url('/form-survivor') }}">Formulaire survivor</a></li>
			</ul>
			<li><a href="{{ url('/chat') }}">Clavardage</a></li>
			@if (true/*Auth::user()->isAdmin()*/)
				<li><a href="{{ url('/admin-home') }}">Administration</a></li>
				<ul>
					<li><a href="{{ url('/admin-pool') }}">Gestion des utilisateurs</a></li> 
					<li><a href="{{ url('/admin-users') }}">Création d'un pool</a></li>
				</ul>
			@endif
		</ul>
		<!--<div class="footer">
  		</div>-->
	</nav>
	<nav id="menu-left" class="side">
		<div class="header">
			<span><a href="#menu-left-side" class="menu-link-left"><i class="fa fa-arrow-circle-left"></i></a><h3>Options</h3></span>
		</div>
		<ul>
			@if (Auth::guest())
				<li><a href="{{ url('/login') }}">Login</a></li>
				<li><a href="{{ url('/register') }}">Register</a></li> 
			@else
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> {{
					Auth::user()->name }} <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">
				<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
				</ul></li> 
			@endif
			<li><a href="{{ url('/about') }}">About</a></li>
		</ul>
		<!--  <div class="footer">
  		</div>-->
	</nav>
	<div id="header" class="header">
		<a href="#menu" class="menu-link fixed"><i class="fa fa-navicon"></i></a>
    	<p>Live Pool</p>
    	<a href="#menu-left" class="menu-link-left fixed-left"><i class="fa fa-list-ul"></i></a>
  	</div>
	<div class="main-container container">

		@yield('content')

		<!-- JavaScripts -->
		<script type="text/javascript" src="{{ URL::asset('js/menu.js') }}"></script>
		<script
			src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script
			src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		{{--
		<script src="{{ elixir('js/app.js') }}"></script>
		--}}
	</div>
	<div id="footer" class="footer">
  	</div>
</body>
</html>
