@extends('layouts.empty')

@section('content')

<aside class="right-side">                

	<section class="content-header">
		<h1>{{ trans('fi.installation_complete') }}</h1>
	</section>

	<section class="content">

		<div class="row">

			<div class="col-md-12">

				<div class="box box-primary">
					
					<div class="box-body">

						<p>{{ trans('fi.you_may_now_log_in') }}!</p>

						<a href="{{ route('session.login') }}" class="btn btn-primary">{{ trans('fi.login') }}</a>

					</div>

				</div>

			</div>

		</div>

	</section>

</aside>
@stop