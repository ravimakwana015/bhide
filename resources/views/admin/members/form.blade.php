<div class="row">
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('gate_id') ? ' is-invalid' : '' }}">
            {{ Form::label('gate_id','Choose Gate', ['class' => 'control-label required']) }}
            <br />
            @if(isset($concierge))
            <div id="new_gate">
                @foreach ($gates as $key=>$gate)
                <input type="radio" name="gate_id" value="{{ $key }}" @if($concierge->gate_id==$key) checked @endif/>
                {{ $gate }}
                @endforeach
            </div>
            @else
            <div id="new_gate">
                @foreach ($gates as $key=>$gate)
                <input type="radio" name="gate_id" value="{{ $key }}" /> {{ $gate }}
                @endforeach
            </div>
            @endif
            @if ($errors->has('gate_id'))
            <span class="invalid-feedback">{{ $errors->first('gate_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <button type="button" onclick="addRemoveGate('{{ route('get.gate') }}')" style="margin-top:30px;"
        class="btn btn-primary btn-sm">Add Or Remove Gate</button>
    </div>
</div>
<hr />
<h5>Concierge Company</h5>
<hr />
<div class="row">
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('first_name') ? ' is-invalid' : '' }}">
            {{ Form::label('first_name','Company Name', ['class' => 'control-label required']) }}
            <select class="form-control" name="company_id">
                @foreach($companys as $key => $company)
                <option value="{{ $key }}" @if(isset($concierge)) @if($concierge->company_id==$key) selected="" @endif @endif>{{ $company }}</option>
                @endforeach
            </select>
            @if ($errors->has('first_name'))
            <span class="invalid-feedback">{{ $errors->first('first_name') }}</span>
            @endif
        </div>
    </div>
</div>

<hr />
<h5>Concierge Member Details</h5>
<hr />
<div class="row">
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('first_name') ? ' is-invalid' : '' }}">
            {{ Form::label('first_name','First Name', ['class' => 'control-label required']) }}
            {{ Form::text('first_name', null, ['class' => 'form-control '.($errors->has('first_name') ? 'is-invalid':''), 'placeholder' => 'First Name']) }}
            @if ($errors->has('first_name'))
            <span class="invalid-feedback">{{ $errors->first('first_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('last_name') ? ' is-invalid' : '' }}">
            {{ Form::label('last_name','Last Name', ['class' => 'control-label required']) }}
            {{ Form::text('last_name', null, ['class' => 'form-control '.($errors->has('last_name') ? 'is-invalid':''), 'placeholder' => 'Last Name']) }}
            @if ($errors->has('last_name'))
            <span class="invalid-feedback">{{ $errors->first('last_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('gender') ? ' is-invalid' : '' }}">
            {{ Form::label('gender', 'Gender', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" name="gender" value="male" @if(isset($concierge) && $concierge->gender=='male') checked @endif/>
            Male
            <input type="radio" name="gender" value="female" @if(isset($concierge) && $concierge->gender=='female') checked
            @endif/>
            Female
            <br />
            @if ($errors->has('gender'))
            <span class="invalid-feedback">{{ $errors->first('gender') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}">
            {{ Form::label('date_of_birth','Date of birth', ['class' => 'control-label required']) }}
            <br />
            {{ Form::text('date_of_birth', null, ['class' => 'form-control datetimepicker '.($errors->has('date_of_birth') ? 'is-invalid':''), 'placeholder' => 'Date of birth','readonly']) }}
            @if ($errors->has('date_of_birth'))
            <span class="invalid-feedback">{{ $errors->first('date_of_birth') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
            {{ Form::label('email','Email', ['class' => 'control-label required']) }}
            <br />
            @if(isset($user))
            {{ $user->email }}
            @else
            {{ Form::text('email', null, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid':''), 'placeholder' => 'Email']) }}
            @if ($errors->has('email'))
            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
            @endif
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('phone_number') ? ' is-invalid' : '' }}">
            {{ Form::label('phone_number','Mobile Number', ['class' => 'control-label required']) }}
            {{ Form::text('phone_number', null, ['class' => 'form-control '.($errors->has('phone_number') ? 'is-invalid':''), 'placeholder' => 'Mobile Number']) }}
            @if ($errors->has('phone_number'))
            <span class="invalid-feedback">{{ $errors->first('phone_number') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('shift_start') ? ' is-invalid' : '' }}">
            {{ Form::label('shift_start','Shift Start', ['class' => 'control-label required']) }}
            <br />
            {{ Form::text('shift_start', null, ['class' => 'form-control shift_start'.($errors->has('shift_start') ? 'is-invalid':''), 'placeholder' => 'Shift Start' ,'readonly']) }}
            @if ($errors->has('shift_start'))
            <span class="invalid-feedback">{{ $errors->first('shift_start') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('shift_end') ? ' is-invalid' : '' }}">
            {{ Form::label('shift_end','Shift End', ['class' => 'control-label required']) }}
            <br />
            {{ Form::text('shift_end', null, ['class' => 'form-control shift_end'.($errors->has('shift_end') ? 'is-invalid':''), 'placeholder' => 'Shift End' ,'readonly']) }}
            @if ($errors->has('shift_end'))
            <span class="invalid-feedback">{{ $errors->first('shift_end') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('concierge_image', 'Member Image', ['class' => 'control-label required']) }}
            <input type="hidden" name="concierge_images" id="profile-img-tag-textarea">
            @if(isset($concierge->concierge_image))
            <input type="file" name="concierge_image" id="concierge_image-1" class="inputfile inputfile-1" value="{{ $concierge->concierge_image }}" />
            <br/>
            <br/>
            <img src="{{ asset('public/front/concierges_image/' . $concierge->concierge_image) }}" width="80" height="80" id="career_img">
            @else
            <input type="file" accept="image/*" name="concierge_image" id="concierge_image-1" class="inputfile inputfile-1"/>
            <br/>
            @endif
            @if ($errors->has('concierge_image'))
            <span class="invalid-feedback">{{ $errors->first('concierge_image') }}</span>
            @endif
            @include('concierges.image-crop-wrap')
        </div>
        <span class="text-danger" id="image-dimension"></span>
    </div>
</div>
<hr />
<h5>Concierge Member Address</h5>
<hr />
<div class="row">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('address') ? ' is-invalid' : '' }}">
            {{ Form::label('address','Address', ['class' => 'control-label required']) }}
            {{ Form::text('address', null, ['class' => 'form-control '.($errors->has('address') ? 'is-invalid':''), 'placeholder' => 'Address']) }}
            @if ($errors->has('address'))
            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group {{ $errors->has('city') ? ' is-invalid' : '' }}">
            {{ Form::label('city','City', ['class' => 'control-label required']) }}
            {{ Form::text('city', null, ['class' => 'form-control '.($errors->has('city') ? 'is-invalid':''), 'placeholder' => 'City']) }}
            @if ($errors->has('city'))
            <span class="invalid-feedback">{{ $errors->first('city') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group {{ $errors->has('state') ? ' is-invalid' : '' }}">
            {{ Form::label('state','State', ['class' => 'control-label required']) }}
            {{ Form::text('state', null, ['class' => 'form-control '.($errors->has('state') ? 'is-invalid':''), 'placeholder' => 'State']) }}
            @if ($errors->has('state'))
            <span class="invalid-feedback">{{ $errors->first('state') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group {{ $errors->has('country') ? ' is-invalid' : '' }}">
            {{ Form::label('country','Country', ['class' => 'control-label required']) }}
            {{ Form::text('country', null, ['class' => 'form-control '.($errors->has('country') ? 'is-invalid':''), 'placeholder' => 'Country']) }}
            @if ($errors->has('country'))
            <span class="invalid-feedback">{{ $errors->first('country') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group {{ $errors->has('zip_code') ? ' is-invalid' : '' }}">
            {{ Form::label('zip_code','Postal Code', ['class' => 'control-label required']) }}
            {{ Form::text('zip_code', null, ['class' => 'form-control '.($errors->has('zip_code') ? 'is-invalid':''), 'placeholder' => 'Postal Code']) }}
            @if ($errors->has('zip_code'))
            <span class="invalid-feedback">{{ $errors->first('zip_code') }}</span>
            @endif
        </div>
    </div>
</div>
<hr />
