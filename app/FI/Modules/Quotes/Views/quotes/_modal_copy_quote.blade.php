<script type="text/javascript">
    var clientNameLookupRoute = '{{ route('clients.ajax.nameLookup') }}';
    var copyQuoteRoute        = '{{ route('quotes.ajax.copyQuote') }}';
    var userId                = {{ $user_id }};
    var copyQuoteReturnUrl    = '{{ url('quotes') }}';
</script>

<script src="{{ asset('js/FI/quote_copy.js') }}" type="text/javascript"></script>

<div class="modal fade" id="modal-copy-quote">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('fi.copy_quote') }}</h4>
            </div>
            <div class="modal-body">

                <div id="modal-status-placeholder"></div>

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.client') }}</label>
                        <div class="col-sm-9">
                            {{ Form::text('client_name', $quote->client->name, array('id' => 'copy_client_name', 'class' => 'form-control client-lookup', 'autocomplete' => 'off')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.quote_date') }}</label>
                        <div class="col-sm-9">
                            {{ Form::text('created_at', date(Config::get('fi.dateFormat')), array('id' => 'copy_created_at', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.group') }}</label>
                        <div class="col-sm-9">
                            {{ Form::select('invoice_group_id', $invoiceGroups, $quote->invoice_group_id, array('id' => 'copy_invoice_group_id', 'class' => 'form-control')) }}
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                <button type="button" id="btn-copy-quote-submit" class="btn btn-primary">{{ trans('fi.submit') }}</button>
            </div>
        </div>
    </div>
</div>