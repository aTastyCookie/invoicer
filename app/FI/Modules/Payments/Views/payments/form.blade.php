@extends('layouts.master')

@section('jscript')

@include('layouts._datemask')
<script src="{{ asset('js/FI/payment_form.js') }}" type="text/javascript"></script>

@stop

@section('content')

@if ($editMode == true)
{{ Form::model($payment, array('route' => array('payments.update', $payment->id, $payment->invoice_id), 'class' => 'form-horizontal')) }}
@else
{{ Form::open(array('route' => 'payments.store', 'class' => 'form-horizontal')) }}
@endif

{{ Form::hidden('invoice_id') }}

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.payment_form') }}
		</h1>
		<div class="pull-right">
			{{ Form::submit(trans('fi.save'), array('class' => 'btn btn-primary')) }}
		</div>
		<div class="clearfix"></div>
	</section>

	<section class="content">

		@include('layouts._alerts')

		<div class="row">

			<div class="col-md-12">

				<div class="box box-primary">
					
					<div class="box-body">

						<div class="form-group">
							<label>{{ trans('fi.amount') }}: </label>
							{{ Form::text('amount', $payment->formatted_numeric_amount, array('id' => 'amount', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.payment_date') }}: </label>
							{{ Form::text('paid_at', $payment->formatted_paid_at, array('id' => 'paid_at', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.payment_method') }}</label>
							{{ Form::select('payment_method_id', $paymentMethods, null, array('id' => 'payment_method_id', 'class' => 'form-control')) }}
						</div>

						<div class="form-group">
							<label>{{ trans('fi.note') }}</label>
							{{ Form::textarea('note', null, array('id' => 'note', 'class' => 'form-control')) }}
						</div>

						@if ($customFields->count())
						@include('custom_fields._custom_fields')
						@endif

					</div>

				</div>

			</div>

		</div>

	</section>

</aside>
{{ Form::close() }}
@stop