@extends('auth.master', ['title' => 'Quên Mật Khẩu'])
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="https://chiaki.vn">
            <img style="max-width: 100%;" src="https://chiaki.vn/frontend/images/chiaki-large-vn.png" alt="logo" />
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        @if (session('status'))
        <p class="login-box-msg text-bold text-green">{{ session('status') }}</p>
        @else
        <p class="login-box-msg text-bold">Vui lòng nhập địa chỉ email. Chúng tôi sẽ gửi hướng dẫn khôi phục mật khẩu.</p>
        @endif
        <form action="{{ route('password.email') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" autofocus required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="fa fa-key"></i> Khôi phục
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
