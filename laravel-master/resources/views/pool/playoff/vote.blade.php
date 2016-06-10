@extends('layouts.app')
@section('title')
{{ trans('pagination.formPlayoff') }}
@endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/pool_vote.css') }}"></link>
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">
		{{ trans(session('status')) }}
	</div>
	@endif
	@if (session('error'))
	<div class="alert alert-danger">
		{{ session('error') }}
	</div>
	@endif
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading sous-titre"></div>
                <div class="panel-body">
                <form class="form" role="form" method="POST" action="{{ url('/vote') }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
				<input type="hidden" name="poolCourant" value="<?=$poolCourant?>"> 
                    <!-- Liste déroulante -->
	                <div class="col-md-4 list-container">
					<div class="margin-bottom-sm input-group">
						<span class="input-group-addon"><i class="fa fa-crosshairs fa-fw" aria-hidden="true"></i></span>
						<select id="selectPool" class="form-control" name="pool">
							<option disabled>{{ trans('pool.select_pool') }}</option>
								@foreach($pools as $pool)
								    <option value="{{$pool->POO_SEQNC}}" 
								    @if ($pool->POO_SEQNC == $poolCourant) 
								    selected
								    @endif
								    >{{ $pool->POO_NOM }}</option>
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
						@if (sizeof($teams) == 0)
						<span class="mesgCentre">{{trans('pool.noPlayoff')}}</span>
						@endif
						@for ($i = 0; $i < sizeof($teams); $i++)
							<div class="box-container col-md-4 text-center">
								<img src="{{{ asset('images/teams/' . $teams[$i]->EQP_CODE . '.png') }}}" alt="$teams[$i]->EQP_CODE" class="col-md-6 image">
								<div class="col-md-4">
									<select class="selectMultp form-control" name="multp<?=$i+1?>">
										<option disabled>{{ trans('pool.select_multp') }}</option>
										<option id="multp<?=$i?>x1" value="1">x1</option>
									  	<option id="multp<?=$i?>x2" value="2">x2</option>
									  	<option id="multp<?=$i?>x3" value="3">x3</option>
									  	<option id="multp<?=$i?>x4" value="4">x4</option>
									  	<option id="multp<?=$i?>x5" value="5">x5</option>
									  	<option id="multp<?=$i?>x6" value="6">x6</option>
									</select>
								</div>
							</div>
						@endfor
						<div class="clearfix"></div>
					</div>
                    <!-- Zone de boutons -->
                    <hr>
					<div class="form-group">
						@if ((sizeof($teams) > 0))
                    	@if ($voteActif)
						<div class="col-md-6 col-butn">
							<button onclick="location.href='{{ url('/votePlayoff') }}?poolCourant=<?=$poolCourant?>'" type="button" class="butn btn-width-100">
								<i class="fa fa-btn fa-times"></i>{{ trans('general.butn_cancel') }}
							</button>
						</div>
						<div class="col-md-6 col-butn">
							<button type="submit" class="butn btn-width-100">
							<i class="fa fa-btn fa-save"></i>{{ trans('general.butn_save') }}
						</button>
						</div>
						@else
						<div id="butnResetVotes" class="col-md-6 col-butn">
							<button  type="button" onclick="resetVotes(this);" class="butn btn-width-100 has-spinner">
							<i class="fa fa-btn fa-undo"></i>{{ trans('pool.butn_reset_vote') }} &nbsp;
    						<span class="spinner"><i class="fa fa-spin fa-refresh"></i></span>
						</button>
						</div>
						@endif
						@endif
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
		window.location= "{{ url('/votePlayoff') }}?poolCourant=" + $('#selectPool').val();
	});
});
<?php 
for ($i = 0; $i < sizeof($teams); $i++)
{
	if (!$voteActif)
	{
		echo '$(\'.selectMultp\').attr("disabled", "disabled");';
		if ($teams[$i]->VOT_MULTP != null)
		{
			echo '$(\'#multp' . $i  . 'x' . $teams[$i]->VOT_MULTP . '\').attr("selected", "selected");';
		}
	}
}
?>

function resetVotes (butn) {
	var $this = $(butn);
	$this.addClass('active');

	$.post('resetVotes', {action: 'submit', typePool: 'poolPlayoff', poolCourant: <?=$poolCourant?> ,  _token:tokenMobile}, function(data){
		$(document.body).html(data);
		window.scrollTo(0,0); 
		$this.removeClass('active');
	});
}
</script>
@endsection
