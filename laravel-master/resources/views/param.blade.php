@extends('layouts.app')
@section('title')
{{ trans('pagination.param') }}
@endsection
@section('content')
<br />
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/form.css') }}"></link>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ trans(session('status')) }}
	</div>
	@endif
	<div class="panel-heading"><i class="fa fa-cog big-fa"></i></div>
	<form class="form-horizontal" role="form" method="POST" action="{{ url('/param/save') }}" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="ligne">
			<input type="hidden" name="seqnc" value="{{ Auth::user()->UTI_SEQNC }}"> 
			<div class="form-group{{ $errors->has('coulr') ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">{{ trans('param.couleur') }}</label>
				<div class="col-md-12">
				<div class="margin-bottom-sm input-group">
					<span class="input-group-addon"><i class="fa fa-paint-brush fa-fw" aria-hidden="true"></i></span>
					<select id="#selectCoulr" class="form-control" name="coulr">
						<option id="red" value="red">{{ trans('param.rouge') }}</option>
						<option id="cyan" value="cyan">{{ trans('param.cyan') }}</option>
					  	<option id="blue" value="blue">{{ trans('param.bleu') }}</option>
					  	<option id="yellow" value="yellow">{{ trans('param.jaune') }}</option>
					  	<option id="green" value="green">{{ trans('param.vert') }}</option>
					  	<option id="orange" value="orange">{{ trans('param.orange') }}</option>
					  	<option id="purple" value="purple">{{ trans('param.mauve') }}</option>
					  	<option id="white" value="white">{{ trans('param.blanc') }}</option>
					  	<option id="black" value="black">{{ trans('param.gris') }}</option>
					  	<option id="sarc" value="sarc">{{ trans('param.sarc') }}</option>
					</select>
				</div>
					@if($errors->has('coulr')) 
					<span class="help-block"> 
						<strong>{{$errors->first('coulr') }}</strong>
					</span> 
					@endif
				</div>
			</div>
		</div>
		<div class="ligne">
			<div class="form-group{{ $errors->has('lang') ? ' has-error' : '' }}">
	        	<label class="col-md-2 control-label">{{ trans('param.langue') }}</label>
				<div class="col-md-12">
				<div class="margin-bottom-sm input-group">
					<span class="input-group-addon"><i class="fa fa-globe fa-fw" aria-hidden="true"></i></span>
					<select id="#selectLang" class="form-control" name="lang">
						<option id="FR" value="FR">Français</option>
						<option id="EN" value="EN">English</option>
					</select>
				</div>
					@if ($errors->has('lang'))
					<span class="help-block">
						<strong>{{ $errors->first('lang') }}</strong>
					</span>
					@endif
				</div>
			</div>
		</div>	
		<div class="ligne">
			<div class="form-group">
				<div class="col-md-12 col-md-offset-4">
					<button onclick="location.href='{{ url('/param') }}'" type="button" class="butn btn-width-50">
						<i class="fa fa-btn fa-times"></i>{{ trans('general.butn_cancel') }}
					</button>
					<button type="submit" class="butn btn-width-50">
						<i class="fa fa-btn fa-save"></i>{{ trans('general.butn_save') }}
					</button>
				</div>
			</div>
		</div>
		<div class="ligne">
			<div class="colonne gauche">
				<div class="form-group">
					<div class="col-md-2 gauche">
					</div>
				</div>
			</div>
			<div class="colonne droite">
				<div class="droite">
				</div>
			</div>
		</div>
	</form>
	<span class="image"></span>
</div>
<script type="text/javascript">
	$({{ Auth::user()->UTI_COULR}}).attr("selected", "selected");
	$({{ Auth::user()->getLangue()}}).attr("selected", "selected");
</script>
@endsection
