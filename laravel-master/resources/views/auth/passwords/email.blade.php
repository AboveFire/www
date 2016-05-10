@extends('layouts.app')
@section('title')
{{ trans('pagination.nom') }}
@endsection
<!-- Main Content -->
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/form.css') }}"></link>
<div class="container container-paswd">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('pagination.resetMdp') }}</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {!! csrf_field() !!}
						<div class="ligne">
	                        <div class="form-group{{ $errors->has('uti_courl') ? ' has-error' : '' }}">
	                            <div class="col-md-12">
	                                <input type="email" class="form-control" name="uti_courl" value="{{ old('uti_courl') }}" placeholder="{{ trans('auth.courl') }}">
	
	                                @if ($errors->has('uti_courl'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('uti_courl') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
						</div>
						<div class="ligne">
	                        <div class="form-group">
	                            <div class="col-md-12 col-md-offset-4">
		                            <div class="zoneBtn">
                                <button type="submit" class="btn-width-50 butn">
                                    <i class="fa fa-btn fa-envelope"></i>{{ trans('general.butn_send') }}
                                </button>
                                 <button onclick="location.href='{{ url('/') }}'" type="button" class="btn-width-50 butn">
                                    <i class="fa fa-btn fa-times"></i>{{ trans('general.butn_cancel') }}
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
