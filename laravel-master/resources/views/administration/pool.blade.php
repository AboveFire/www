@extends('layouts.app')
@section('title')
{{ trans('pagination.admin') }}
@endsection
@section('content')
<br />
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/form.css') }}"></link>
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
	@if (session('error'))
	<div class="alert alert-danger">
		{{ session('error') }}
	</div>
	@endif
	<div class="panel-heading"><i class="fa fa-plus big-fa"></i></div>
	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/pool/create') }}" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="ligne">
			<div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
				<div class="col col-md-12">
					<input type="hidden" name="seqnc" value="{{ Auth::user()->UTI_SEQNC }}"> 
					<input type="text" class="form-control" name="nom" placeholder="{{ trans('admin.nomPool') }}"> 
					@if ($errors->has('nom')) 
					<span class="help-block"> 
						<strong>{{ $errors->first('nom') }}</strong>
					</span> 
					@endif
				</div>
			</div>
		</div>
		<div class="ligne"> 
			<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
				<div class="col-md-12">
					<select id="#selectLang" class="form-control" name="type">
						<option selected disabled>{{ trans('admin.typePool') }}</option>
						@foreach($types as $type)
					    <option value="{{$type->TYP_SEQNC}}">{{ trans('pagination.' . $type->TYP_NOM)}}</option>
						@endforeach
					</select>
					@if ($errors->has('type'))
					<span class="help-block">
						<strong>{{ $errors->first('type') }}</strong>
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
@endsection
