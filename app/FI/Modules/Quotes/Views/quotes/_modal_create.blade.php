@include('layouts._datemask')
@include('layouts._typeahead')

<script type="text/javascript">
    var storeQuoteRoute = '{{ route('quotes.store') }}';
    var createQuoteReturnUrl = '{{ url('quotes') }}';
    var clientNameLookupRoute = '{{ route('clients.ajax.nameLookup') }}';
</script>

<script src="{{ asset('js/FI/quote_create.js') }}" type="text/javascript"></script>

<div class="modal fade" id="create-quote">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('fi.create_quote') }}</h4>
            </div>
            <div class="modal-body">

                <div id="modal-status-placeholder"></div>

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.client') }}</label>
                        <div class="col-sm-9">
                            {{ Form::text('client_name', null, array('id' => 'create_client_name', 'class' => 'form-control client-lookup', 'autocomplete' => 'off')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.quote_date') }}</label>
                        <div class="col-sm-9">
                            {{ Form::text('created_at', date(Config::get('fi.dateFormat')), array('id' => 'create_created_at', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.group') }}</label>
                        <div class="col-sm-9">
                            {{ Form::select('invoice_group_id', $invoiceGroups, Config::get('fi.quoteGroup'), array('id' => 'create_invoice_group_id', 'class' => 'form-control')) }}
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                <button type="button" id="quote-create-confirm" class="btn btn-primary">{{ trans('fi.submit') }}</button>
            </div>
        </div>
    </div>
</div>