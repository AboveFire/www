@extends('layouts.app')
@section('title')
{{ trans('pagination.about') }}
@endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/about.css') }}"></link>
<div class="main">
	<img src="{{ URL::asset('images/logo.png') }}" alt="Logo" class="logo">
	<h1 class="realise sous-titre">	{{ trans('about.header') }}	</h1>
	<span>Olivier Parent<br />
		Samuel Dansereau<br />
		Samuel Foisy<br />
		Simon Côté<br />
	</span>
	<p>
		{{ trans('about.disclaimer') }}<br />
		{{ trans('about.disclaimer2') }}
	</p>
	<p>{{ trans('about.moreInfo') }} <a href="samuel.dansereau@outlook.com" target="_top">samuel.dansereau@outlook.com</a>.</p>
	<p><a href="{{ asset('docx/rules.docx') }}" target="_blank">{{ trans('about.rules')}}</a></p> 
	<p><a href="{{ asset('apk/LivePool.apk') }}" target="_blank">{{ trans('about.apk')}}</a> </p>
</div>
@endsection
 