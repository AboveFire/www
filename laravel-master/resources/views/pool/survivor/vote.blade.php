@extends('layouts.app')
@section('title')
{{ trans('pagination.formSurvivor') }}
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
										@if ($sema->SEM_NUMR == $semaineCourante)
								    <option value="{{$sema->SEM_NUMR}}" selected>{{ $sema->SEM_NUMR }}</option>
										@else
								    <option value="{{$sema->SEM_NUMR}}">{{$sema->SEM_NUMR }}</option>
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
						@foreach($games as $game)
							<div class="box-container col-md-6 text-center">
								<img onclick="voter(this);" id="p{{$game->PARTIE}}[{{$game->EQUIPE1}}]" src="{{{ asset('images/teams/' . $game->EQUIPE1 . '.png') }}}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="col-md-4 image image-gauche p{{$game->PARTIE}}">
								<div class="col-md-4 date-cote">
									<div class="col-md-12">
									{{substr($game->DATE, 0, strlen($game->DATE) - 3)}}
									</div>
									<div class="col-md-12">
									(
										@if($game->COTE != null)
											{{$game->COTE}}
										@else
											-
										@endif
								    )
									</div>
								</div>
								<img onclick="voter(this);" id="p{{$game->PARTIE}}[{{$game->EQUIPE2}}]" src="{{{ asset('images/teams/' . $game->EQUIPE2 . '.png') }}}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="col-md-4 image image-droite p{{$game->PARTIE}}">
							</div>
						@endforeach
					</div>
					<div class="clearfix"></div>
                    <!-- Zone de boutons -->
                    <hr>
					<div class="form-group">
						<div class="col-md-6 col-butn">
							<button onclick="resetChoice(this);setMessage('{{ trans('general.success') }}');" type="button" class="butn btn-width-100 has-spinner">
								<i class="fa fa-btn fa-times"></i>{{ trans('general.butn_cancel') }} &nbsp;
    						<span class="spinner"><i class="fa fa-big fa-spin fa-refresh"></i></span>
							</button>
						</div>
						<div class="col-md-6 col-butn">
							<button onclick="send(this);" type="button" class="butn btn-width-100 has-spinner">
							<i class="fa fa-btn fa-save"></i>{{ trans('general.butn_save') }} &nbsp;
    						<span class="spinner"><i class="fa fa-big fa-spin fa-refresh"></i></span>
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
var partie;
var team;
var disabled;

$(document).ready( function() {
	$('#selectPool').change(function() {
		window.location= "{{ url('/voteSurvivor') }}?poolCourant=" + $('#selectPool').val();
	});
	$('#select_week').change(function() {
		window.location= "{{ url('/voteSurvivor') }}?poolCourant=" + $('#selectPool').val() + "&semaineCourante=" + $('#select_week').val();
	});
	resetChoice();

	if ( (new Date("{{$games[0]->DATE}}")).getTime() < (new Date()).getTime()){
		disabled = true;
	}
});
function voter(elemn) {
	if (!disabled){
		partie = elemn.id.substring(1, elemn.id.indexOf("["));
		team = elemn.id.substring(elemn.id.indexOf("[") + 1, elemn.id.indexOf("]"));
		$('.image').removeClass('selected');
		$('.image').removeClass('selectedBD');
		$(elemn).addClass('selected');
	}
}
function send(elemn){
	if($('.selected')[0] != undefined){
		$(elemn).addClass('active');
		$.post("vote", {poolCourant: {{ $poolCourant }}, partie: partie, team: team, semaine: {{ $semaineCourante }}, _token:tokenMobile}, function(data){
			$(elemn).removeClass('active');
			window.scrollTo(0,0);
			if(data == "time"){
				setMessage("{{ trans('pool.err_vote_survivor2') }}", "error");
			}else if(data == "success"){
				setMessage("{{ trans('general.success') }}");
			}else{
				setMessage("{{ trans('pool.err_vote_survivor3') }}", "error");
			}
		});
	}else{
		setMessage("{{ trans('pool.err_vote_survivor') }}", "error");
		window.scrollTo(0,0);
	}
}
function resetChoice(elemn){
	$(elemn).addClass('active');
	$.post("getChoicesPerWeek", {poolCourant: {{ $poolCourant }}, semaine: {{ $semaineCourante }}, _token:tokenMobile}, function(data){
		$temp = JSON.parse(data);
		if($temp[0] != undefined){
			$('.image').removeClass('selected');
			$('.image').removeClass('selectedBD');
			$("#p" + $temp[0]["PARTIE"] + "\\[" + $temp[0]["CODE"] + "\\]").addClass("selected");
			$("#p" + $temp[0]["PARTIE"] + "\\[" + $temp[0]["CODE"] + "\\]").addClass("selectedBD");
			partie = $temp[0]["PARTIE"];
			team = $temp[0]["CODE"];
		}
		window.scrollTo(0,0);
		$(elemn).removeClass('active');
	});
}

function setMessage(message,type){
	if(type == "error"){
		$retour = "<div class=\"alert alert-danger\">" + message + "</div>";
	}else{
		$retour = "<div class=\"alert alert-success\">" + message + "</div>";
	}
	$(".alert-success").remove();
	$(".alert-danger").remove();
	$(".container").prepend($retour);
}
</script>
@endsection
