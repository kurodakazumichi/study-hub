<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Reset CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/css-wipe@4.3.0/index.min.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">    
    <link rel="stylesheet" href="/css/default.layout.css">    

    @section('cdn')
    @show

    <!-- core.js -->
    <script src="/js/study_hub.js"></script>


    <!-- ページ専用JS -->
    <script src="/js/@yield('js', 'empty.js')"></script>
  </head>
  <body>
    <header class="ly-header">
      @if( config('app.env') !== "production")
      <div id="app-env" style="background-color:red; font-size:8px; padding:2px; color:white;">
        <a href="/debug" style="color:white;">{{ config('app.env') }}</a>
      </div>
      @endif
      <nav class="nav">
        <ul>
          <li><a href="/">{{ config('app.name') }}</a></li>
          <li><a href="/categories">Category</a></li>
          <li><a href="/varieties">Variety</a></li>
          <li><a href="/studies">study</a></li>
          <li><a href="/notes">Note</a></li>
          <li><a href="/achievements">Achievement</a></li>
        </ul>
      </nav>
    </header>

    <main class="ly-main">
      @section('main')
      @show
    </main>
    <footer>
    </footer>
  </body>
</html>