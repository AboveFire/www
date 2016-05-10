<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="{{{ asset('images/icon.gif') }}}">
		
		<title>Live Pool</title>
		
		<!-- Fonts -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
		<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
		
		<!-- Styles -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
		
		<!-- <link type="text/css" rel="stylesheet" href="{{ URL::asset('css/main.css') }}"></link> -->
		<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/main.css') }}"></link>
	</head>
	
	<body id="app-layout">
		<nav id="menu" class="side">
			<div class="header">
				<div>
					<a href="#menu-side" class="menu-link">
						<i class="fa fa-arrow-circle-right"></i>
					</a>
					<div class="sous-titre titreMenuD">Menu</div>
				</div>
			</div>
			<ul class="ulGlobal">
				<li><a href="{{ url('/home') }}">
					<i class="fa fa-btn fa-home"></i>{{ trans('pagination.home') }}
				</a></li>
				<li><a href="{{ url('/results') }}">
					<i class="fa fa-btn fa-star"></i>{{ trans('pagination.results') }}
				</a></li>
				<li><a href="{{ url('/results-classic') }}">
					<i class="fa fa-btn fa-gamepad"></i>{{ trans('pagination.poolClassic') }}
				</a></li>
				<ul>
					<li><a href="{{ url('/form-classic') }}">
						<i class="fa fa-btn fa-file-o"></i>{{ trans('pagination.form') }}
					</a></li>
				</ul>
				<li><a href="{{ url('/results-playoff') }}">
					<i class="fa fa-btn fa-crosshairs"></i>{{ trans('pagination.poolPlayoff') }}
				</a></li>
				<ul>
					<li><a href="{{ url('/form-playoff') }}">
						<i class="fa fa-btn fa-file-o"></i>{{ trans('pagination.form') }}
					</a></li>
				</ul>
				<li><a href="{{ url('/results-survivor') }}">
					<i class="fa fa-btn fa-sitemap"></i>{{ trans('pagination.poolSurvivor') }}
				</a></li>
				<ul>
					<li><a href="{{ url('/form-survivor') }}">
						<i class="fa fa-btn fa-file-o"></i>{{ trans('pagination.form') }}
					</a></li>
				</ul>
				<li><a href="{{ url('/chat') }}">
					<i class="fa fa-btn fa-comments"></i>{{ trans('pagination.chat') }}
				</a></li>
				@if (true/*Auth::user()->isAdmin()*/)
				<li><hr class="hrMenu"></li>
				<li><a href="{{ url('/admin-home') }}">
					<i class="fa fa-btn fa-shield"></i>{{ trans('pagination.admin') }}
				</a></li>
				<ul>
					<li><a href="{{ url('/admin-users') }}">
						<i class="fa fa-btn fa-users"></i>{{ trans('pagination.user') }}
					</a></li>
					<li><a href="{{ url('/admin-pool') }}">
						<i class="fa fa-btn fa-plus"></i>{{ trans('pagination.createPool') }}
					</a></li>
				</ul>
				@endif
			</ul>
			<!--<div class="footer">
	  		</div>-->
		</nav>
		<nav id="menu-left" class="side">
			<div class="header">
				<div>
					<a href="#menu-left-side" class="menu-link-left">
						<i class="fa fa-arrow-circle-left"></i>
					</a>
					<div class="sous-titre titreMenuG">Options</div>
				</div>
			</div>
			<ul class="ulGlobal">
				@if (!Auth::guest())
				<li><a href="{{ url('/profil') }}">
					<img src="{{ Auth::user()->getImage() }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="imageMenu" class="imageMenu">
					{{ Auth::user()->getNomPrenm() }}
				</a></li>
				<li><a href="{{ url('/param') }}">
					<i class="fa fa-btn fa-cog"></i>{{ trans('pagination.param') }}
				</a></li>
				@endif
				<li><a href="{{ url('/about') }}">
					<i class="fa fa-btn fa-info-circle"></i>{{ trans('pagination.about') }}
				</a></li>
				@if (!Auth::guest())
				<li><a href="{{ url('/logout') }}">
					<i class="fa fa-btn fa-power-off"></i>{{ trans('pagination.logout') }}
				</a></li>
				@endif
			</ul>
			<!--<div class="footer">
	  		</div>-->
		</nav>
		<div id="header" class="header">
			<div class="content-header">
				@if (Auth::guest())
				<a href="{{ url('/switchLangue') }}" class="textOffline btn-menu btn-menu-right">
					<i>{{ trans('general.language') }}</i>
				</a>
				<a href="{{ url('/about') }}" class="textOffline btn-menu btn-menu-left">
					<i>{{ trans('pagination.about') }}</i>
				</a>
				@else
				<a href="#menu-left" class="menu-link-left btn-menu btn-menu-left">
					<i class="fa fa-list-ul"></i>
				</a>
				<a href="#menu" class="menu-link btn-menu btn-menu-right">
					<i class="fa fa-navicon"></i>
				</a> 
				@endif
				<div class="titre">
					<a href="{{ url('/') }}">@yield('title')</a>
				</div>
			</div>
		</div>
		<div class="main-container container">
			@yield('content')
	
			<!-- JavaScripts -->
			<script type="text/javascript" src="{{ URL::asset('js/menu.js') }}"></script>
			<script	src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
			<script	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
			{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
		</div>
		<div id="footer" class="footer"></div>	
	</body>
</html>
