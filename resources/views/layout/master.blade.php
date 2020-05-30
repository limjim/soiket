
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ (isset($title)) ? $title : ''}} - {{ env('APP_NAME') }} </title>
  <link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @section('stylesheet')

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/ionicons.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/pnotify.custom.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/chosen.min.css').'?v='.env('APP_VERSION') }}">
  <style>
      [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-    ng-cloak {
          display: none !important;
      }
  </style>
  @show

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body class="sidebar-collapse skin-blue sidebar-mini fixed" ng-app="soiket" ng-cloak>
<!-- Site wrapper -->
<div class="wrapper">

  @include('layout.header')

  @include('layout.aside')

  @yield('content')

  @include('layout.footer')

  <!-- /.control-sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

@section('javascript')

    <script type="text/javascript">
      
    </script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/chosen-add-option.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/fastclick.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/pace.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/pnotify.custom.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/script.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/angulars/angular.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/angulars/angular-sanitize.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/angulars/angular-animate.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/angulars/angular-chosen.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/angulars/ng-file-upload.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/angulars/ng-file-upload-shim.min.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/controllers/base-controller.js').'?v='.env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/controllers/header-controller.js').'?v='.env('APP_VERSION') }}"></script>

@show

</body>
</html>
