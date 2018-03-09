<!doctype html>
<html>
<head>
  <title>@yield('title','sample')</title>
  <link rel="stylesheet" href="/css/app.css">
  <script type="text/javascript" src="/js/app.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
</head>
<body>
  @include('layouts._header')

  <div id="totalcontainer" class="container-fluid">
  @include('shared._messages')
  @yield('content')
  @include('layouts._footer')
  </div>

</body>
</html>
