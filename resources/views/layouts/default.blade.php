<html>
<head>
  <title>@yield('title','sample')</title>
  <link rel="stylesheet" href="/css/app.css">
  <script type="text/javascript" src="/js/app.js"></script>
</head>
<body>
  @include('layouts._header')

  <div class="container">
  @yield('content')

  @include('layouts._footer')
</div>

</body>
</html>
