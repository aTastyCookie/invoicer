@section('jscript')
@parent
<script type="text/javascript">
    $(function() {

        $('#mailPassword').val('');

        updateEmailOptions();

        $('#mailDriver').change(function() {
            updateEmailOptions();
        });

        function updateEmailOptions() {

            $('.email-option').hide();

            mailDriver = $('#mailDriver').val();

            if (mailDriver == 'smtp') {
                $('.smtp-option').show();
            }
            else if (mailDriver == 'sendmail') {
                $('.sendmail-option').show();
            }
            else if (mailDriver == 'mail') {
                $('.phpmail-option').show();
            }
        }

    });
</script>
@stop

<div class="form-group">
  <label>{{ trans('fi.email_send_method') }}: </label>
  {{ Form::select('setting_mailDriver', $emailSendMethods, Config::get('fi.mailDriver'), array('id' => 'mailDriver', 'class' => 'form-control')) }}
</div>

<div class="form-group smtp-option email-option">
    <label>{{ trans('fi.smtp_host_address') }}: </label>
    {{ Form::text('setting_mailHost', Config::get('fi.mailHost'), array('class' => 'form-control')) }}
</div>

<div class="form-group smtp-option email-option">
    <label>{{ trans('fi.smtp_host_port') }}: </label>
    {{ Form::text('setting_mailPort', Config::get('fi.mailPort'), array('class' => 'form-control')) }}
</div>

<div class="form-group smtp-option email-option">
    <label>{{ trans('fi.smtp_username') }}: </label>
    {{ Form::text('setting_mailUsername', Config::get('fi.mailUsername'), array('class' => 'form-control')) }}
</div>

<div class="form-group smtp-option email-option">
    <label>{{ trans('fi.smtp_password') }}: </label>
    {{ Form::password('setting_mailPassword', array('id' => 'mailPassword', 'class' => 'form-control')) }}
</div>

<div class="form-group smtp-option email-option">
    <label>{{ trans('fi.smtp_encryption_type') }}: </label>
    {{ Form::select('setting_mailEncryption', $emailEncryptions, Config::get('fi.mailEncryption'), array('class' => 'form-control')) }}
</div>

<div class="form-group sendmail-option email-option">
    <label>{{ trans('fi.sendmail_path') }}: </label>
    {{ Form::text('setting_mailSendmail', Config::get('fi.mailSendmail'), array('class' => 'form-control')) }}
</div>

<div class="form-group smtp-option sendmail-option phpmail-option email-option">
  <label>{{ trans('fi.attach_pdf_outgoing_email') }}: </label>
  {{ Form::select('setting_attachPdf', $yesNoArray, Config::get('fi.attachPdf'), array('id' => 'attachPdf', 'class' => 'form-control')) }}
</div>

<div class="form-group smtp-option sendmail-option phpmail-option email-option">
    <label>{{ trans('fi.automatic_cc') }}: </label>
    {{ Form::text('setting_mailDefaultCc', Config::get('fi.mailDefaultCc'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    <label>{{ trans('fi.default_quote_email_body') }}: </label>
    {{ Form::textarea('setting_quoteEmailBody', Config::get('fi.quoteEmailBody'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    <label>{{ trans('fi.default_invoice_email_body') }}: </label>
    {{ Form::textarea('setting_invoiceEmailBody', Config::get('fi.invoiceEmailBody'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    <label>{{ trans('fi.default_overdue_invoice_email_body') }}: </label>
    {{ Form::textarea('setting_overdueInvoiceEmailBody', Config::get('fi.overdueInvoiceEmailBody'), array('class' => 'form-control')) }}
</div>

<div class="form-group">
    <label>{{ trans('fi.default_payment_receipt_body') }}: </label>
    {{ Form::textarea('setting_paymentReceiptBody', Config::get('fi.paymentReceiptBody'), array('class' => 'form-control')) }}
</div>