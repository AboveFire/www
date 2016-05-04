@extends('layouts.app') @section('title', 'Paramètres')
@section('content')
<br />
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	<hr>
	<form class="form-horizontal" role="form" method="POST" action="{{ url('/profil/save') }}" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="ligne">
			<div class="colonne gauche">
				<div class="form-group{{ $errors->has('paswd') ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">#paswd#</label>
					<div class="col col-md-12">
						<input type="password" class="form-control" name="paswd">
						@if($errors->has('paswd')) 
						<span class="help-block"> 
							<strong>{{$errors->first('paswd') }}</strong>
						</span> 
						@endif
					</div>
				</div>
			</div>
			<div class="colonne droite">
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
		</div>	
		<hr>
		<div class="ligne">
			<div class="colonne gauche">
				<div class="form-group">
					<div class="col-md-2 gauche">
						<button onclick="location.href='{{ url('/profil') }}'" type="button" class="butn btn-width-100">
							<i class="fa fa-btn fa-times"></i>Annuler
						</button>
					</div>
				</div>
			</div>
			<div class="colonne droite">
				<div class="droite">
					<button type="submit" class="butn btn-width-100">
						<i class="fa fa-btn fa-save"></i>Enregistrer
					</button>
				</div>
			</div>
		</div>
	</form>
	<span class="image"></span>
</div>

@endsection
