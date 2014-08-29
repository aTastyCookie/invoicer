@extends('layouts.master')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1>
			{{ trans('fi.recurring_invoices') }}
		</h1>

	</section>

	<section class="content">

		<div class="row">

			<div class="col-xs-12">

				<div class="box box-primary">

					<div class="box-body table-responsive no-padding">

						<table class="table table-hover">

							<thead>
								<tr>
									<th>{{ trans('fi.base_invoice') }}</th>
									<th>{{ trans('fi.client') }}</th>
									<th>{{ trans('fi.start_date') }}</th>
									<th>{{ trans('fi.end_date') }}</th>
									<th>{{ trans('fi.every') }}</th>
									<th>{{ trans('fi.next_date') }}</th>
									<th>{{ trans('fi.options') }}</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($recurringInvoices as $recurringInvoice)
								<tr>
									<td><a href="{{ route('invoices.edit', array($recurringInvoice->invoice_id)) }}">{{ $recurringInvoice->invoice->number }}</a></td>
									<td><a href="{{ route('clients.show', array($recurringInvoice->invoice->client_id)) }}">{{ $recurringInvoice->invoice->client->name }}</a></td>
									<td>{{ $recurringInvoice->invoice->formattedCreatedAt }}</td>
									<td></td>
									<td>{{ $recurringInvoice->recurring_frequency . ' ' . $frequencies[$recurringInvoice->recurring_period] }}</td>
									<td>{{ $recurringInvoice->formattedGenerateAt }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('recurring.delete', array($recurringInvoice->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>

						</table>

					</div>

				</div>

				<div class="pull-right">
					{{ $recurringInvoices->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop