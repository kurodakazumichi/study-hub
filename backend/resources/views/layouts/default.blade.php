<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">    
    <link rel="stylesheet" href="/css/default.css">    

    <!-- ページ専用JS -->
    <script src="/js/@yield('js', 'empty.js')"></script>
  </head>
  <body>
    <header>
      <a href="/categories">category</a>
      <a href="/varieties">variety</a>
      <a href="/studies">study</a>
    </header>
    @section('main')
    @show
  </body>
</html>