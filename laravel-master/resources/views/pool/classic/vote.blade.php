@extends('layouts.app')
@section('title')
{{ trans('pagination.formClassic') }}
@endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/pool_vote_classic.css') }}"></link>

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
                <form class="form" role="form" method="POST" action="" enctype="multipart/form-data">
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
								<img id="p{{$games[$i]->PARTIE}}[{{$games[$i]->PARTIE_EQUIPE_HOME}}]" name="p{{$games[$i]->PARTIE}}[{{$games[$i]->PARTIE_EQUIPE_HOME}}]" 
									 src="{{{ asset('images/teams/' . $games[$i]->EQUIPE1 . '.png') }}}" alt="{{$games[$i]->EQUIPE1}}" class="col-md-4 image image-gauche p{{$games[$i]->PARTIE}}" 
									 @if (!isset($games[$i]->VOTED) || $games[$i]->VOTED == 'N') onclick="select(this);" @endif>
								<div class="col-md-4 date-cote">
									<div class="col-md-12">
									{{substr($games[$i]->DATE, 0, strlen($games[$i]->DATE) - 3)}}
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
								<img id="p{{$games[$i]->PARTIE}}[{{$games[$i]->PARTIE_EQUIPE_VISITEUR}}]" name="p{{$games[$i]->PARTIE}}[{{$games[$i]->PARTIE_EQUIPE_VISITEUR}}]"
								 src="{{{ asset('images/teams/' . $games[$i]->EQUIPE2 . '.png') }}}" alt="{{$games[$i]->EQUIPE2}}" class="col-md-4 image image-droite p{{$games[$i]->PARTIE}}" 
								 @if (!isset($games[$i]->VOTED) || $games[$i]->VOTED == 'N') onclick="select(this);" @endif>
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
							<button type="button" onclick="voter(this);" class="butn btn-width-100 has-spinner">
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
$(document).ready( function() {
	$('#selectPool').change(function() {
		window.location= "{{ url('/voteClassic') }}?poolCourant=" + $('#selectPool').val();
	});
	$('#select_week').change(function() {
		window.location= "{{ url('/voteClassic') }}?poolCourant=" + $('#selectPool').val() + "&semaineCourante=" + $('#select_week').val();
	});

	@foreach ($games as $game)
		@if (isset($game->VOTED))
			$('#p{{$game->PARTIE}}\\[{{$game->VOTED}}\\]').addClass('selected');
		@endif
	@endforeach
});

function select(elemn) {
	partie = elemn.id.substring(1, elemn.id.indexOf("["));
	team = elemn.id.substring(elemn.id.indexOf("[") + 1, elemn.id.indexOf("]"));
	$('.p' + partie).removeClass('selected');
	$(elemn).addClass('selected');
}

function voter (butn) {
	countTotal = $('.image-droite').length;
	countSelect = $('.selected').length;
	var $this = $(butn);
	if (countTotal != countSelect && false)
	{
		alert (countSelect + '/' + countTotal); 
	}
	else
	{    
		$this.toggleClass('active');
				
		listeSelect = JSON.stringify($( ".selected" ).map(function() { return this.id; }).get());
		console.log(listeSelect);

		$.post('vote', {action: 'submit', typePool: 'poolClassic', poolCourant: <?=$poolCourant?> , semaineCourante: <?=$semaineCourante?> , _token:tokenMobile, votes: listeSelect}, function(data){
			$(document.body).html(data);
			window.scrollTo(0,0); 
			$this.toggleClass('active');
		});
	}
}
</script>
@endsection
