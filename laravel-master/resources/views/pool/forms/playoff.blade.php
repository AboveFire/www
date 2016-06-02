@extends('layouts.app')
@section('title')
{{ trans('pagination.formPlayoff') }}
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading sous-titre"></div>
                <div class="panel-body">
                    <!-- Liste déroulante -->
	                <div class="col-md-4">
					<div class="margin-bottom-sm input-group">
						<span class="input-group-addon"><i class="fa fa-crosshairs fa-fw" aria-hidden="true"></i></span>
						<select id="selectPool" class="form-control" name="pool">
							<option disabled>{{ trans('pool.select_pool') }}</option>
								@foreach($pools as $pool)
									@if ($pool->POO_SEQNC == $poolCourant)
							    <option value="{{$pool->POO_SEQNC}}" selected>{{ $pool->POO_NOM }}</option>
									@else
							    <option value="{{$pool->POO_SEQNC}}">{{ $pool->POO_NOM }}</option>
								    @endif
								@endforeach
						</select>
					</div>
						@if($errors->has('pool')) 
						<span class="help-block"> 
							<strong>{{$errors->first('pool') }}</strong>
						</span> 
						@endif
					</div>
					<div class="clearfix"></div>
					<hr>
                    <!-- Zone d'affichage -->
                    <div class="tableau form-group">
						<!-- Team Members Row -->
						<?php for($i = 1; $i <= 11; $i++) {?>
							<div class="col-md-4 text-center">
								<img src="{{ Auth::user()->getImage() }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="col-md-12 image">
								
							</div>
						<?php }?>
						<div class="clearfix"></div>
					</div>
                    <!-- Zone de boutons -->
                    <form class="form" role="form" method="POST" action="{{ url('') }}" enctype="multipart/form-data">
                    <hr>
					<div class="form-group">
						<div class="col-md-6 col-butn">
							<button onclick="location.href='{{ url('/results-playoff') }}'" type="button" class="butn btn-width-100">
								<i class="fa fa-btn fa-times"></i>{{ trans('general.butn_cancel') }}
							</button>
						</div>
						<div class="col-md-6 col-butn">
							<button type="submit" class="butn btn-width-100">
							<i class="fa fa-btn fa-save"></i>{{ trans('general.butn_save') }}
						</button>
						</div>
					</div>
				</form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
