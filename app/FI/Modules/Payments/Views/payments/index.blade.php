@extends('layouts.master')

@section('sidebar_top')
<form method="get" action="{{ route('payments.index') }}" class="sidebar-form">
	<div class="input-group">
		<input type="text" name="search" class="form-control" placeholder="{{ trans('fi.search') }}..."/>
		<span class="input-group-btn">
		<button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
		</span>
	</div>
</form>
@stop

@section('jscript')
<script type="text/javascript">

	$(function() {

		$('.mail-payment-receipt').click(function() {
			$('#modal-placeholder').load("{{ route('payments.ajax.modalMailPayment') }}", { 
				payment_id: $(this).data('payment-id'),
				redirectTo: $(this).data('redirect-to')
			});
		});

	});

</script>
@stop

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1>
			{{ trans('fi.payments') }}
		</h1>
	</section>

	<section class="content">

		@include('layouts._alerts')

		<div class="row">

			<div class="col-xs-12">

				<div class="box box-primary">

					<div class="box-body table-responsive no-padding">
						@include('payments._table')
					</div>

				</div>

				<div class="pull-right">
					{{ $payments->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop