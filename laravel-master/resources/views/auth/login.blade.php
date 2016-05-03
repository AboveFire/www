@extends('layouts.app')
@section('title', 'Live Pool')

@section('content')
<script src="{{ URL::asset('js/forms.js') }}"></script>
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/login.css') }}"></link>
<div class="container container-login">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">#titreLogin#</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
						<div class="ligne">
	                        <div class="form-group{{ $errors->has('uti_code') ? ' has-error' : '' }}">
	                            <!-- <label class="col-md-4 control-label">#courl#</label>-->
	                            <div class="col-md-12">
	                                <input type="text" class="form-control" name="uti_code" value="{{ old('uti_code') }}" placeholder="#champCode#">
	
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
	                            <!--  <label class="col-md-4 control-label">#paswd#</label>-->
	
	                            <div class="col-md-12">
	                                <input type="password" class="form-control" name="password" placeholder="#champMDP#">
	
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
		                                    <i class="fa fa-btn fa-sign-in"></i>#btnLogin#
		                                </button>
									</div>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="ligne">
	                        <div class="form-group">
	                            <div class="col-md-12 col-md-offset-4">
	                                <a class="btn btn-link colonne gauche btn-width-50" href="{{ url('/password/reset') }}"><i class="fa fa-external-link"></i> &nbsp;#txtMDPOublie#</a>
	                                <a class="btn btn-link colonne droite btn-width-50" href="{{ url('inscription') }}"><i class="fa fa-plus-square-o"></i> &nbsp;#txtSinscrire#</a>
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
