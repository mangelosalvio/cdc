<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>HOME</title>

    <!-- Bootstrap -->
    <!-- Bootstrap -->
    {!! HTML::style('css/bootstrap.min.css') !!}
    {!! HTML::style('css/style.index.css') !!}
    {!! HTML::style('css/bootstrap-timepicker.min.css') !!}

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {!! HTML::script('js/jquery-1.11.2.min.js') !!}
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {!! HTML::script('js/bootstrap.min.js') !!}
    {!! HTML::script('js/bootstrap-timepicker.min.js') !!}
</head>
<body>
<div class="container">
@yield('body')
</div>
</body>
</html>