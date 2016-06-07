@extends('layouts.app')
@section('title')
{{ trans('pagination.formClassic') }}
@endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/pool_vote_classic.css') }}"></link>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading sous-titre"></div>
                <div class="panel-body">
                <form class="form" role="form" method="POST" action="{{ url('') }}" enctype="multipart/form-data">
                    <!-- Liste déroulante -->
	                <div class="col-md-4 liste-gauche list-container">
						<div class="margin-bottom-sm input-group">
							<span class="input-group-addon"><i class="fa fa-gamepad fa-fw" aria-hidden="true"></i></span>
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
					</div>
					<div class="col-md-4 liste-droite list-container">
						<div class="margin-bottom-sm input-group">
							<span class="input-group-addon"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i></span>
							<select id="select_week" class="form-control" name="week">
								<option disabled>{{ trans('pool.select_week') }}</option>
									@foreach($semas as $sema)
										@if (true)
								    <option value="{{$sema->SEM_NUMR}}" selected>{{ $sema->SEM_NUMR }}</option>
										@else
								    <option value="{{$sema->SEM_NUMR}}">{{ $pool->SEM_NUMR }}</option>
									    @endif
									@endforeach
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
					<hr>
                    <!-- Zone d'affichage --> 
                    <div class="tableau form-group">
						<!-- Team Members Row -->
						@foreach($teams as $team)
							<div class="box-container col-md-6 text-center">
								<img src="{{{ asset('images/teams/' . $team->EQP_CODE . '.png') }}}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="col-md-4 image image-gauche">
								<div class="col-md-4 date-cote">
									<div class="col-md-12">
									2016-01-01
									</div>
									<div class="col-md-12">
									(1234)
									</div>
								</div>
								<img src="{{{ asset('images/teams/' . $team->EQP_CODE . '.png') }}}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="col-md-4 image image-droite">
							</div>
						@endforeach
						<div class="clearfix"></div>
					</div>
                    <!-- Zone de boutons -->
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


<script type="text/javascript">
var tokenMobile = "{{ csrf_token() }}";
$(document).ready( function() {
	$('#selectPool').change(function() {
		window.location= "{{ url('/poolPlayoff') }}?poolCourant=" + $('#selectPool').val();
	});
});

function voter() {
	window.location= "{{ url('/votePlayoff') }}?poolCourant=" + <?=$poolCourant?>;
}
</script>
@endsection
