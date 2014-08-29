@extends('layouts.master')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.tax_rates') }}
		</h1>
		<div class="pull-right">
			<a href="{{ route('taxRates.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('fi.new') }}</a>
		</div>
		<div class="clearfix"></div>
	</section>

	<section class="content">

		@include('layouts._alerts')

		<div class="row">

			<div class="col-xs-12">

				<div class="box box-primary">

					<div class="box-body table-responsive no-padding">
						<table class="table table-hover">

							<thead>
								<tr>
									<th>{{ trans('fi.tax_rate_name') }}</th>
									<th>{{ trans('fi.tax_rate_percent') }}</th>
									<th>{{ trans('fi.options') }}</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($taxRates as $taxRate)
								<tr>
									<td>{{ $taxRate->name }}</td>
									<td>{{ $taxRate->formatted_percent }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('taxRates.edit', array($taxRate->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a> 
											<a href="{{ route('taxRates.delete', array($taxRate->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>

						</table>
					</div>

				</div>

				<div class="pull-right">
					{{ $taxRates->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop