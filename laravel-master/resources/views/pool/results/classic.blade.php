@extends('layouts.app') @section('title') {{ trans('pagination.poolClassic') }} @endsection
@section('content')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('css/pool.css') }}"></link>
<?php
$typePool = trans ( 'pagination.poolClassic' );
?>
<br />
<div class="container">
	@if (session('status'))
	<div class="alert alert-success">{{ session('status') }}</div>
	@endif
	<div class="form-inline">
		<p class="col-md-12">{{ trans('pool.text_nonInscr',['pool' => $typePool]) }}</p>
		<br />
		<div class="form-group">
			<div class="col-md-12">
				<select id="selectPool" class="form-control" name="pool">
					<option selected disabled>{{ trans('pool.select_pool') }}</option>
					<option id="red" value="red">{{ trans('param.rouge') }}</option>
					<option id="cyan" value="cyan">{{ trans('param.cyan') }}</option>
					<option id="blue" value="blue">{{ trans('param.bleu') }}</option>
				</select>
			</div>
		</div>
		<div class="form-group form-butn">
			<div class="col-md-2">
				<button type="submit" class="butn">
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
					<tr>
						<td>Samuel Foisy</td>
						<td>132</td>
						<td>1</td>
					</tr>
					<tr>
						<td>Olivier Parent</td>
						<td>100</td>
						<td>2</td>
					</tr>
					<tr>
						<td>Samuel Dansereau</td>
						<td>85</td>
						<td>3</td>
					</tr>
					<tr>
						<td>Simon Côté</td>
						<td>67</td>
						<td>4</td>
					</tr>
					<tr>
						<td>Robert Aubé</td>
						<td>75</td>
						<td>5</td>
					</tr>
					<tr>
						<td>Bob</td>
						<td>56</td>
						<td>6</td>
					</tr>
					<tr>
						<td>Bobinette</td>
						<td>27</td>
						<td>7</td>
					</tr>
					<tr>
						<td>Anna</td>
						<td>22</td>
						<td>8</td>
					</tr>
					<tr>
						<td>Roger</td>
						<td>21</td>
						<td>9</td>
					</tr>
					<tr>
						<td>Robert</td>
						<td>10</td>
						<td>10</td>
					</tr>
					<tr>
						<td>Richard</td>
						<td>2</td>
						<td>11</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="parties col-md-6">
			<div class="precedente">
			<h2>Parties prédedentes</h2>
				<div class="images">
					<div class="image col-md-2">
						<img src="{{ Auth::user()->getImage() }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="imgD">
					</div>
					<div class="image col-md-2">
						<img src="{{ Auth::user()->getImage() }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="imgG">
					</div>
				</div>
			</div>
			<div class="suivante">
			<h2>Parties suivantes</h2>
				<div class="images">
					<div class="image col-md-2">
						<img src="{{ Auth::user()->getImage() }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="imgD">
					</div>
					<div class="image col-md-2">
						<img src="{{ Auth::user()->getImage() }}" onerror="this.src='{{{ asset('images/profile.png') }}}'" alt="image" class="imgG">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready( function() {
	$('#selectPool').change(function() {
		location.href = '#';
	});
});
</script>
@endsection
