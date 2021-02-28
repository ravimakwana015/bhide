<div class="msg"></div>
<div class="row">
    <input type="hidden" name="id" value="{{ $service->id }}">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
            {{ Form::label('company_id','Company Name', ['class' => 'control-label required']) }}
            {{-- {{ Form::select('company_id', $companys,null, ['class' => 'form-control select2']) }} --}}
            <select class="form-control select2" name="company_id">
                @foreach($companys as $company)
                <option value="{{ $company->id }}" {{ $company->id == $service->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                @endforeach
            </select>
            @if ($errors->has('company_id'))
            <span class="invalid-feedback">{{ $errors->first('company_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('category_id') ? ' is-invalid' : '' }}">
            {{ Form::label('category_id','Company Category Name', ['class' => 'control-label required']) }}
            {{-- {{ Form::select('category_id', $companys,null, ['class' => 'form-control select2']) }} --}}
            <select class="form-control select2" name="category_id">
                @foreach($serviceCategorys as $company)
                <option value="{{ $company->id }}" {{ $company->id == $service->category_id ? 'selected' : '' }}>{{ $company->category_name }}</option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
            <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('service_name') ? ' is-invalid' : '' }}">
            {{ Form::label('service_name','Service Name', ['class' => 'control-label required']) }}
            {{ Form::text('service_name', $service->service_name, ['class' => 'form-control '.($errors->has('service_name') ? 'is-invalid':''), 'placeholder' => 'Service Name']) }}
            @if ($errors->has('service_name'))
            <span class="invalid-feedback">{{ $errors->first('service_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('service_provider_name') ? ' is-invalid' : '' }}">
            {{ Form::label('service_provider_name','Service Provider Name', ['class' => 'control-label required']) }}
            {{ Form::text('service_provider_name', $service->service_provider_name, ['class' => 'form-control '.($errors->has('service_provider_name') ? 'is-invalid':''), 'placeholder' => 'Service Provider Name']) }}
            @if ($errors->has('service_provider_name'))
            <span class="invalid-feedback">{{ $errors->first('service_provider_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('contact_number') ? ' is-invalid' : '' }}">
            {{ Form::label('contact_number','Contact Number', ['class' => 'control-label required']) }}
            {{ Form::text('contact_number', $service->contact_number, ['class' => 'form-control '.($errors->has('contact_number') ? 'is-invalid':''), 'placeholder' => 'Contact Number']) }}
            @if ($errors->has('contact_number'))
            <span class="invalid-feedback">{{ $errors->first('contact_number') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}">
            {{ Form::label('mobile_number','Mobile Number', ['class' => 'control-label required']) }}
            {{ Form::text('mobile_number', $service->mobile_number, ['class' => 'form-control '.($errors->has('mobile_number') ? 'is-invalid':''), 'placeholder' => 'Mobile Number']) }}
            @if ($errors->has('mobile_number'))
            <span class="invalid-feedback">{{ $errors->first('mobile_number') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
            {{ Form::label('email','Email', ['class' => 'control-label required']) }}
            {{ Form::text('email', $service->email, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid':''), 'placeholder' => 'Email']) }}
            @if ($errors->has('email'))
            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" name="status" value="1" @if(isset($service) && $service->status=='1')
            checked @endif/>
            Open
            <input type="radio" name="status" value="0" @if(isset($service) && $service->status=='0')
            checked @endif/>
            Close
            <br />
            @if ($errors->has('status'))
            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
            @endif
            <div class="error_msg"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('address') ? ' is-invalid' : '' }}">
            {{ Form::label('address','Address', ['class' => 'control-label required']) }}
            {{ Form::textarea('address', $service->address, ['class' => 'form-control'.($errors->has('address') ? 'is-invalid':''), 'placeholder' => 'Address','rows'=>'1']) }}
            @if ($errors->has('address'))
            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
            @endif
        </div>
    </div>
</div>