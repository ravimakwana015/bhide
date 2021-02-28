<div class="msg"></div>
<div class="row">
    <input type="hidden" name="id" value="{{ $facilitie->id }}">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
            {{ Form::label('company_id','Company Name', ['class' => 'control-label required']) }}
            {{-- {{ Form::select('company_id', $companys,$facilitie, ['class' => 'form-control select2']) }} --}}
            <select class="form-control select2" name="company_id">
                @foreach($companys as $company)
                <option value="{{ $company->id }}" {{ $company->id == $facilitie->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                @endforeach
            </select>
            @if ($errors->has('company_id'))
            <span class="invalid-feedback">{{ $errors->first('company_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('facility_name') ? ' is-invalid' : '' }}">
            {{ Form::label('facility_name','Facility Name', ['class' => 'control-label required']) }}
            {{ Form::text('facility_name', $facilitie->facility_name, ['class' => 'form-control '.($errors->has('facility_name') ? 'is-invalid':''), 'placeholder' => 'Facility Name']) }}
            @if ($errors->has('facility_name'))
            <span class="invalid-feedback">{{ $errors->first('facility_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('contact') ? ' is-invalid' : '' }}">
            {{ Form::label('contact','Contact Details', ['class' => 'control-label required']) }}
            {{ Form::text('contact', $facilitie->contact, ['class' => 'form-control '.($errors->has('contact') ? 'is-invalid':''), 'placeholder' => 'Contact Details']) }}
            @if ($errors->has('contact'))
            <span class="invalid-feedback">{{ $errors->first('contact') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('availability') ? ' is-invalid' : '' }}">
            {{ Form::label('availability','Availability Time', ['class' => 'control-label required']) }}
            {{ Form::text('availability', $facilitie->availability, ['class' => 'form-control '.($errors->has('availability') ? 'is-invalid':''), 'placeholder' => 'Availability Time']) }}
            @if ($errors->has('availability'))
            <span class="invalid-feedback">{{ $errors->first('availability') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('description') ? ' is-invalid' : '' }}">
            {{ Form::label('description','Description', ['class' => 'control-label required']) }}
            {{ Form::textarea('description', $facilitie->description, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid':''), 'placeholder' => 'Description','rows'=>'2']) }}
            @if ($errors->has('description'))
            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" name="status" value="1" @if(isset($facilitie) && $facilitie->status=='1') checked @endif/>
            Active
            <input type="radio" name="status" value="0" @if(isset($facilitie) && $facilitie->status=='0') checked @endif/>
            In Active
            <br />
            @if ($errors->has('status'))
            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
            @endif
            <div class="error_msg"></div>
        </div>
    </div>
</div>
</div>