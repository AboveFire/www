@extends('layouts.app') @section('title') {{ trans('pagination.nom') }} @endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/admin.css') }}"></link>
<!-- Page Content -->
<div class="tableau">
	<!-- Team Members Row -->
	<div class="row">
		<div class="col-lg-4 col-sm-6 text-center">
			<div class="ligne_option">
				<a class="txtEtImage" href="{{ url('/admin/users') }}"> <i class="fa fa-users"></i>
					<h1 class="titreMenu">{{ trans('pagination.user') }}</h1>
				</a>
			</div>
			<div class="ligne_descr">
				<p class="txtMenu">{{ trans('descr.results') }}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-6 text-center">
			<div class="ligne_option">
				<a class="txtEtImage" href="{{ url('/admin/pool') }}"> <i class="fa fa-plus"></i>
					<h1 class="titreMenu">{{ trans('pagination.createPool') }}</h1>
				</a>
			</div>
			<div class="ligne_descr">
				<p class="txtMenu">{{ trans('descr.users') }}</p>
			</div>
		</div>
	</div>
</div>
@endsection
