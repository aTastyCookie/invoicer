@extends('layouts.master')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.custom_fields') }}
		</h1>
		<div class="pull-right">
			<a href="{{ route('customFields.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('fi.new') }}</a>
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
									<th>{{ trans('fi.table_name') }}</th>
									<th>{{ trans('fi.column_name') }}</th>
									<th>{{ trans('fi.field_label') }}</th>
									<th>{{ trans('fi.field_type') }}</th>
									<th>{{ trans('fi.options') }}</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($customFields as $customField)
								<tr>
									<td>{{ $tableNames[$customField->table_name] }}</td>
									<td>{{ $customField->column_name }}</td>
									<td>{{ $customField->field_label }}</td>
									<td>{{ $customField->field_type }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('customFields.edit', array($customField->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a> 
											<a href="{{ route('customFields.delete', array($customField->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>

						</table>
					</div>

				</div>

				<div class="pull-right">
					{{ $customFields->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop