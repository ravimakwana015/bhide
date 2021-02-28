<div class="msg"></div>
<div class="row">
    <input type="hidden" name="id" value="{{ $service->id }}">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
            {{ Form::label('company_id','Company Name', ['class' => 'control-label required']) }}
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
        <div class="form-group {{ $errors->has('category_name') ? ' is-invalid' : '' }}">
            {{ Form::label('category_name','Service Category Name', ['class' => 'control-label required']) }}
            {{ Form::text('category_name', $service->category_name, ['class' => 'form-control '.($errors->has('category_name') ? 'is-invalid':''), 'placeholder' => 'Service Category Name']) }}
            @if ($errors->has('category_name'))
            <span class="invalid-feedback">{{ $errors->first('category_name') }}</span>
            @endif
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" name="status" value="0" @if(isset($service) && $service->status=='0')
            checked @endif/>
            Active
            <input type="radio" name="status" value="1" @if(isset($service) && $service->status=='1')
            checked @endif/>
            InActive
            <br />
            @if ($errors->has('status'))
            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
            @endif
            <div class="error_msg"></div>
        </div>
    </div>
</div>