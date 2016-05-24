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
				<select id="#selectCoulr" class="form-control" name="pool">
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
					<i class="fa fa-btn fa-save"></i>{{ trans('pool.butn_inscr') }}
				</button>
			</div>
		</div>
	</div>
	<div class="milieu">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Age</th>
						<th>City</th>
						<th>Country</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>Anna</td>
						<td>Pitt</td>
						<td>35</td>
						<td>New York</td>
						<td>USA</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
