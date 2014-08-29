<script type="text/javascript">

    Stripe.setPublishableKey('{{ Config::get('payments.merchants.Stripe.apiKey') }}');

    var stripeResponseHandler = function(status, response) {
        var $form = $('#payment-form');
        if (response.error) {
            $form.find('#modal-status-placeholder').text(response.error.message);
            $form.find('input[type="submit"]').prop('disabled', false);
        } else {
            var token = response.id;
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            $form.get(0).submit();
        }
    };

    $(function()
    {
        $('#modal-cc-payment').modal('show');

        $('#payment-form').submit(function(e) {
            var $form = $(this);
            $form.find('input[type="submit"]').prop('disabled', true);
            Stripe.card.createToken($form, stripeResponseHandler);
            return false;
        });
    });
</script>

<div class="modal fade" id="modal-cc-payment">
    <form action="{{ route('merchant.invoice.payCc', array($invoice->url_key)) }}" method="POST" class="form-horizontal" id="payment-form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{ trans('fi.pay_now') }} ({{ $invoice->amount->formatted_converted_balance }})</h4>
                </div>
                <div class="modal-body">

                    <div id="modal-status-placeholder"></div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.card_number') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" data-stripe="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.cvc') }}</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" data-stripe="cvc" placeholder="CVC">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.expiration') }} (MM/YYYY)</label>
                        <div class="col-sm-2" style="padding-right: 5px;">
                            <input type="text" class="form-control" data-stripe="exp-month" placeholder="MM">
                        </div>
                        <div class="col-sm-3" style="padding-left: 5px;">
                            <input type="text" class="form-control" data-stripe="exp-year" placeholder="YYYY">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                    <input type="submit" id="invoice-pay-confirm" class="btn btn-primary" value="{{ trans('fi.pay_now') }} ({{ $invoice->amount->formatted_converted_balance }})">
                </div>
            </div>
        </div>
    </form>
</div>