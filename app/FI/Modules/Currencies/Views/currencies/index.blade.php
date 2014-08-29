@extends('layouts.master')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.currencies') }}
		</h1>
		<div class="pull-right">
			<a href="{{ route('currencies.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('fi.new') }}</a>
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
									<th>{{ trans('fi.name') }}</th>
									<th>{{ trans('fi.code') }}</th>
									<th>{{ trans('fi.symbol') }}</th>
									<th>{{ trans('fi.symbol_placement') }}</th>
									<th>{{ trans('fi.options') }}</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($currencies as $currency)
								<tr>
									<td>{{ $currency->name }}</td>
									<td>{{ $currency->code }}</td>
									<td>{{ $currency->symbol }}</td>
									<td>{{ $currency->formatted_placement }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('currencies.edit', array($currency->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a> 
											<a href="{{ route('currencies.delete', array($currency->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>

						</table>
					</div>

				</div>

				<div class="pull-right">
					{{ $currencies->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop