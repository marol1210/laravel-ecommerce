<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title', 'AvoRed E commerce')</title>
</head>
<body>
    <div id="app">
        <layout-admin ref="layout_main" :menus="{{$adminMenus}}" />
    </div>
      <!-- import Vue before Element -->
  <script type="text/javascript" src="/static/js/chunk-vendors.js"></script>
  <script type="text/javascript" src="/static/js/app.js"></script>
</body>
</html>
