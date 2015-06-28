<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <link rel="stylesheet" href="/vendor/font-awesome/css/font-awesome.min.css">
</head>
<body>
  @yield('content')
  <script src="/vendor/jquery/dist/jquery.min.js" type="text/javascript"></script>
  @yield('scripts')
</body>
</html>