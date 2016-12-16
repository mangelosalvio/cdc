<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>HOME</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {!! HTML::script('js/jquery-1.11.2.min.js') !!}


    <!-- Bootstrap -->
    {!! HTML::style('css/bootstrap.min.css') !!}
    {!! HTML::style('css/style.index.css') !!}
    {!! HTML::style('css/bootstrap-datepicker3.css') !!}
    {!! HTML::style('css/bootstrap-timepicker.min.css') !!}

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {!! HTML::script('js/bootstrap.min.js') !!}
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/bootstrap-timepicker.min.js') !!}

    <script>
        function printIframe(id) {
            var iframe = document.frames ? document.frames[id] : document.getElementById(id);
            var ifWin = iframe.contentWindow || iframe;
            iframe.focus();
            ifWin.printPage();
            return false;
        }
    </script>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">CDC</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @include('menu')
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="container">
@yield('body')
</div>
<script>
    $( function(){
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd'
        });
    } );
</script>
</body>
</html>
