
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/png" href="{{{ asset('images/icon.gif') }}}">
	
	<title>{{ trans('pagination.nom') }}</title>
		
	<!-- Fonts -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
	<script	src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	
	<!-- Styles -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/main.css') }}"></link>
	<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/simple-sidebar.css') }}"></link>
	@if (!Auth::guest() && Auth::user()->UTI_COULR != null)
		<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/coulr-' . Auth::user()->UTI_COULR . '.css') }}"></link>
	@else
		<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/coulr-red.css') }}"></link>
	@endif
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div id="header" class="header">
		<div class="content-header">
			@if (Auth::guest())
			<a href="{{ url('/switchLangue') }}" class="btn-menu btn-menu-right">
				<i class="fa fa-globe"></i>
			</a>
			@if (Route::getCurrentRoute()->getPath() === ('about'))
			<a href="{{ url('/login') }}" class="btn-menu btn-menu-left">
				<i class="fa fa-sign-in"></i>
			</a>
			@else
			<a href="{{ url('/about') }}" class="btn-menu btn-menu-left">
				<i class="fa fa-info-circle"></i>
			</a>
			@endif
			@else
			<a href="#left-menu-toggle" class="btn-menu btn-menu-left" id="left-menu-toggle">
				<i class="fa fa-list-ul"></i>
			</a>
			<a href="#right-menu-toggle" class="btn-menu btn-menu-right" id="right-menu-toggle">
				<i class="fa fa-navicon"></i>
			</a> 
			@endif
			<div class="titre">
				<a href="{{ url('/') }}">@yield('title')</a>
			</div>
		</div>
	</div>
    <div id="wrapper">

        <!-- Left Sidebar -->
        <div id="left-sidebar-wrapper">
	        <ul class="ulGlobal sidebar-nav">
		        <li class="sidebar-brand">
                        Options
                </li>
				@if (!Auth::guest())
				<li><a href="{{ url('/profil') }}">
					<img src="{{ Auth::user()->getImage() }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="imageMenu" class="imageMenu">
					{{ Auth::user()->UTI_CODE }}
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
			<br /><br /><br />
			</ul>
        </div>
        <!-- /#left-sidebar-wrapper -->

        <!-- Right Sidebar -->
        <div id="right-sidebar-wrapper">
	        <ul class="ulGlobal sidebar-nav">
				<li class="sidebar-brand">
					Menu
				</li>
				<li><a href="{{ url('/') }}">
					<i class="fa fa-btn fa-home"></i>{{ trans('pagination.home') }}
				</a></li>
				<li><a href="{{ url('/results') }}">
					<i class="fa fa-btn fa-star"></i>{{ trans('pagination.results') }}
				</a></li>
				<li><a href="{{ url('/poolClassic') }}">
					<i class="fa fa-btn fa-gamepad"></i>{{ trans('pagination.poolClassic') }}
				</a></li>
				<ul>
					<li><a href="{{ url('/voteClassic') }}">
						<i class="fa fa-btn fa-file-o"></i>{{ trans('pagination.form') }}
					</a></li>
				</ul>
				<li><a href="{{ url('/poolPlayoff') }}">
					<i class="fa fa-btn fa-crosshairs"></i>{{ trans('pagination.poolPlayoff') }}
				</a></li>
				<ul>
					<li><a href="{{ url('/votePlayoff') }}">
						<i class="fa fa-btn fa-file-o"></i>{{ trans('pagination.form') }}
					</a></li>
				</ul>
				<li><a href="{{ url('/poolSurvivor') }}">
					<i class="fa fa-btn fa-sitemap"></i>{{ trans('pagination.poolSurvivor') }}
				</a></li>
				<ul>
					<li><a href="{{ url('/voteSurvivor') }}">
						<i class="fa fa-btn fa-file-o"></i>{{ trans('pagination.form') }}
					</a></li>
				</ul>
				<li><a href="{{ url('/chat') }}">
					<i class="fa fa-btn fa-comments"></i>{{ trans('pagination.chat') }}
				</a></li>
				@if (!Auth::guest() && (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin()))
				<li><hr class="hrMenu"></li>
				<li><a href="{{ url('/admin') }}">
					<i class="fa fa-btn fa-shield"></i>{{ trans('pagination.admin') }}
				</a></li>
				<ul>
					<li><a href="{{ url('/admin/users') }}">
						<i class="fa fa-btn fa-users"></i>{{ trans('pagination.user') }}
					</a></li>
					<li><a href="{{ url('/admin/pool') }}">
						<i class="fa fa-btn fa-plus"></i>{{ trans('pagination.createPool') }}
					</a></li>
				</ul>
				@endif
				<br /><br /><br />
			</ul>
        </div>
        <!-- /#right-sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" class="">
            <div class="container-fluid">
				@yield('content')
				<br /><br /><br />
            </div>
        </div>
        <!-- /#page-content-wrapper -->
		<div id="footer" class="footer"></div>	
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
	<script	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#left-menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("left-toggled");
        $("#wrapper").removeClass("right-toggled");
    });

    $("#right-menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("right-toggled");
        $("#wrapper").removeClass("left-toggled");
    });
    </script>

</body>

</html>
