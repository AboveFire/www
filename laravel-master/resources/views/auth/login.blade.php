@extends('layouts.app')
@section('title')
{{ trans('pagination.nom') }}
@endsection

@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/form.css') }}"></link>
<div class="container container-login">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('pagination.login') }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
						<div class="ligne">
	                        <div class="form-group{{ $errors->has('uti_code') ? ' has-error' : '' }}">
	                            <div class="col-md-12">
	                                <input type="text" class="form-control" name="uti_code" value="{{ old('uti_code') }}" placeholder="{{ trans('auth.code') }}">
	
	                                @if ($errors->has('uti_code'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('uti_code') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
                        </div>
                        <div class="ligne">
	                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	                            <div class="col-md-12">
	                                <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.mdp') }}">
	
	                                @if ($errors->has('password'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('password') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
						</div>
						<!-- <div class="ligne">
	                        <div class="form-group">
	                            <div class="col-md-12 col-md-offset-4">
	                                <div class="checkbox">
	                                    <label>
	                                        <input type="checkbox" name="remember"> #txtSeSouvenir#
	                                    </label>
	                                </div>
	                            </div>
	                        </div>
						</div> -->
						<div class="ligne">
	                        <div class="form-group">
	                            <div class="col-md-12 col-md-offset-4">
		                            <div class="zoneBtnLogin">
		                                <button type="submit" class="butn btn-width-100">
		                                    <i class="fa fa-btn fa-sign-in"></i>{{ trans('auth.butn_login') }}
		                                </button>
									</div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="ligne">
	                        <div class="form-group">
	                            <div class="col-md-12 col-md-offset-4">
	                                <a class="btn btn-link colonne gauche btn-width-50" href="{{ url('/password/reset') }}"><i class="fa fa-external-link"></i> &nbsp;{{ trans('auth.butn_mdpOublie') }}</a>
	                                <a class="btn btn-link colonne droite btn-width-50" href="{{ url('/register') }}"><i class="fa fa-plus-square-o"></i> &nbsp;{{ trans('auth.butn_inscrire') }}</a>
	                            </div>
	                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
