@extends('client_center.layouts.master')

@section('sidebar')

<div class="buttons">
	<a href="{{ route('clientCenter.quote.pdf', array($quote->url_key)) }}" class="btn btn-primary" target="_blank">
		<i class="fa fa-print"></i> {{ trans('fi.download_pdf') }}
	</a>
	@if (in_array($quote->status_text, array('draft', 'sent')))
	<a href="{{ route('clientCenter.quote.approve', array($quote->url_key)) }}" class="btn btn-success" onclick="return confirm('{{ trans('fi.confirm_approve_quote') }}');">
		<i class="fa fa-thumbs-up"></i> {{ trans('fi.approve') }}
	</a>
	<a href="{{ route('clientCenter.quote.reject', array($quote->url_key)) }}" class="btn btn-danger" onclick="return confirm('{{ trans('fi.confirm_reject_quote') }}');">
		<i class="fa fa-thumbs-down"></i> {{ trans('fi.reject') }}
	</a>
	@endif
</div>

@stop

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">{{ trans('fi.quote') }} #{{ $quote->number }}</h1>

		@if ($quote->status_text == 'approved')
		<span style="margin-left: 10px;" class="label label-success">{{ trans('fi.approved') }}</span>
		@elseif ($quote->status_text == 'rejected')
		<span style="margin-left: 10px;" class="label label-danger">{{ trans('fi.rejected') }}</span>
		@else
		<span style="margin-left: 10px;" class="label label-default">{{ trans('fi.action_required') }}</span>
		@endif
	</section>

	<div class="row" style="height: 100%; background-color: #cccccc; padding: 25px;">
		<div class="col-lg-8 col-lg-offset-2" style="height: 1200px; background-color: white;">
			<iframe src="{{ route('clientCenter.quote.html', array($urlKey)) }}" frameborder="0" height="100%" width="100%"></iframe>
		</div>
	</div>

</aside>

@stop