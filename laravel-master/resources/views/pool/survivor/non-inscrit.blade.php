@extends('layouts.app') 
@section('title') 
	{{ trans('pagination.poolSurvivor') }} 
@endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/pool.css') }}"></link>
<br />
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">{{ session('status') }}</div>
	@endif
	@if ($poolCourant == null)
	<p class="col-md-12">{{ trans('pool.text_aucunPool',['pool' => trans('pagination.poolSurvivor')]) }}</p>
	@else
	<div class="form-inline">
		<p class="col-md-12">
			{{ trans('pool.welcome') }}!
			<br />
			{{ trans('pool.text_nonInscr',['pool' => trans('pagination.poolSurvivor')]) }}</p>
		<br />
		<div class="form-group butn-list-nin col-md-6">
			<div class="col-md-12">
				<div class="margin-bottom-sm input-group liste-pools">
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
		</div>
		<div class="form-group butn-inscr-nin col-md-6">
			<div class="col-md-12">
				<button type="submit" class="butn" onClick="inscrire();">
					<i class="fa fa-btn fa-plus"></i>{{ trans('pool.butn_inscr') }}
				</button>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="milieu">
		<div class="table-responsive col-md-6">
			<h2 class="aliveTitle">{{ trans('pool.alive') }}</h2>
			<hr class="aliveTitle">
			<table class="table">
				<thead>
					<tr>
						<th>{{ trans('general.user') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($scores as $key => $score)
						@if ($score["week"] == -1)
							@if ($score["seqnc"] == Auth::user()->UTI_SEQNC)
							<tr class="user_courant">
							@else
							<tr>
							@endif
								<td>{{ $score["code"] }}</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
			<h2 class="deadTitle">{{ trans('pool.dead') }}</h2>
			<hr class="deadTitle">
			<table class="table">
				<thead>
					<tr>
						<th>{{ trans('general.user') }}</th>
						<th>{{ trans('pool.rank') }}</th>
					</tr>
				</thead>
				<tbody>
					<?php $counter = 1 ?>
					@foreach($scores as $key => $score)
						@if ($score["week"] != -1)
							@if ($score["seqnc"] == Auth::user()->UTI_SEQNC)
							<tr class="user_courant">
							@else
							<tr>
							@endif
								<td>{{ $score["code"] }}</td>
								<td>{{ $counter }}</td>
							</tr>
							<?php $counter++ ?>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="parties col-md-6">
			@if ($partie_precd != null)
			<div class="precedente col-md-12">
				<h2>{{ trans ('pool.partiePrec') }}</h2>
					<div class="images">
					<div class="image col-md-6">
						<img src="{{ $partie_precd['imageHome'] }}" alt="image" class="{{ $partie_precd['classHome'] }}">
					</div>
					<div class="image col-md-6">
						<img src="{{ $partie_precd['imageVisitor'] }}" alt="image" class="{{ $partie_precd['classVisitor'] }}">
					</div>
				</div>
			</div>
			@endif
			@if ($partie_suivt != null)
			<div class="suivante col-md-12">
				<h2>{{ trans ('pool.partieSuiv') }}</h2>
				<div class="images">
					<div class="image col-md-6">
						<img src="{{ $partie_suivt['imageHome'] }}" alt="image" class="imgEven">
					</div>
					<div class="image col-md-6">
						<img src="{{ $partie_suivt['imageVisitor'] }}" alt="image" class="imgEven">
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
	@endif
</div>

<script type="text/javascript">
var tokenMobile = "{{ csrf_token() }}";
$(document).ready( function() {
	$('#selectPool').change(function() {
		window.location= "{{ url('/poolSurvivor') }}?poolCourant=" + $('#selectPool').val();
	});
});

function inscrire() {
	$.post('inscription', {action: 'send', typePool: 'poolSurvivor', poolCourant: <?=$poolCourant?> , _token:tokenMobile}, function(data){
		window.location = "{{ url('/poolSurvivor?poolCourant=' . $poolCourant) }}";
	});
}
</script>
@endsection
