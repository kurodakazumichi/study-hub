<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">    
    <link rel="stylesheet" href="/css/default.css">    

    @section('cdn')
    @show

    <!-- ページ専用JS -->
    <script src="/js/@yield('js', 'empty.js')"></script>
  </head>
  <body>
    @if( config('app.env') !== "production")
    <div id="app-env" style="background-color:#444; font-size:8px; padding:2px; color:white;">
      <a href="/debug" style="color:white;">{{ config('app.env') }}</a>
    </div>
    @endif

    <header>
      <a href="/">{{ config('app.name') }}</a>
      <a href="/categories">category</a>
      <a href="/varieties">variety</a>
      <a href="/studies">study</a>
      <a href="/notes">note</a>
    </header>
    @section('main')
    @show
  </body>
</html>