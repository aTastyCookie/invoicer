<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ Config::get('fi.headerTitleText') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="{{ asset('favicon.png') }}" rel="icon" type="image/png">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />

    <link href='{{ $protocol }}://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,300italic,400italic,600italic' rel='stylesheet' type='text/css'>

    @yield('head')

</head>
<body class="skin-blue fixed">

    <header class="header">
        <a href="{{ route('dashboard.index') }}" class="logo">{{ Config::get('fi.headerTitleText') }}</a>

        <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

            <div class="navbar-right">
                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="{{ trans('fi.system') }}">
                            <i class="fa fa-cog"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('currencies.index') }}">{{ trans('fi.currencies') }}</a></li>
                            <li><a href="{{ route('customFields.index') }}">{{ trans('fi.custom_fields') }}</a></li>
                            <li><a href="{{ route('invoiceGroups.index') }}">{{ trans('fi.groups') }}</a></li>
                            <li><a href="{{ route('import.index') }}">{{ trans('fi.import_data') }}</a></li>
                            <li><a href="{{ route('itemLookups.index') }}">{{ trans('fi.item_lookups') }}</a></li>
                            <li><a href="{{ route('paymentMethods.index') }}">{{ trans('fi.payment_methods') }}</a></li>
                            <li><a href="{{ route('taxRates.index') }}">{{ trans('fi.tax_rates') }}</a></li>
                            <li><a href="{{ route('users.index') }}">{{ trans('fi.user_accounts') }}</a></li>
                            <li><a href="{{ route('settings.index') }}">{{ trans('fi.system_settings') }}</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ route('session.logout') }}" title="{{ trans('fi.logout') }}">
                            <i class="fa fa-power-off"></i>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">

        <aside class="left-side sidebar-offcanvas">                

            <section class="sidebar">

                @yield('sidebar_top')

                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('dashboard.index') }}">
                            <i class="fa fa-dashboard"></i> <span>{{ trans('fi.dashboard') }}</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>{{ trans('fi.clients') }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('clients.create') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.add_client') }}</a></li>
                            <li><a href="{{ route('clients.index') }}?status=active"><i class="fa fa-angle-double-right"></i> {{ trans('fi.view_clients') }}</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text-o"></i>
                            <span>{{ trans('fi.quotes') }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="javascript:void(0)" class="create-quote"><i class="fa fa-angle-double-right"></i> {{ trans('fi.create_quote') }}</a></li>
                            <li><a href="{{ route('quotes.index') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.view_quotes') }}</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text"></i>
                            <span>{{ trans('fi.invoices') }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="javascript:void(0)" class="create-invoice"><i class="fa fa-angle-double-right"></i> {{ trans('fi.create_invoice') }}</a></li>
                            <li><a href="{{ route('invoices.index') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.view_invoices') }}</a></li>
                            <li><a href="{{ route('recurring.index') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.view_recurring_invoices') }}</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-credit-card"></i>
                            <span>{{ trans('fi.payments') }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('payments.index') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.view_payments') }}</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-bar-chart-o"></i>
                            <span>{{ trans('fi.reports') }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('reports.itemSales') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.item_sales') }}</a></li>
                            <li><a href="{{ route('reports.paymentsCollected') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.payments_collected') }}</a></li>
                            <li><a href="{{ route('reports.revenueByClient') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.revenue_by_client') }}</a></li>
                            <li><a href="{{ route('reports.taxSummary') }}"><i class="fa fa-angle-double-right"></i> {{ trans('fi.tax_summary') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </section>

        </aside>

        @yield('content')

    </div>

    <div id="modal-placeholder"></div>

    <script type="text/javascript">
        var createQuoteModalRoute   = '{{ route('quotes.ajax.modalCreate') }}';
        var emailQuoteModalRoute    = '{{ route('quotes.ajax.modalMailQuote') }}';
        var createInvoiceModalRoute = '{{ route('invoices.ajax.modalCreate') }}';
        var emailInvoiceModalRoute  = '{{ route('invoices.ajax.modalMailInvoice') }}';
        var enterPaymentRoute       = '{{ route('payments.ajax.modalEnterPayment') }}';
        var datepickerFormat        = '{{ Config::get('fi.datepickerFormat') }}';
        var unknownError            = '{{ trans('fi.unknown_error') }}';
    </script>

    <script src="{{ asset('js/jquery-2.0.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-ui-1.10.3.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/FI/global.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/FI/app.js') }}" type="text/javascript"></script>

    @section('jscript')
    @show

</body>
</html>