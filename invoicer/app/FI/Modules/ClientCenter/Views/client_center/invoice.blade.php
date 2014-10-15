@extends('client_center.layouts.master')

@section('jscript')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function()
{
	$('#btn-direct-payment').click(function()
	{
		$('#modal-placeholder').load("{{ route('merchant.invoice.modalCc', array($invoice->url_key)) }}", {
			urlKey: $(this).data('url-key')
		});
	});
});
</script>
@stop

@section('sidebar')

<div class="buttons">
	<a href="{{ route('clientCenter.invoice.pdf', array($invoice->url_key)) }}" class="btn btn-primary" target="_blank">
		<span>{{ trans('fi.download_pdf') }}</span>
	</a>

	@if (Config::get('payments.enabled') and $invoice->amount->balance > 0)
	@if ($merchantIsRedirect)
	<a href="{{ route('merchant.invoice.pay', array($invoice->url_key)) }}" class="btn btn-success">
	@else
	<a href="javascript:void(0)" class="btn btn-success" id="btn-direct-payment" data-url-key="{{ $invoice->url_key }}">	
	@endif
		<span>{{ trans('fi.pay_now') }}</span>
	</a>
	@endif

</div>

@stop

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1>{{ trans('fi.invoice') }} #{{ $invoice->number }}</h1>
	</section>

	<div class="row" style="height: 100%; background-color: #cccccc; padding: 25px;">
		<div class="col-lg-8 col-lg-offset-2" style="height: 1200px; background-color: white;">
			<iframe src="{{ route('clientCenter.invoice.html', array($urlKey)) }}" frameborder="0" height="100%" width="100%"></iframe>
		</div>
	</div>

</aside>

@stop