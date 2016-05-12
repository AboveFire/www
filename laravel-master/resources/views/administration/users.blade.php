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
	<div class="panel-heading"><i class="fa fa-users big-fa"></i></div>
	<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/users/update') }}" enctype="multipart/form-data">
		{!! csrf_field() !!}
		<div class="ligne">
			<div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
				<div class="col-md-12">
					<select id="#selectUser" class="form-control" name="user">
						<option selected value=null>{{ trans('admin.user') }}</option>
						@foreach($users as $user)
					    <option value="{{$user->UTI_SEQNC}}">{{'[' . $user->UTI_CODE . '] - ' . $user->UTI_PRENM . ' ' . $user->UTI_NOM}}</option>
						@endforeach
					</select>
					@if($errors->has('user')) 
					<span class="help-block"> 
						<strong>{{$errors->first('user') }}</strong>
					</span> 
					@endif
				</div>
			</div>
		</div>
		<div class="ligne">
			<div class="form-group{{ $errors->has('droit') ? ' has-error' : '' }}">
				<div class="col-md-12">
					<select id="#selectLang" class="form-control" name="droit">
						<option selected value=null>{{ trans('admin.droit') }}</option>
						<option id="B" value="B">{{ trans('admin.base') }}</option>
						<option id="A" value="A">{{ trans('admin.admin') }}</option>
					</select>
					@if ($errors->has('droit'))
					<span class="help-block">
						<strong>{{ $errors->first('droit') }}</strong>
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
