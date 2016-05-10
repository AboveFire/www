@extends('layouts.app')
@section('title')
{{ trans('pagination.nom') }}
@endsection
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/form.css') }}"></link>

@section('content')
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ session('status') }}
	</div>
	@endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">#titreInscription#</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}
                        <div class="ligne">

							<div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
	                            <div class="col-md-12">
	                                <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" placeholder="#nom#">
	                                @if ($errors->has('nom'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('nom') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
                        </div>
                        <div class="ligne">
                        
	                        <div class="form-group{{ $errors->has('prenm') ? ' has-error' : '' }}">
	                            <div class="col-md-12">
	                                <input type="text" class="form-control" name="prenm" value="{{ old('prenm') }}" placeholder="#prenm#">
	                                @if ($errors->has('prenm'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('prenm') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
                        </div>
                        <div class="ligne">

                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="#code#">
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        </div>
                        <div class="ligne">

                        <div class="form-group{{ $errors->has('courl') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="courl" value="{{ old('courl') }}" placeholder="#courl#">
                                @if ($errors->has('courl'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('courl') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        </div>
                        <div class="ligne">

                        <div class="form-group{{ $errors->has('paswd') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="paswd" placeholder="#paswd#">
                                @if ($errors->has('paswd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paswd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        </div>
                        <div class="ligne">

                        <div class="form-group{{ $errors->has('paswd_confirmation') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input type="password" class="form-control" name="paswd_confirmation" placeholder="#paswd_confirmation#">
                                @if ($errors->has('paswd_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paswd_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        </div>
                        <div class="ligne">

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <a class="btn btn-link colonne gauche btn-width-50" href="{{ url('/') }}"><i class="fa fa-sign-in"></i> &nbsp;#butnDejaInscrit#</a>
                                <button type="submit" class="butn colonne droite btn-width-50">
                         <i class="fa fa-btn fa-user"></i>#butnInscrire#
                                </button>

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
