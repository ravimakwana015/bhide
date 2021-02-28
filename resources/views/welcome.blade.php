@extends('layouts.app')
@section('content')
<div class="main home-page">
  <!-- Banner Section -->
  <section class="banner-wrap">
    <div class="container">
      <div class="img-wrap">
        <img src="{{ asset('public/front') }}/images/login-bg.jpeg" alt="login-bg">
      </div>
      <div class="login-wrap">
          <h2>Login</h2>
          <form method="POST" id="login-form">
              {{csrf_field()}}
              <div class="form-errors"></div>
              @if (session()->has('missmatch'))
              <div class="alert alert-danger">
                  {{session('missmatch')}}
              </div>
              @endif
              <div class="form-item">
                  <label for="email">{{ __('Your Email Address') }}</label>
                  <input type="email" placeholder="{{ __('Enter Your Email Address') }}" name="email" value="{{old('email')}}">
                  <p style="margin:0px;clear:both;"></p>
                  @if ($errors->has('email'))
                  <p class="em">{{$errors->first('email')}}</p>
                  @endif
              </div>
              <div class="form-item">
                  <label for="psw">{{ __('Your Password') }}</label>
                  <input type="password" placeholder="{{ __('Enter Your Password') }}" name="password">
                  <p style="margin:0px;clear:both;"></p>
                  @if ($errors->has('password'))
                  <p class="em">{{$errors->first('password')}}</p>
                  @endif
              </div>
              <div class="form-action">
                  <button class="btn" type="button" id="login-btn">{{ __('Login') }}</button>
                  {{-- <span>or</span>
                  <a href="javascript:void(0);" class="btn btn-login" data-toggle="modal" data-target="#exampleModal" data-dismiss="modal" aria-label="Close">Create Account</a> --}}
              </div>
          </form>
      </div>
    </div>
  </section>
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
  @endif
  @if ($message = Session::get('error'))
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
  @endif
</div>
@endsection

@push('js')

@endpush
