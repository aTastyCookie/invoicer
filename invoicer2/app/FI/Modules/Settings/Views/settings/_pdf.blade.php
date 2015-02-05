@section('jscript')
@parent
<script type="text/javascript">
    $(function() {

        updatePDFOptions();

        $('#pdfDriver').change(function() {
            updatePDFOptions();
        });

        function updatePDFOptions() {

            $('.wkhtmltopdf-option').hide();

            pdfDriver = $('#pdfDriver').val();

            if (pdfDriver == 'wkhtmltopdf') {
                $('.wkhtmltopdf-option').show();
            }
        }

    });
</script>
@stop

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('fi.paper_size') }}: </label>
            {{ Form::select('setting_paperSize', $paperSizes, Config::get('fi.paperSize'), array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('fi.paper_orientation') }}: </label>
            {{ Form::select('setting_paperOrientation', $paperOrientations, Config::get('fi.paperOrientation'), array('class' => 'form-control')) }}
        </div>
    </div>

</div>

<div class="form-group">
    <label>{{ trans('fi.pdf_driver') }}: </label>
    {{ Form::select('setting_pdfDriver', $pdfDrivers, Config::get('fi.pdfDriver'), array('id' => 'pdfDriver', 'class' => 'form-control')) }}
</div>

<div class="form-group wkhtmltopdf-option">
    <label>{{ trans('fi.binary_path') }}: </label>
    {{ Form::text('setting_pdfBinaryPath', Config::get('fi.pdfBinaryPath'), array('class' => 'form-control')) }}
</div>