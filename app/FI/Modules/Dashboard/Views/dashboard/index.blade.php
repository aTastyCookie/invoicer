@extends('layouts.master')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1>{{ trans('fi.dashboard') }}</h1>
	</section>

	<section class="content">

		@include('layouts._alerts')

		<div class="row">

			<div class="col-lg-6">

				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">{{ trans('fi.invoice_summary') }}</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-6">

								<div class="small-box bg-yellow">
									<div class="inner">
										<h3>{{ $invoicesTotalDraft }}</h3>
										<p>{{ trans('fi.draft_invoices') }}</p>
									</div>
									<div class="icon"><i class="ion ion-edit"></i></div>
									<a class="small-box-footer" href="{{ route('invoices.index') }}?status=draft">
										{{ trans('fi.view_draft_invoices') }} <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-sm-6">

								<div class="small-box bg-aqua">
									<div class="inner">
										<h3>{{ $invoicesTotalSent }}</h3>
										<p>{{ trans('fi.sent_invoices') }}</p>
									</div>
									<div class="icon"><i class="ion ion-share"></i></div>
									<a class="small-box-footer" href="{{ route('invoices.index') }}?status=sent">
										{{ trans('fi.view_sent_invoices') }} <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

						</div>

						<div class="row">

							<div class="col-sm-6">

								<div class="small-box bg-red">
									<div class="inner">
										<h3>{{ $invoicesTotalOverdue }}</h3>
										<p>{{ trans('fi.overdue_invoices') }}</p>
									</div>
									<div class="icon"><i class="ion ion-alert"></i></div>
									<a class="small-box-footer" href="{{ route('invoices.index') }}?status=overdue">
										{{ trans('fi.view_overdue_invoices') }} <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-sm-6">

								<div class="small-box bg-green">
									<div class="inner">
										<h3>{{ $invoicesTotalPaid }}</h3>
										<p>{{ trans('fi.payments_collected') }}</p>
									</div>
									<div class="icon"><i class="ion ion-heart"></i></div>
									<a class="small-box-footer" href="{{ route('payments.index') }}">
										{{ trans('fi.view_payments') }} <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="col-lg-6">

				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">{{ trans('fi.quote_summary') }}</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-sm-6">

								<div class="small-box bg-purple">
									<div class="inner">
										<h3>{{ $quotesTotalDraft }}</h3>
										<p>{{ trans('fi.draft_quotes') }}</p>
									</div>
									<div class="icon"><i class="ion ion-edit"></i></div>
									<a class="small-box-footer" href="{{ route('quotes.index') }}?status=draft">
										{{ trans('fi.view_draft_quotes') }} <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-sm-6">

								<div class="small-box bg-olive">
									<div class="inner">
										<h3>{{ $quotesTotalSent }}</h3>
										<p>{{ trans('fi.sent_quotes') }}</p>
									</div>
									<div class="icon"><i class="ion ion-share"></i></div>
									<a class="small-box-footer" href="{{ route('quotes.index') }}?status=sent">
										{{ trans('fi.view_sent_quotes') }} <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

						</div>

						<div class="row">

							<div class="col-sm-6">

								<div class="small-box bg-orange">
									<div class="inner">
										<h3>{{ $quotesTotalRejected }}</h3>
										<p>{{ trans('fi.rejected_quotes') }}</p>
									</div>
									<div class="icon"><i class="ion ion-thumbsdown"></i></div>
									<a class="small-box-footer" href="{{ route('quotes.index') }}?status=rejected">
										{{ trans('fi.view_rejected_quotes') }} <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>

							<div class="col-sm-6">

								<div class="small-box bg-blue">
									<div class="inner">
										<h3>{{ $quotesTotalApproved }}</h3>
										<p>{{ trans('fi.approved_quotes') }}</p>
									</div>
									<div class="icon"><i class="ion ion-thumbsup"></i></div>
									<a class="small-box-footer" href="{{ route('quotes.index') }}?status=approved">
										{{ trans('fi.view_approved_quotes') }} <i class="fa fa-arrow-circle-right"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>

		<div class="row">

			<div class="col-md-4">

				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">{{ trans('fi.recent_client_activity') }}</h3>
					</div>
					<div class="box-body no-padding">
						<table class="table table-striped">
							<tbody>
								<tr>
									<th>{{ trans('fi.date') }}</th>
									<th>{{ trans('fi.activity') }}</th>
								</tr>
								@foreach ($recentClientActivity as $activity)
								<tr>
									<td>{{ $activity->formatted_created_at }}</td>
									<td>{{ $activity->formatted_activity }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

			</div>

			<div class="col-md-8">


			</div>

		</div>

	</section>

</aside>
@stop