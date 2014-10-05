@extends('layouts.master')

@section('sidebar_top')
<form method="get" action="{{ route('clients.index') }}" class="sidebar-form">
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
			{{ trans('fi.clients') }}
		</h1>
		<div class="pull-right">
			<a href="{{ route('clients.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('fi.new') }}</a>
		</div>

		<div class="pull-right" style="margin-right: 20px;">
			<ul class="nav nav-pills">
				<li @if ($status == 'active') class="active" @endif><a href="{{ route('clients.index') }}?status=active">{{ trans('fi.active') }}</a></li>
				<li @if ($status == 'inactive') class="active" @endif><a href="{{ route('clients.index') }}?status=inactive">{{ trans('fi.inactive') }}</a></li>
                <li @if ($status == 'all') class="active" @endif><a href="{{ route('clients.index') }}">{{ trans('fi.all') }}</a></li>
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
						@include('clients._table')
					</div>

				</div>

				<div class="pull-right">
					{{ $clients->links() }}
				</div>

			</div>
			
		</div>

	</section>

</aside>
@stop