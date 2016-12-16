<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Report</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {!! HTML::script('js/jquery-1.11.2.min.js') !!}
    <style type="text/css">
        * { font-size:11px; font-family:Arial; }
    </style>
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
@yield('body')
</body>
</html>