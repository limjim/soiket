@extends('layout.master', ['title' => 'Đổi mật khẩu'])

@section('javascript')
    @parent
    <script src="{{ asset('js/controllers/change-password-controller.js').'?v='.env('APP_VERSION') }}"></script>
@endsection

@section('content')

    <div class="content-wrapper" ng-controller="ChangePasswordController">
        <section class="content-header visible-xs">
            <ol class="breadcrumb">
                <li><a href="{{ route('seller::home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                <li class="active">Đổi mật khẩu</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fa fa-key"></i> Thay đổi mật khẩu
                    </h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ auth()->user()->email }} " readonly />
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu cũ</label>
                            <input type="password" class="form-control" ng-model="seller.password" />
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu mới</label>
                            <input type="password" class="form-control" ng-model="seller.newPassword" />
                        </div>
                        <div class="form-group">
                            <label>Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" ng-model="seller.confirmNewPassword" />
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary" ng-click="save()"><i class="fa fa-check"></i> Xác nhận</button>
                        <button type="button" class="btn btn-danger" ng-click="reset()"><i class="fa fa-times"></i> Nhập lại</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>