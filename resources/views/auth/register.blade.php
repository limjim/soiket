@extends('auth.master', ['title' => 'Đăng Ký'])
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="https://chiaki.vn">
            <img style="max-width: 100%;" src="logo/logo.png" alt="logo" />
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <form action="{{ route('register') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" name="name" class="form-control" placeholder="Tên đầy đủ" value="{{ old('name') }}" required autofocus>
                <span class="glyphicon glyphicon-home form-control-feedback"></span>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('phone') ? ' has-error' : '' }}">
                <input type="tel" name="phone" class="form-control" placeholder="Điện thoại" value="{{ old('phone') }}" required>
                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
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
            <div class="row">
                <div class="col-xs-12" style="font-size:12px">
                    @include('common.privacy')
                </div>
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="ion-checkmark"></i> Đăng ký
                    </button>
                </div>
            </div>
        </form>

        <div class="row">
            @if(!empty($message))
            <div class="col-md-12">
                <div class="form-group has-error">
                    <span class="help-block">
                        <strong>{{ $message }}</strong>
                    </span>
                </div>
            </div>
            @endif
        </div>

    </div>
    <!-- /.login-box-body -->
    </div>
<!-- /.login-box -->
@endsection