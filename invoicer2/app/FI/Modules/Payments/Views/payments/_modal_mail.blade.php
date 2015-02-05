<script type="text/javascript">
    var mailPaymentRoute = '{{ route('payments.ajax.mailPayment') }}';
    var paymentId        = {{ $paymentId }};
    var sending          = '{{ trans('fi.sending') }}';
    var sent             = '{{ trans('fi.sent') }}';
    var redirectTo       = '{{ $redirectTo }}';
</script>

<script src="{{ asset('js/FI/payment_mail.js') }}" type="text/javascript"></script>

<div class="modal fade" id="modal-mail-payment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('fi.email_payment_receipt') }}</h4>
            </div>
            <div class="modal-body">

                <div id="modal-status-placeholder"></div>

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.to') }}</label>
                        <div class="col-sm-9">
                            {{ Form::text('to', $to, array('id' => 'to', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.cc') }}</label>
                        <div class="col-sm-9">
                            {{ Form::text('cc', $cc, array('id' => 'cc', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.subject') }}</label>
                        <div class="col-sm-9">
                            {{ Form::text('subject', $subject, array('id' => 'subject', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.body') }}</label>
                        <div class="col-sm-9">
                            {{ Form::textarea('body', $body, array('id' => 'body', 'class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('fi.attach_pdf') }}</label>
                        <div class="col-sm-9">
                            {{ Form::checkbox('attach_pdf', 1, Config::get('fi.attachPdf'), array('id' => 'attach_pdf')) }}
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                <button type="button" id="btn-submit-mail-payment" class="btn btn-primary">{{ trans('fi.send') }}</button>
            </div>
        </div>
    </div>
</div>