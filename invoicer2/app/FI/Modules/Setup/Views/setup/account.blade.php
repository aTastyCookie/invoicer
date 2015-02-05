@extends('layouts.empty')

@section('content')

<aside class="right-side">                

    <section class="content-header">
        <h1>{{ trans('fi.account_setup') }}</h1>
    </section>

    <section class="content">

        {{ Form::open(array('route' => 'setup.postAccount', 'class' => 'form-install')) }}

        <div class="row">

            <div class="col-md-12">

                <div class="box box-primary">

                    <div class="box-body">

                        @foreach ($errors->all('<div class="alert alert-danger">:message</div>') as $error)
                        {{ $error }}
                        @endforeach

                        <p>{{ trans('fi.step_about_yourself') }}</p>

                        <div class="row">

                            <div class="col-md-6 form-group">
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => trans('fi.name'))) }}
                            </div>

                            <div class="col-md-6 form-group">
                                {{ Form::text('company', null, array('class' => 'form-control', 'placeholder' => trans('fi.company'))) }}
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                {{ Form::textarea('address', null, array('class' => 'form-control', 'placeholder' => trans('fi.address'), 'rows' => 4)) }}
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-3 form-group">
                                {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => trans('fi.phone'))) }}
                            </div>

                            <div class="col-md-3 form-group">
                                {{ Form::text('mobile', null, array('class' => 'form-control', 'placeholder' => trans('fi.mobile'))) }}
                            </div>

                            <div class="col-md-3 form-group">
                                {{ Form::text('fax', null, array('class' => 'form-control', 'placeholder' => trans('fi.fax'))) }}
                            </div>

                            <div class="col-md-3 form-group">
                                {{ Form::text('web', null, array('class' => 'form-control', 'placeholder' => trans('fi.web'))) }}
                            </div>

                        </div>

                        <p>{{ trans('fi.step_create_account') }}</p>

                        <div class="row">

                            <div class="col-md-4 form-group">
                                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => trans('fi.email'))) }}
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('fi.password'))) }}
                            </div>

                            <div class="col-md-4 form-group">
                                {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => trans('fi.password_confirmation'))) }}
                            </div>

                        </div>

                        <button class="btn btn-primary" type="submit">{{ trans('fi.continue') }}</button>

                    </div>

                </div>

            </div>

        </div>

        {{ Form::close() }}

    </section>

</aside>
@stop