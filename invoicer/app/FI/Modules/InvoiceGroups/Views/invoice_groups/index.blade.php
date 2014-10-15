@extends('layouts.master')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.groups') }}
		</h1>
		<div class="pull-right">
			<a href="{{ route('invoiceGroups.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('fi.new') }}</a>
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
									<th>{{ trans('fi.prefix') }}</th>
									<th>{{ trans('fi.next_id') }}</th>
									<th>{{ trans('fi.left_pad') }}</th>
									<th>{{ trans('fi.year_prefix') }}</th>
									<th>{{ trans('fi.month_prefix') }}</th>
									<th>{{ trans('fi.options') }}</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($invoiceGroups as $invoiceGroup)
								<tr>
									<td>{{ $invoiceGroup->name }}</td>
									<td>{{ $invoiceGroup->prefix }}</td>
									<td>{{ $invoiceGroup->next_id }}</td>
									<td>{{ $invoiceGroup->left_pad }}</td>
									<td>{{ ($invoiceGroup->prefix_year) ? trans('fi.yes') : trans('fi.no') }}</td>
									<td>{{ ($invoiceGroup->prefix_month) ? trans('fi.yes') : trans('fi.no') }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('invoiceGroups.edit', array($invoiceGroup->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a> 
											<a href="{{ route('invoiceGroups.delete', array($invoiceGroup->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>

						</table>
					</div>

				</div>

				<div class="pull-right">
					{{ $invoiceGroups->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop