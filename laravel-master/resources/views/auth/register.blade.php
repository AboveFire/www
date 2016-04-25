@extends('layouts.app')
@section('title', 'Live Pool')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

						<div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">#nom#</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nom" value="{{ old('nom') }}">

                                @if ($errors->has('nom'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('prenm') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">#prenm#</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="prenm" value="{{ old('prenm') }}">

                                @if ($errors->has('prenm'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prenm') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">#code#</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}">

                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('courl') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">#courl#</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="courl" value="{{ old('courl') }}">

                                @if ($errors->has('courl'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('courl') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('paswd') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">#paswd#</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="paswd">

                                @if ($errors->has('paswd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paswd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('paswd_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">#paswd_confirmation#</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="paswd_confirmation">

                                @if ($errors->has('paswd_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('paswd_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                         <i class="fa fa-btn fa-user"></i>S'inscrire
                                </button>
                                <a class="btn btn-link" href="{{ url('/') }}"><i class="fa fa-sign-in"></i> &nbsp;Déjà Inscrit?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
