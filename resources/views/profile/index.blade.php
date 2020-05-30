@extends('layout.master', ['title' => 'Cập nhật thông tin gian hàng'])

@section('javascript')
    @parent
    <script src="{{ asset('js/controllers/profile-controller.js').'?v='.env('APP_VERSION') }}"></script>
@endsection

@section('content')

    <div class="content-wrapper" ng-controller="ProfileController">
        <section class="content-header visible-xs">
            <ol class="breadcrumb">
                <li><a href="{{ route('seller::home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                <li class="active">Hồ sơ</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" ng-cloak>

            <!-- Default box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fa fa-delicious"></i> Cập nhật thông tin gian hàng
                    </h2>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label style="display:block">Mã gian hàng <a target="_blank" href="https://vuahanghieu.com/shop/@{{seller.code}}" ng-if="seller.code" class="pull-right">Xem gian hàng</a></label>
                            <input type="text" class="form-control" ng-model="seller.code" readonly />
                        </div>
                        <div class="form-group">
                            <label>Tên gian hàng</label>
                            <input type="text" class="form-control" ng-model="seller.name" />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" ng-model="seller.email" readonly />
                        </div>
                        <div class="form-group">
                            <label>Điện thoại</label>
                            <input type="tel" class="form-control" ng-model="seller.phone" />
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <textarea rows="3" class="form-control" ng-model="seller.address"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Loại hình</label>
                            <select class="form-control" ng-model="seller.type" ng-options="item.key as item.value for item in types"></select>
                        </div>
                        <div class="form-group">
                            <label>Tên cá nhân/tổ chức</label>
                            <input type="text" class="form-control" ng-model="seller.name_organization" />
                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" class="form-control" ng-model="seller.website" placeholder="http://example.com" />
                        </div>
                        <div class="form-group">
                            <label>Đăng ký kinh doanh/Mã số thuế</label>
                            <input type="text" class="form-control" ng-model="seller.sell_code" ng-disabled="seller.type == 'personal'" />
                        </div>
                        <div class="form-group">
                            <label>Giới thiệu</label>
                            <textarea rows="3" class="form-control" ng-model="seller.description"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Facebook</label>
                            <input type="type" class="form-control" ng-model="seller.facebook" placeholder="Link profile..." />
                        </div>
                        <div class="form-group">
                            <label>Skype</label>
                            <input type="type" class="form-control" ng-model="seller.skype" placeholder="Skype name..." />
                        </div>
                        <div class="form-group">
                            <label>Youtube</label>
                            <input type="type" class="form-control" ng-model="seller.youtube" placeholder="Link channel ..." />
                        </div>
                        <div class="form-group">
                            @include('common.privacy')
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
@endsection