@extends('layouts.app') @section('title') {{ trans('pagination.nom') }} @endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/home.css') }}"></link>
<!-- Page Content -->
<div class="tableau">
	<!-- Team Members Row -->
	<div class="row">
		<div class="col-lg-4 col-sm-6 text-center">
			<div class="ligne_option">
				<a class="txtEtImage" href="{{ url('/results') }}"> <i class="fa fa-star"></i>
					<h1 class="titreMenu">{{ trans('pagination.results') }}</h1>
				</a>
			</div>
			<div class="ligne_descr">
				<p class="txtMenu">{{ trans('descr.results') }}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-6 text-center">
			<div class="ligne_option">
				<a class="txtEtImage" href="{{ url('/poolClassic') }}"> <i class="fa fa-gamepad"></i>
					<h1 class="titreMenu">{{ trans('pagination.poolClassic') }}</h1>
				</a>
			</div>
			<div class="ligne_descr">
				<p class="txtMenu">{{ trans('descr.pool', ['pool' => trans('pagination.poolClassic')]) }}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-6 text-center">
			<div class="ligne_option">
				<a class="txtEtImage" href="{{ url('/poolPlayoff') }}"> <i class="fa fa-crosshairs"></i>
					<h1 class="titreMenu">{{ trans('pagination.poolPlayoff') }}</h1>
				</a>
			</div>
			<div class="ligne_descr">
				<p class="txtMenu">{{ trans('descr.pool', ['pool' => trans('pagination.poolPlayoff')]) }}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-6 text-center">
			<div class="ligne_option">
				<a class="txtEtImage" href="{{ url('/poolSurvivor') }}"> <i class="fa fa-sitemap"></i>
					<h1 class="titreMenu">{{ trans('pagination.poolSurvivor') }}</h1>
				</a>
			</div>
			<div class="ligne_descr">
				<p class="txtMenu">{{ trans('descr.pool', ['pool' => trans('pagination.poolSurvivor')]) }}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-6 text-center">
			<div class="ligne_option">
				<a class="txtEtImage" href="{{ url('/chat') }}"> <i class="fa fa-comments"></i>
					<h1 class="titreMenu">{{ trans('pagination.chat') }}</h1>
				</a>
			</div>
			<div class="ligne_descr">
				<p class="txtMenu">{{ trans('descr.chat') }}</p>
			</div>
		</div>
	</div>
</div>
@endsection
