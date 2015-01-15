@extends('client_center.layouts.master')

@section('sidebar')

<ul class="sidebar-menu">
    <li>
        <a href="{{ route('clientCenter.quote.pdf', array($quote->url_key)) }}" target="_blank">
            <i class="fa fa-print"></i> {{ trans('fi.download_pdf') }}
        </a>
    </li>
    @if (in_array($quote->status_text, array('draft', 'sent')))
    <li>
        <a href="{{ route('clientCenter.quote.approve', array($quote->url_key)) }}" onclick="return confirm('{{ trans('fi.confirm_approve_quote') }}');">
            <i class="fa fa-thumbs-up"></i> {{ trans('fi.approve') }}
        </a>
    </li>
    <li>
        <a href="{{ route('clientCenter.quote.reject', array($quote->url_key)) }}" onclick="return confirm('{{ trans('fi.confirm_reject_quote') }}');">
            <i class="fa fa-thumbs-down"></i> {{ trans('fi.reject') }}
        </a>
    </li>
    @endif
</ul>

@stop

@section('content')

<aside class="right-side">

	<section class="content-header">
		<h1 class="pull-left">{{ trans('fi.quote') }} #{{{ $quote->number }}}</h1>

		@if ($quote->status_text == 'approved')
		<span style="margin-left: 10px;" class="label label-success">{{ trans('fi.approved') }}</span>
		@elseif ($quote->status_text == 'rejected')
		<span style="margin-left: 10px;" class="label label-danger">{{ trans('fi.rejected') }}</span>
		@else
		<span style="margin-left: 10px;" class="label label-default">{{ trans('fi.action_required') }}</span>
		@endif
	</section>

    <div class="row" style="height: 100%; background-color: #e6e6e6; padding: 25px; margin: 0px;">
        <div class="col-sm-8 col-sm-offset-2" style="background-color: white;">
            <iframe src="{{ route('clientCenter.quote.html', array($urlKey)) }}" frameborder="0" style="width: 100%;" scrolling="no" onload="javascript:resizeIframe(this, 1000);"></iframe>
        </div>
    </div>

</aside>

@stop