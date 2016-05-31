@extends('layouts.app') 
@section('title') 
	{{ trans('pagination.' . $typePool) }} 
@endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/pool.css') }}"></link>
<br />
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">{{ session('status') }}</div>
	@endif
	@if ($poolCourant == null)
	<p class="col-md-12">{{ trans('pool.text_aucunPool',['pool' => trans('pagination.' . $typePool)]) }}</p>
	@else
	<div class="form-inline">
		<p class="col-md-12">{{ trans('pool.text_nonInscr',['pool' => trans('pagination.' . $typePool)]) }}</p>
		<br />
		<div class="form-group">
			<div class="col-md-12">
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
		<div class="form-group form-butn">
			<div class="col-md-2">
				<button type="submit" class="butn" onClick="inscrire();">
					<i class="fa fa-btn fa-plus"></i>{{ trans('pool.butn_inscr') }}
				</button>
			</div>
		</div>
	</div>
	<div class="milieu">
		<div class="table-responsive col-md-6">
			<table class="table">
				<thead>
					<tr>
						<th>{{ trans('general.user') }}</th>
						<th>{{ trans('pool.label_score') }}</th>
						<th>{{ trans('pool.rank') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($scores as $score)
						@if ($score["utils"] == Auth::user()->UTI_SEQNC)
						<tr class="user_courant">
						@else
						<tr>
						@endif
							<td>{{ $score["nom"] }}</td>
							<td>{{ $score["score"] }}</td>
							<td>{{ $score["rang"] }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="parties col-md-6">
			@if ($partie_precd != null)
			<div class="precedente">
				<h2>{{ trans ('pool.partiePrec') }}</h2>
				<div class="images">
					<div class="image col-md-2">
						<img src="{{ $partie_precd['image2'] }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="imgWin">
					</div>
					<div class="image col-md-2">
						<img src="{{ $partie_precd['image1'] }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="imgLose">
					</div>
				</div>
			</div>
			@endif
			@if ($partie_suivt != null)
			<div class="suivante">
				<h2>{{ trans ('pool.partieSuiv') }}</h2>
				<div class="images">
					<div class="image col-md-2">
						<img src="{{ $partie_suivt['image2'] }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="imgEven">
					</div>
					<div class="image col-md-2">
						<img src="{{ $partie_suivt['image1'] }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="imgEven">
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
		location.href = '#';
	});
});

function inscrire() {
	$.post('inscription', {action: 'send', typePool: 'poolClassic', poolCourant: <?=$poolCourant?> , _token:tokenMobile}, function(data){
		window.location = "{{ url('/poolClassic') }}";
	});
}

function proceed () {
    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', "{{ url('/inscription') }}");
    form.style.display = 'hidden';
    $('<input>').attr({
        type: 'hidden',
        id: 'poolCourant',
        name: 'poolCourant',
        value: <?=$poolCourant?>
    }).appendTo('form');

    $('<input>').attr({
        type: 'hidden',
        id: '_token',
        name: '_token',
        value: "{{ csrf_token() }}"
    }).appendTo('form');
    
    alert (form);
    document.body.appendChild(form)
    
    form.submit();
}
</script>
@endsection
