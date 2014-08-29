@extends('layouts.master')

@section('sidebar_top')
<form method="get" action="{{ route('invoices.index') }}" class="sidebar-form">
	<div class="input-group">
		<input type="text" name="search" class="form-control" placeholder="{{ trans('fi.search') }}..."/>
		<span class="input-group-btn">
			<button type='submit' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
		</span>
	</div>
</form>
@stop

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1 class="pull-left">
			{{ trans('fi.invoices') }}
		</h1>

		<div class="pull-right">
			<a href="javascript:void(0)" class="btn btn-primary create-invoice"><i class="fa fa-plus"></i> {{ trans('fi.new') }}</a>
		</div>

		<div class="pull-right" style="margin-right: 20px;">
			<ul class="nav nav-pills">
				@foreach ($statuses as $liStatus)
				<li @if ($status == $liStatus) class="active" @endif><a href="{{ route('invoices.index') }}?status={{ $liStatus }}">{{ trans('fi.' . $liStatus) }}</a></li>
				@endforeach
				<li @if ($status == 'overdue') class="active" @endif><a href="{{ route('invoices.index') }}?status=overdue">{{ trans('fi.overdue') }}</a></li>
			</ul>
		</div>

		<div class="clearfix"></div>
	</section>

	<section class="content">

		@include('layouts._alerts')

		<div class="row">

			<div class="col-xs-12">

				<div class="box box-primary">

					<div class="box-body table-responsive no-padding">
						@include('invoices._table')
					</div>

				</div>

				<div class="pull-right">
					{{ $invoices->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop