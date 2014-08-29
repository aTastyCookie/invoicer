@extends('layouts.master')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.payment_methods') }}
		</h1>
		<div class="pull-right">
			<a href="{{ route('paymentMethods.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('fi.new') }}</a>
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
									<th>{{ trans('fi.payment_method') }}</th>
									<th>{{ trans('fi.options') }}</th>
								</tr>
							</thead>

							<tbody>
								@foreach ($paymentMethods as $paymentMethod)
								<tr>
									<td>{{ $paymentMethod->name }}</td>
									<td>
										<div class="btn-group">
											<a href="{{ route('paymentMethods.edit', array($paymentMethod->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.edit') }}"><i class="fa fa-edit"></i></a> 
											<a href="{{ route('paymentMethods.delete', array($paymentMethod->id)) }}" class="btn btn-sm btn-default" title="{{ trans('fi.delete') }}" onclick="return confirm('{{ trans('fi.delete_record_warning') }}');"><i class="fa fa-trash-o"></i></a> 
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>

						</table>
					</div>

				</div>

				<div class="pull-right">
					{{ $paymentMethods->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop