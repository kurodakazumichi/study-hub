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

    <!-- font-awesome -->
    <script src="https://kit.fontawesome.com/ca043f4c22.js" crossorigin="anonymous"></script>

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
      <nav class="global-nav">
        <ul class="global-nav__menu">
          <li class="global-nav__item">
            <a class="global-nav__link" href="/"><i class="fas fa-book"></i>&nbsp;{{ config('app.name') }}</a>
          </li>
          <li class="global-nav__item"><a class="global-nav__link" href="/categories">Category</a></li>
          <li class="global-nav__item"><a class="global-nav__link" href="/varieties">Variety</a></li>
          <li class="global-nav__item"><a class="global-nav__link" href="/studies">study</a></li>
          <li class="global-nav__item"><a class="global-nav__link" href="/notes">Note</a></li>
          <li class="global-nav__item"><a class="global-nav__link" href="/achievements">Achievement</a></li>
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