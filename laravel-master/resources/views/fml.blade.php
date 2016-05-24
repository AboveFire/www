@extends('layouts.app')
@section('title')
{{ trans('pagination.profile') }}
@endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/profil.css') }}"></link>
<br />
<div class="container container-profil">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<hr>
		<form class="form">
						<input type="hidden" name="seqnc" value="{{ Auth::user()->UTI_SEQNC }}"> 
						@if ($errors->has('seqnc')) 
						<span class="help-block"> 
							<strong>{{ $errors->first('seqnc') }}</strong>
						</span> 
						@endif
				<div class="form-group{{ $errors->has('img') ? ' has-error' : '' }} col-md-6">
				<label class="control-label">{{ trans('auth.image') }}</label>
				<div class="col-md-12 imgContent">
					<img src="{{ Auth::user()->getImage() }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="col-md-12 image">
				</div>
					<div class="col-md-12 btnUpload">
						<input type="file" name="img" value="{{ Auth::user()->UTI_IMAGE}}"> 
						@if ($errors->has('img')) 
						<span class="help-block"> 
							<strong>{{ $errors->first('img') }}</strong>
						</span> 
						@endif
					</div>
				</div>
			<div class="clearfix"></div>
  			<div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }} col-md-6">
				<label class="control-label">{{ trans('auth.nom') }}</label>
					<input type="text" class="form-control" name="nom" value="{{ Auth::user()->UTI_NOM }}"> 
					@if ($errors->has('nom')) 
					<span class="help-block"> 
						<strong>{{ $errors->first('nom') }}</strong>
					</span> 
					@endif
			</div>
			<div class="form-group{{ $errors->has('prenm') ? ' has-error' : '' }} col-md-6">
				<label class="control-label">{{ trans('auth.prenom') }}</label>
					<input type="text" class="form-control" name="prenm" value="{{ Auth::user()->UTI_PRENM }}"> 
					@if ($errors->has('prenm')) 
					<span class="help-block">
						<strong>{{ $errors->first('prenm') }}</strong>
					</span> 
					@endif
			</div>
			<div class="form-group{{ $errors->has('code') ? ' has-error' : '' }} col-md-6">
				<label class="control-label">{{ trans('auth.code') }}</label>
					<input type="text" class="form-control" name="code" value="{{ Auth::user()->UTI_CODE }}"> 
					@if ($errors->has('code')) 
					<span class="help-block"> 
						<strong>{{ $errors->first('code') }}</strong>
					</span> 
					@endif
			</div>
			<div class="clearfix"></div>
			<div class="form-group{{ $errors->has('courl') ? ' has-error' : '' }} col-md-6">
				<label class="control-label">{{ trans('auth.courl') }}</label>
					<input type="email" class="form-control" name="courl" value="{{ Auth::user()->UTI_COURL }}"> 
					@if ($errors->has('courl')) 
					<span class="help-block">
						<strong>{{ $errors->first('courl') }}</strong>
					</span> 
					@endif
			</div>
			<div class="form-group{{ $errors->has('telph') ? ' has-error' : '' }} col-md-6">
				<label class="control-label">{{ trans('auth.telph') }}</label>
					<input type="tel" class="form-control" name="telph" value="{{ Auth::user()->UTI_TELPH }}"> 
					@if ($errors->has('telph')) 
					<span class="help-block"> 
						<strong>{{ $errors->first('telph') }}</strong>
					</span> 
					@endif
			</div>
			<div class="form-group{{ $errors->has('paswd') ? ' has-error' : '' }} col-md-6">
				<label class="control-label">{{ trans('auth.mdp') }}</label>
					<input type="password" class="form-control" name="paswd">
					@if($errors->has('paswd')) 
					<span class="help-block"> 
						<strong>{{$errors->first('paswd') }}</strong>
					</span> 
					@endif
			</div>
			<div class="form-group{{ $errors->has('paswd_confirmation') ? ' has-error' : '' }} col-md-6">
	        	<label class="control-label">{{ trans('auth.mdpc') }}</label>
					<input type="password" class="form-control" name="paswd_confirmation">
					@if ($errors->has('paswd_confirmation'))
					<span class="help-block">
						<strong>{{ $errors->first('paswd_confirmation') }}</strong>
					</span>
					@endif
			</div>
				<hr>
				<div class="form-group">
					<div class="col-md-6 col-butn">
						<button onclick="location.href='{{ url('/profil') }}'" type="button" class="butn btn-width-100">
							<i class="fa fa-btn fa-times"></i>{{ trans('general.butn_cancel') }}
						</button>
					</div>
					<div class="col-md-6 col-butn">
						<button type="submit" class="butn btn-width-100">
						<i class="fa fa-btn fa-save"></i>{{ trans('general.butn_save') }}
					</button>
					</div>
				</div>
</form>

	<span class="image"></span>
</div>

@endsection
