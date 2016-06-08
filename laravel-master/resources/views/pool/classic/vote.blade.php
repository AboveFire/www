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
                <form class="form" role="form" method="POST" action="javascript:voter();" enctype="multipart/form-data">
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
						@for ($i = 0; $i < sizeof($games); $i++)
							<div class="box-container col-md-6 text-center">
								<img id="p{{$games[$i]->PARTIE}}[{{$games[$i]->EQUIPE1}}]" name="p{{$games[$i]->PARTIE}}[{{$games[$i]->EQUIPE1}}]" src="{{{ asset('images/teams/' . $games[$i]->EQUIPE1 . '.png') }}}" alt="{{$games[$i]->EQUIPE1}}" class="col-md-4 image image-gauche p{{$games[$i]->PARTIE}} selected" onclick="select(this);">
								<div class="col-md-4 date-cote">
									<div class="col-md-12">
									{{$games[$i]->DATE}}
									</div>
									<div class="col-md-12">
									(
										@if($games[$i]->COTE != null)
											{{$games[$i]->COTE}}
										@else
											-
										@endif
								    )
									</div>
								</div>
								<img id="p{{$games[$i]->PARTIE}}[{{$games[$i]->EQUIPE2}}]" name="p{{$games[$i]->PARTIE}}[{{$games[$i]->EQUIPE2}}]" src="{{{ asset('images/teams/' . $games[$i]->EQUIPE2 . '.png') }}}" alt="{{$games[$i]->EQUIPE2}}" class="col-md-4 image image-droite p{{$games[$i]->PARTIE}}" onclick="select(this);">
							</div>
						@endfor
					</div>
					<div class="clearfix"></div>
                    <!-- Zone de boutons -->
                    <hr>
					<div class="form-group">
						<div class="col-md-6 col-butn">
							<button onclick="location.href='{{ url('/voteClassic?poolCourant=' . $poolCourant) }}'" type="button" class="butn btn-width-100">
								<i class="fa fa-btn fa-times"></i>{{ trans('general.butn_cancel') }}
							</button>
						</div>
						<div class="col-md-6 col-butn">
							<button type="button" onclick="voter();" class="butn btn-width-100">
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
		window.location= "{{ url('/voteClassic') }}?poolCourant=" + $('#selectPool').val();
	});
	$('#select_week').change(function() {
		window.location= "{{ url('/voteClassic') }}?poolCourant=" + $('#selectPool').val() + "&semaineCourante=" + $('#select_week').val();
	});
});

function select(elemn) {
	partie = elemn.id.substring(1, elemn.id.indexOf("["));
	team = elemn.id.substring(elemn.id.indexOf("[") + 1, elemn.id.indexOf("]"));
	$('.p' + partie).removeClass('selected');
	$(elemn).addClass('selected');
}

function voter () {
	countTotal = $('.image-droite').length;
	countSelect = $('.selected').length;
	if (countTotal != countSelect)
	{
		alert (countSelect + '/' + countTotal); 
	}
	else
	{
		
		listeSelect = JSON.stringify($( ".selected" ).map(function() { return this.id; }).get());
		//console.log(listeSelect);

		$.post('vote', {action: 'submit', typePool: 'poolClassic', poolCourant: <?=$poolCourant?> , semaineCourante: <?=$semaineCourante?> , _token:tokenMobile, votes: listeSelect}, function(data){
			$(document.body).html(data);
		});
	}
}
</script>
@endsection
