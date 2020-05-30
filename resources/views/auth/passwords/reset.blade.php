@extends('auth.master', ['title' => 'Đặt Lại Mật Khẩu'])
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="https://chiaki.vn">
            <img style="max-width: 100%;" src="https://chiaki.vn/frontend/images/chiaki-large-vn.png" alt="logo" />
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg text-bold">Đặt lại mật khẩu</p>
        <form action="{{ route('password.request') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="ion-checkmark"></i> Xác nhận
                    </button>
                </div>
            </div>

        </form>

        <div class="row">
            <div class="col-md-12 text-center">
                <br /><br />
                <i class="fa fa-sign-in"></i> &nbsp;Bạn đã có tài khoản ?
                <a href="{{ route('login') }}" class="text-center"> Đăng nhập</a>
            </div>
        </div>

    </div>
    <!-- /.login-box-body -->
    </div>
<!-- /.login-box -->
@endsection
