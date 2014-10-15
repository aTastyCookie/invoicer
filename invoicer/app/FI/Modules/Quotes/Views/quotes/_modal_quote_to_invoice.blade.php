@include('layouts._datemask')

<script type="text/javascript">
    var quoteToInvoiceRoute = '{{ route('quotes.ajax.quoteToInvoice') }}';
    var userId              = {{ $user_id }};
    var quoteId             = {{ $quote_id }};
    var clientId            = {{ $client_id }};
</script>

<script src="{{ asset('js/FI/quote_to_invoice.js') }}" type="text/javascript"></script>

<div class="modal fade" id="modal-quote-to-invoice">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('fi.quote_to_invoice') }}</h4>
            </div>
            <div class="modal-body">

                <div id="modal-status-placeholder"></div>

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.invoice_date') }}</label>
                        <div class="col-sm-9">
                            {{ Form::text('created_at', $created_at, array('id' => 'to_invoice_created_at', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.group') }}</label>
                        <div class="col-sm-9">
                            {{ Form::select('invoice_group_id', $invoiceGroups, Config::get('fi.invoiceGroup'), array('id' => 'to_invoice_invoice_group_id', 'class' => 'form-control')) }}
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                <button type="button" id="btn-quote-to-invoice-submit" class="btn btn-primary">{{ trans('fi.submit') }}</button>
            </div>
        </div>
    </div>
</div>