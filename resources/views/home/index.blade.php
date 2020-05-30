@extends('layout.master', ['title' => 'Trang Chủ'])

@section('javascript')
  @parent
  <script src="{{ asset('js/controllers/home-controller.js').'?v='.env('APP_VERSION') }}"></script>
@endsection

@section('content')

<div class="content-wrapper" ng-controller="HomeController">

</div>

@endsection