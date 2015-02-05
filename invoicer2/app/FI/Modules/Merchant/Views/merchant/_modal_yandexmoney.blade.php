YANDEX MONEY TEST

<script type="text/javascript">


    $(function()
    {
        $('#modal-cc-payment').modal('show');

       
    });
</script>

<div class="modal fade" id="modal-cc-payment">
    <form action="{{ route('merchant.invoice.payCc', array($invoice->url_key)) }}" method="POST" class="form-horizontal" id="payment-form">
		<input type="hidden" name="client" value="<?php echo $invoice->client->id; ?>" />
		<input type="hidden" name="id" value="<?php echo $invoice->id; ?>" />
		<input type="hidden" name="number" value="<?php echo $invoice->number; ?>" />

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">{{ trans('fi.pay_now') }} ({{ $invoice->amount->formatted_balance }})</h4>
                </div>
                <div class="modal-body">

                    <div id="modal-status-placeholder"></div>

                    <div class="form-group">
					    <label>{{ trans('fi.payment_method') }}:</label>
                        <div>
                           <select class="form-control" name="method">
								<?php 
									if (Config::get('payments.merchants.YandexMoney.method_pc')){
										echo '<option value="PC">электронная валюта Яндекс.Деньги</option>';
									}
									if (Config::get('payments.merchants.YandexMoney.method_ac')){
										echo '<option value="AC">банковская карта VISA, MasterCard, Maestro</option>';
									}
									if (Config::get('payments.merchants.YandexMoney.method_gp')){
											echo '<option value="GP">наличными в кассах и терминалах партнеров</option>';
									}
									if (Config::get('payments.merchants.YandexMoney.method_mc')){
											echo '<option value="MC">оплата со счета мобильного телефона</option>';
									}
									if (Config::get('payments.merchants.YandexMoney.method_wm')){
											echo '<option value="WM">электронная валюта WebMoney</option>';
									}

								?>
						   </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('fi.cancel') }}</button>
                    <input type="submit" id="invoice-pay-confirm" class="btn btn-primary" value="{{ trans('fi.pay_now') }} ({{ $invoice->amount->formatted_balance }})">
                </div>
            </div>
        </div>
    </form>
</div>