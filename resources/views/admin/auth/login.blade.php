@extends('admin.auth.app')
@section('content')
<div class="login-box">
    <div class="login-logo">
        @if(isset($settings->logo))
        <img src="{{ url('storage/app/img/logo/'.$settings->logo) }}" class="profile-user-img">
        @endif
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            @include("admin.include.message")
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="input-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                        placeholder="Email" value="{{ old('email') }}" name="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                @if ($errors->has('email'))
                <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
                <div class="input-group mt-3 {{ $errors->has('password') ? ' is-invalid' : '' }}">
                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                        placeholder="Password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                @if ($errors->has('password'))
                <span class="invalid-feedback"><strong>{{ $errors->first('password') }}</strong></span>
                @endif
                <div class="row  mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </div>
            </form>

            <p class="mb-1 mt-3 float-right">
                <a href="forgot-password.html">I forgot my password</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection
