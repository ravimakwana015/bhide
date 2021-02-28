@extends('layouts.app')

@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Change Password') }}</h3>
            </div>
            <div class="btn-wrap">
                <a class="btn mb-0" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form enctype="multipart/form-data" action="{{ route("update.password") }}" method="POST"
                id="update_password">
                @csrf
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-control-label"
                                for="validationDefault01">{{__('Current Password:')}}</label>
                            <input type="password" name="old_password" value="{{ old('old_password') }}"
                                class="form-control  @error('old_password') invalid-input @enderror"
                                placeholder="{{__('Current Password')}}">
                            @error('old_password')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-control-label" for="validationDefault01">{{__('New Password:')}}</label>
                            <input type="password" name="password"
                                class="form-control  @error('password') invalid-input @enderror"
                                placeholder="{{__('New Password')}}" id="password">
                            @error('password')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-control-label"
                                for="validationDefault01">{{__('Confirm Password:')}}</label>
                            <input type="password" name="password_confirmation"
                                class="form-control  @error('password_confirmation') invalid-input @enderror"
                                placeholder="{{__('Confirm Password')}}"> @error('password_confirmation')
                            <div class="invalid-div">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <button class="btn btn-primary" type="submit">{{__('Update')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $("#update_password").validate({
			rules: {
				old_password: {
					required: true,
                    minlength: 8
				},
				password: {
					required: true,
                    minlength: 8
				},
				password_confirmation: {
					required: true,
                    minlength: 8,
                    equalTo : "#password"
				},
			},
			messages: {
                'password_confirmation':{
                    'equalTo': 'Confirm Password and new password must be same.'
                }
			},
		});
	} );
</script>
@endpush
