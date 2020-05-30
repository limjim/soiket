@extends('layout.master', ['title' => 'Danh sách bạn bè'])

@section('stylesheet')
  @parent
  <link rel="stylesheet" href="{{ asset('css/square/red.css').'?v='.env('APP_VERSION') }}">
@endsection

@section('javascript')
  @parent
  <script src="{{ asset('js/controllers/friend-controller.js').'?v='.env('APP_VERSION') }}"></script>
@endsection

@section('content')

<div class="content-wrapper" ng-controller="FriendController">
    <section class="content-header visible-xs">
      <ol class="breadcrumb">
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active">Danh sách bạn bè</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-cloak>

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">
              <span class="hidden-xs">Danh sách bạn bè</span>
            </h3>
          <div class="box-tools pull-right">
            @include('friend.button')
          </div>
        </div>
        <div class="box-body">
          <div class="row">
                <div class="col-md-12">
                    @include('friend.list')
                </div>

                <div class="col-xs-12 text-center no-padding">
                    @include('common.paginator', ["accessPageId" => "filter.pageId", "accessPagesCount" => "pagesCount", "accessFind" => "find()"])
                </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

@endsection