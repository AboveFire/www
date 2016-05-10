@extends('layouts.app')
@section('title')
{{ trans('pagination.nom') }}
@endsection
@section('content')
<div class="container container-paswd">
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/form.css') }}"></link>
@if (session('status'))
<div class="alert alert-success">
	{{ session('status') }}
</div>
@endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">#titrePaswdReset#</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="token" value="{{ $token }}">
						<div class="ligne">
	                        <div class="form-group{{ $errors->has('uti_courl') ? ' has-error' : '' }}">
	                            <div class="col-md-12">
                                <input type="email" class="form-control" name="uti_courl" value="{{ $email or old('uti_courl') }}" placeholder="#champCourl#">

                                @if ($errors->has('uti_courl'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('uti_courl') }}</strong>
                                    </span>
                                @endif
	                            </div>
	                        </div>
						</div>
						<div class="ligne">
	                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
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
						<div class="ligne">
	                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	                            <div class="col-md-12">
	                                <input type="password" class="form-control" name="password_confirmation" placeholder="#champConfirm#">
	
	                                @if ($errors->has('password_confirmation'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
						</div>
						<div class="ligne">
	                        <div class="form-group">
	                            <div class="col-md-12 col-md-offset-4">
		                            <div class="zoneBtn">
                                <button type="submit" class="butn btn-width-100">
                                    <i class="fa fa-btn fa-refresh"></i>Reset Password
                                </button>
									</div>
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
