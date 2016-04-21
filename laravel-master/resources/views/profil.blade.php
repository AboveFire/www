@extends('layouts.app') @section('title', 'Profil utilisateur')
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/profil.css') }}"></link>
<div class="container container-profil">
	<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
		{!! csrf_field() !!}
		<div class="ligne">
			<div class="colonne">
				<div class="form-group{{ $errors->has('img') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">#img#</label>
					<img src="image.jpg" alt="image" class="image col-md-2" accept="image/*">
					<div class="col col-md-12">
						<input type="file" name="img" value="{{ old('img') }}"> 
						@if ($errors->has('img')) 
						<span class="help-block"> 
							<strong>{{ $errors->first('img') }}</strong>
						</span> 
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="ligne">
			<div class="colonne">
				<div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">#nom#</label>
					<div class="col col-md-12">
						<input type="text" class="form-control" name="nom" value="{{ Auth::user()->UTI_NOM }}"> 
						@if ($errors->has('nom')) 
						<span class="help-block"> 
							<strong>{{ $errors->first('nom') }}</strong>
						</span> 
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">#code#</label>
					<div class="col col-md-12">
						<input type="text" class="form-control" name="code" value="{{ Auth::user()->UTI_CODE }}"> 
						@if ($errors->has('code')) 
						<span class="help-block"> 
							<strong>{{ $errors->first('code') }}</strong>
						</span> 
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('telph') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">#telph#</label>
					<div class="col col-md-12">
						<input type="text" class="form-control" name="telph" value="{{ Auth::user()->UTI_TELPH }}"> 
						@if ($errors->has('telph')) 
						<span class="help-block"> 
							<strong>{{ $errors->first('telph') }}</strong>
						</span> 
						@endif
					</div>
				</div>
			</div>
			<div class="colonne">
				<div class="form-group{{ $errors->has('prenm') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">#prenm#</label>
					<div class="col col-md-12">
						<input type="text" class="form-control" name="prenm" value="{{ Auth::user()->UTI_PRENM }}"> 
						@if ($errors->has('prenm')) 
						<span class="help-block">
							<strong>{{ $errors->first('prenm') }}</strong>
						</span> 
						@endif
					</div>
				</div>
				<div class="form-group{{ $errors->has('courl') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">#courl#</label>
					<div class="col col-md-12">
						<input type="email" class="form-control" name="courl" value="{{ Auth::user()->UTI_COURL }}"> 
						@if ($errors->has('courl')) 
						<span class="help-block">
							<strong>{{ $errors->first('courl') }}</strong>
						</span> 
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="ligne">
			<div class="colonne">
				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">#paswd#</label>
					<div class="col col-md-12">
						<input type="password" class="form-control" name="password">
						@if($errors->has('password')) 
						<span class="help-block"> 
							<strong>{{$errors->first('password') }}</strong>
						</span> 
						@endif
					</div>
				</div>
			</div>
			<div class="colonne">
				<div class="form-group{{ $errors->has('paswd_confirmation') ? ' has-error' : '' }}">
		        	<label class="col-md-2 control-label">#paswd_confirmation#</label>
					<div class="col col-md-12">
						<input type="password" class="form-control" name="paswd_confirmation">
						@if ($errors->has('paswd_confirmation'))
						<span class="help-block">
							<strong>{{ $errors->first('paswd_confirmation') }}</strong>
						</span>
						@endif
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button onclick="location.href='{{ url('/profil') }}'" type="button" class="btn btn-primary">
						<i class="fa fa-btn fa-times"></i>Annuler
					</button>
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-btn fa-save"></i>Enregistrer
					</button>
				</div>
			</div>
		</div>
	</form>
	<span class="image"></span>
</div>
@endsection
