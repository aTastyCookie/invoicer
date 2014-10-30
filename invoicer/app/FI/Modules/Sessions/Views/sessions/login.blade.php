<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>{{ trans('fi.welcome') }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link href="{{ asset('favicon.png') }}" rel="icon" type="image/png">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />

        <link href='{{ $protocol }}://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,300italic,400italic,600italic' rel='stylesheet' type='text/css'>
       
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">{{ trans('fi.login') }}</div>
            {{ Form::open(array('route' => 'session.login')) }}
                <div class="body bg-gray">
                    <div class="form-group">
                        {{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => trans('fi.email'))) }}
                    </div>
                    <div class="form-group">
                        {{ Form::password('password', array('id' => 'password', 'class' => 'form-control', 'placeholder' => trans('fi.password'))) }}
                    </div>          
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-blue btn-block">{{ trans('fi.login') }}</button>  
                </div>
            {{ Form::close() }}

        </div>

        <script src="{{ asset('js/jquery-2.0.2.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>        

        <script type="text/javascript">
            $(function() { $('#email').focus(); });
        </script>

    </body>
</html>
