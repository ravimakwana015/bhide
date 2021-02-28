@extends('layouts.app')
@section('content')
<div class="main login-page">
    <div class="login-main-wrap">
        <div class="left-content">
            <div class="content">
                <h1><span>Appartment</span> Lifestyle you Need</h1>
                <p>An App that will truly ease your way of managing your property. From home or away, you will take
                    control of the important things that really matter.</p>
            </div>
        </div>
        <div class="right-content">
            <div class="login-form-wrap">
                <ul class="tabs-wrap">
                    <li class="active"><a href="javascript:void(0);" data-target="dentist">Dentist</a></li>
                    <li><a href="javascript:void(0);" data-target="patient">Patient</a></li>
                </ul>
                <div class="tabs-content-wrap">
                    <div class="tabs-content active" id="dentist">
                        <h2>Login</h2>
                        <form role="form" id="logform" method="POST" action="{{ route('login') }}">
							@if ($message = Session::get('error'))
							<div class="alert alert-danger alert-block">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<strong>{{ $message }}</strong>
							</div>
							@endif
							@csrf
                            <div class="form-item">
                                <label>Email Address *</label>
                                <input placeholder="{{ __('Email') }}" type="email" name="email"
                                    value="{{ old('email') }}" autofocus>
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-item">
                                <label>Your Password *</label>
                                <input name="password" placeholder="{{ __('Password') }}" type="password">
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-action">
                                <button type="submit" class="btn">Login</button>
                            </div>
                            {{-- <div class="form-check">
                                <input type="checkbox" name="">
                                Remember me?
                            </div> --}}
                            <div class="forgot-link">
                                <a href="{{ route('password.request') }}">{{ __('Lost your Password?') }}</a>
                            </div>
                        </form>
                    </div>
                    <div class="tabs-content" id="patient">
                        <h3>Please install Mobile Application from:</h3>
                        <a href="">
                            <img src="{{ asset('public/front') }}/images/apple.svg">
                            <span>Apple App store</span>
                        </a>
                        <a href="">
                            <img src="{{ asset('public/front') }}/images/playstore.svg">
                            <span>Google Playstore</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push("js")
<script>
    $(document).ready(function() {
		$("#logform").validate({
			rules: {
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					// min: 6
				}
			},
			messages: {
				email: {
					required: "Please enter email addresss",
					email: "Your email address must be in the format of name@domain.com"
				},
				password: {
					required: "Please enter password",
					min: "Password must be at least 6 characters."
				}
			},
			// submitHandler: function(form) { alert("Submitted!") }
		});
	});
</script>
@endpush
