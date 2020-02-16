<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 @yield('title')

  <style>
    #loader {
      transition: all 0.3s ease-in-out;
      opacity: 1;
      visibility: visible;
      position: fixed;
      height: 100vh;
      width: 100%;
      background: #fff;
      z-index: 90000;
    }

    #loader.fadeOut {
      opacity: 0;
      visibility: hidden;
    }

    .spinner {
      width: 40px;
      height: 40px;
      position: absolute;
      top: calc(50% - 20px);
      left: calc(50% - 20px);
      background-color: #333;
      border-radius: 100%;
      -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
      animation: sk-scaleout 1.0s infinite ease-in-out;
    }

    @-webkit-keyframes sk-scaleout {
      0% {
        -webkit-transform: scale(0)
      }

      100% {
        -webkit-transform: scale(1.0);
        opacity: 0;
      }
    }

    @keyframes sk-scaleout {
      0% {
        -webkit-transform: scale(0);
        transform: scale(0);
      }

      100% {
        -webkit-transform: scale(1.0);
        transform: scale(1.0);
        opacity: 0;
      }
    }
  </style>
    <link href="{{ asset('assets/styles/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/css/mdb.min.css" rel="stylesheet">

</head>

<body class="app">
  <!-- @TOC -->
  <!-- =================================================== -->
  <!--
      + @Page Loader
      + @App Content
          - #Left Sidebar
              > $Sidebar Header
              > $Sidebar Menu

          - #Main
              > $Topbar
              > $App Screen Content
    -->

  <!-- @Page Loader -->
  <!-- =================================================== -->
  <div id='loader'>
    <div class="spinner"></div>
  </div>

  <script>
    window.addEventListener('load', function load() {
      const loader = document.getElementById('loader');
      setTimeout(function () {
        loader.classList.add('fadeOut');
      }, 300);
    });
  </script>

  <!-- @App Content -->
  <!-- =================================================== -->
  <div>
    <!-- #Left Sidebar ==================== -->
    @include('cms/inc/left_sidebar')

    <!-- #Main ============================ -->
    <div class="page-container">
      <!-- ### $Topbar ### -->
      @include('cms/inc/navbar')

      <!-- ### $App Screen Content ### -->
      <main class='main-content bgc-grey-100 mt-0'>
        <div id='mainContent'>
          @yield('content')
        </div>
      </main>
      @include('cms/inc/errorAlertModal')


      <!-- ### $App Screen Footer ### -->
      <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
        <span>Copyright © 2019 Designed by <a href="https://colorlib.com" target='_blank' title="Colorlib">Colorlib</a>.
          All rights reserved.</span>
      </footer>
      <script type="82b244198f000106751fa082-text/javascript" src="{{asset('assets/scripts/vendor.js')}}"></script>
      <script type="82b244198f000106751fa082-text/javascript" src="{{asset('assets/scripts/bundle.js')}}"></script>
      <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="82b244198f000106751fa082-|49" defer=""></script>
      <!-- JQuery -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <!-- Bootstrap tooltips -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
      <!-- Bootstrap core JavaScript -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <!-- Tiny mice -->
      <script src="https://cdn.tiny.cloud/1/x9v7l8yleqlv5fhsfbipacl93girudvql99u0wp7a64b8rix/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
     <!-- MDB core JavaScript -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.10.1/js/mdb.min.js"></script>
      <script type="text/javascript" src="{{ asset('js/timeago.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
     </div>
  </div>
</body>

</html>