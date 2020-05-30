
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ (isset($title)) ? $title : ''}} - {{ env('APP_NAME') }} </title>
  <link rel="icon" type="image/ico" href="{{ asset('favicon.ico') }}" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  @section('stylesheet')

  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/ionicons.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css').'?v='.env('APP_VERSION') }}">
  <link rel="stylesheet" href="{{ asset('css/square/blue.css').'?v='.env('APP_VERSION') }}">
    <style>
      .login-page, .register-page{
        background:linear-gradient(135deg, rgba(0, 34, 36, 0.02) 0%, rgb(247, 247, 247) 35%, rgba(14, 204, 169, 0.03) 100%)
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
<body class="hold-transition login-page">

  @yield('content')

</div>
<!-- ./wrapper -->

@section('javascript')

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

@show

</body>
</html>
