<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ Config::get('fi.headerTitleText') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/client-center.css') }}" rel="stylesheet" type="text/css" />

    @yield('head')

</head>
<body class="skin-blue fixed">

    <header class="header">
        <a href="#" class="logo">{{ Config::get('fi.headerTitleText') }}</a>
        <nav class="navbar navbar-static-top" role="navigation">

            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
	
        </nav>
    </header>

    <div class="wrapper row-offcanvas row-offcanvas-left">

        <aside class="left-side sidebar-offcanvas">                

            <section class="sidebar">

                @yield('sidebar')

            </section>

        </aside>

        @yield('content')

    </div>

    <div id="modal-placeholder"></div>

    <script src="{{ asset('js/jquery-2.0.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-ui-1.10.3.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/FI/global.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/FI/app.js') }}" type="text/javascript"></script>

    @yield('jscript')

</body>
</html>