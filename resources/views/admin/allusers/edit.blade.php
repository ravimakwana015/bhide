<div class="msg"></div>
<div class="row">
	<input type="hidden" name="id" value="{{ $user->id }}">
	{{-- <div class="col-md-4">
		<div class="form-group {{ $errors->has('unit_id') ? ' is-invalid' : '' }}">
			{{ Form::label('unit_id','Apartment Units', ['class' => 'control-label required']) }}
			{{ Form::select('unit_id', $user->company,null, ['class' => 'select2']) }}
			@if ($errors->has('unit_id'))
			<span class="invalid-feedback">{{ $errors->first('unit_id') }}</span>
			@endif
		</div>
	</div> --}}
	<div class="col-md-4">
		<div class="form-group {{ $errors->has('member_type') ? ' is-invalid' : '' }}">
			{{ Form::label('member_type', 'Member Type', ['class' =>'control-label required']) }}
			{{ Form::select('member_type', [""=>"Select Member Type","owner"=>"Owner","tenant"=>"Tenant","owner_family"=>"Owner Family","tenant_family"=>"Tenant Family"],$user->member_type, ['class' => 'form-control','id'=>'member_type']) }}
			@if ($errors->has('member_type'))
			<span class="invalid-feedback">{{ $errors->first('member_type') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group {{ $errors->has('gender') ? ' is-invalid' : '' }}">
			{{ Form::label('gender', 'Gender', ['class' =>'control-label required']) }}
			<br />
			<input type="radio" name="gender" value="male" @if(isset($user) && $user->gender=='male') checked @endif/>
			Male
			<input type="radio" name="gender" value="female" @if(isset($user) && $user->gender=='female') checked
			@endif/>
			Female
			<input type="radio" name="gender" value="prefer" @if(isset($user) && $user->gender=='prefer') checked
			@endif/>
			Prefer not to say
			<br />
			@if ($errors->has('gender'))
			<span class="invalid-feedback">{{ $errors->first('gender') }}</span>
			@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group {{ $errors->has('first_name') ? ' is-invalid' : '' }}">
			{{ Form::label('first_name','First Name', ['class' => 'control-label required']) }}
			{{ Form::text('first_name', $user->first_name, ['class' => 'form-control '.($errors->has('first_name') ? 'is-invalid':''), 'placeholder' => 'First Name']) }}
			@if ($errors->has('first_name'))
			<span class="invalid-feedback">{{ $errors->first('first_name') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group {{ $errors->has('middle_name') ? ' is-invalid' : '' }}">
			{{ Form::label('middle_name','Middle Name', ['class' => 'control-label required']) }}
			{{ Form::text('middle_name', $user->middle_name, ['class' => 'form-control '.($errors->has('middle_name') ? 'is-invalid':''), 'placeholder' => 'Middle Name']) }}
			@if ($errors->has('middle_name'))
			<span class="invalid-feedback">{{ $errors->first('middle_name') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group {{ $errors->has('last_name') ? ' is-invalid' : '' }}">
			{{ Form::label('last_name','Last Name', ['class' => 'control-label required']) }}
			{{ Form::text('last_name', $user->last_name, ['class' => 'form-control '.($errors->has('last_name') ? 'is-invalid':''), 'placeholder' => 'Last Name']) }}
			@if ($errors->has('last_name'))
			<span class="invalid-feedback">{{ $errors->first('last_name') }}</span>
			@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group {{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}">
			{{ Form::label('date_of_birth','Date of birth', ['class' => 'control-label required']) }}
			<br />
			{{ Form::text('date_of_birth', $user->date_of_birth, ['class' => 'form-control datetimepicker '.($errors->has('date_of_birth') ? 'is-invalid':''), 'placeholder' => 'Date of birth','readonly']) }}
			@if ($errors->has('date_of_birth'))
			<span class="invalid-feedback">{{ $errors->first('date_of_birth') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group {{ $errors->has('phone_number') ? ' is-invalid' : '' }}">
			{{ Form::label('phone_number','Mobile Number', ['class' => 'control-label required']) }}
			{{ Form::text('phone_number', $user->phone_number, ['class' => 'form-control '.($errors->has('phone_number') ? 'is-invalid':''), 'placeholder' => 'Mobile Number']) }}
			@if ($errors->has('phone_number'))
			<span class="invalid-feedback">{{ $errors->first('phone_number') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{{ Form::label('member_image', 'Profile Image', ['class' => 'control-label required']) }}
			<br />
			<input type="hidden" name="member_images" id="profile-img-tag-textarea">
			@if(isset($user->member_image))
			<input type="file" name="member_image" id="member_image-1" class="inputfile inputfile-1"
			value="{{ $user->member_image }}" />
			<br />
			<br />
			<img src="{{ asset('public/front/member_image/' . $user->member_image) }}" width="80" height="80"
			id="career_img">
			@else
			<input type="file" accept="image/*" name="member_image" id="member_image-1" class="inputfile inputfile-1" />
			<br />
			@endif
			@if ($errors->has('member_image'))
			<span class="invalid-feedback">{{ $errors->first('member_image') }}</span>
			@endif
			@include('apartment.image-crop-wrap')
		</div>
		<span class="text-danger" id="image-dimension"></span>
	</div>
</div>
<hr />
<h5>Correspondence Address</h5>
<hr />
<div class="row">
	<div class="col-md-4">
		<div class="form-group {{ $errors->has('address') ? ' is-invalid' : '' }}">
			{{ Form::label('address','Address', ['class' => 'control-label required']) }}
			{{ Form::text('address', $user->address, ['class' => 'form-control '.($errors->has('address') ? 'is-invalid':''), 'placeholder' => 'Address']) }}
			@if ($errors->has('address'))
			<span class="invalid-feedback">{{ $errors->first('address') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group {{ $errors->has('city') ? ' is-invalid' : '' }}">
			{{ Form::label('city','City', ['class' => 'control-label required']) }}
			{{ Form::text('city', $user->city, ['class' => 'form-control '.($errors->has('city') ? 'is-invalid':''), 'placeholder' => 'City']) }}
			@if ($errors->has('city'))
			<span class="invalid-feedback">{{ $errors->first('city') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group {{ $errors->has('country') ? ' is-invalid' : '' }}">
			{{ Form::label('country','Country', ['class' => 'control-label required']) }}
			{{ Form::text('country', $user->country, ['class' => 'form-control '.($errors->has('country') ? 'is-invalid':''), 'placeholder' => 'Country']) }}
			@if ($errors->has('country'))
			<span class="invalid-feedback">{{ $errors->first('country') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group {{ $errors->has('zip_code') ? ' is-invalid' : '' }}">
			{{ Form::label('zip_code','Postal Code', ['class' => 'control-label required']) }}
			{{ Form::text('zip_code', $user->zip_code, ['class' => 'form-control '.($errors->has('zip_code') ? 'is-invalid':''), 'placeholder' => 'Postal Code']) }}
			@if ($errors->has('zip_code'))
			<span class="invalid-feedback">{{ $errors->first('zip_code') }}</span>
			@endif
		</div>
	</div>
</div>
<hr />
<h5>Member App login details</h5>
<hr />
<div class="row">
	<div class="col-md-3">
		<div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
			{{ Form::label('email','Email/Username', ['class' => 'control-label required']) }}
			<br />
			@if(isset($user))
			{{ $user->email }}
			@else
			{{ Form::text('email', null, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid':''), 'placeholder' => 'Email/Username']) }}
			@if ($errors->has('email'))
			<span class="invalid-feedback">{{ $errors->first('email') }}</span>
			@endif
			@endif
		</div>
	</div>


	@if(!isset($user))
	<div class="col-md-3">
		<div class="form-group {{ $errors->has('password') ? ' is-invalid' : '' }}">
			{{ Form::label('password','Password', ['class' => 'control-label required']) }}
			<input type="password" name="password" class="form-control" placeholder="Password">
			
			@if ($errors->has('password'))
			<span class="invalid-feedback">{{ $errors->first('password') }}</span>
			@endif
		</div>
	</div>
	@endif
</div>