<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SagehAPI</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

    <!-- Styles -->
</head>
<body style="height: 100%">
    <div id="app" style="height: 100%">
        <home-page></home-page>
    </div>
</body>
<script src="{{asset('js/site.js')}}"></script>
</html>
