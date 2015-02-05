@include('layouts._datemask')
@include('layouts._typeahead')

<script type="text/javascript">
    var storeInvoiceRoute = '{{ route('invoices.store') }}';
    var createInvoiceReturnUrl = '{{ url('invoices') }}';
</script>

<script src="{{ asset('js/FI/client_lookup.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/FI/invoice_create.js') }}" type="text/javascript"></script>

<div class="modal fade" id="create-invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('fi.create_invoice') }}</h4>
            </div>
            <div class="modal-body">

                <div id="modal-status-placeholder"></div>

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.client') }}</label>

                        <div class="col-sm-9">
                            {{ Form::text('client_name', null, array('id' => 'create_client_name', 'class' =>
                            'form-control client-lookup', 'autocomplete' => 'off')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.invoice_date') }}</label>

                        <div class="col-sm-9">
                            {{ Form::text('created_at', date(Config::get('fi.dateFormat')), array('id' =>
                            'create_created_at', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.group') }}</label>

                        <div class="col-sm-9">
                            {{ Form::select('invoice_group_id', $invoiceGroups, Config::get('fi.invoiceGroup'),
                            array('id' => 'create_invoice_group_id', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.frequency') }}</label>

                        <div class="col-sm-9">
                            <label class="radio">
                                {{ Form::radio('recurring', '0', true) }}
                                {{ trans('fi.one_time') }}
                            </label>
                            <label class="radio">
                                {{ Form::radio('recurring', '1') }}
                                {{ trans('fi.recurring') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="div-recurring-options" style="display: none;">
                        <label class="col-sm-3 control-label">{{ trans('fi.every') }}</label>

                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-3">
                                    {{ Form::text('recurring_frequency', '1', array('id' => 'recurring_frequency',
                                    'class' => 'form-control')) }}
                                </div>
                                <div class="col-sm-9">
                                    {{ Form::select('recurring_period', $frequencies, 3, array('id' =>
                                    'recurring_period', 'class' => 'form-control')) }}
                                </div>
                            </div>

                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                <button type="button" id="invoice-create-confirm" class="btn btn-primary">{{ trans('fi.submit') }}
                </button>
            </div>
        </div>
    </div>
</div>