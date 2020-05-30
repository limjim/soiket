@extends('auth.master', ['title' => 'Đăng Nhập'])
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="https://chiaki.vn">
            <img style="max-width: 100%;" src="logo/logo.png" alt="logo" />
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg text-bold">Trang quản lý</p>
        <form action="{{ route('login') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-7">
                    <a href="{{ route('password.request') }}" style="margin-top: 7px;display: inline-block;"><i class="fa fa-key"></i> &nbsp;Quên mật khẩu ?</a>
                </div>
                <div class="col-xs-5">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="ion-log-in"></i> Đăng nhập
                    </button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12 text-center">
                <br /><br />
                <i class="fa fa-users"></i> &nbsp;Bạn chưa có tài khoản ?
                <a href="{{ route('register') }}" class="text-center"> Đăng ký</a>
            </div>
        </div>

    </div>
    <!-- /.login-box-body -->
    </div>
<!-- /.login-box -->
@endsection