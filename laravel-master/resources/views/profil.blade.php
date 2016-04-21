@extends('layouts.app') @section('title', 'Profil utilisateur')
@section('content')
<div class="container-profil">
	<form class="form-horizontal" role="form" method="POST"
		action="{{ url('/login') }}">
		{!! csrf_field() !!}

		<div
			class="form-group{{ $errors->has('uti_code') ? ' has-error' : '' }}">
			<label class="col-md-4 control-label">#courl#</label>

			<div class="col-md-6">
				<input type="text" class="form-control" name="uti_code"
					value="{{ old('email') }}"> @if ($errors->has('uti_code')) <span
					class="help-block"> <strong>{{ $errors->first('uti_code') }}</strong>
				</span> @endif
			</div>
		</div>

		<div
			class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
			<label class="col-md-4 control-label">#paswd#</label>

			<div class="col-md-6">
				<input type="password" class="form-control" name="password">
				@if($errors->has('password')) <span class="help-block"> <strong>
						{{$errors->first('password') }}</strong>
				</span> @endif
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-4">
				<button onclick="location.href='{{ url('/profil') }}'" type="button"
					class="btn btn-primary">
					<i class="fa fa-btn fa-sign-in"></i>Annuler
				</button>
				<button type="submit" class="btn btn-primary">
					<i class="fa fa-btn fa-sign-in"></i>Enregistrer
				</button>
			</div>
		</div>
	</form>
	<span class="image"></span> <span class="formulaire"> <span
		class="colonne colonne1"></span> <span class="colonne colonne2"></span>
	</span>
</div>
@endsection
