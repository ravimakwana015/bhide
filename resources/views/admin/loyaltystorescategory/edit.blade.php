<div class="msg"></div>
<div class="row">
    <input type="hidden" name="id" value="{{ $LoyaltyStores->id }}">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
            {{ Form::label('company_id','Company Name', ['class' => 'control-label required']) }}
            {{-- {{ Form::select('company_id', $companys,null, ['class' => 'form-control select2']) }} --}}
            <select class="form-control select2" name="company_id">
                @foreach($companys as $company)
                <option value="{{ $company->id }}" {{ $company->id == $LoyaltyStores->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                @endforeach
            </select>
            @if ($errors->has('company_id'))
            <span class="invalid-feedback">{{ $errors->first('company_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-4">
        <div class="form-group  {{ $errors->has('lcategory_name') ? ' is-invalid' : '' }}">
            {{ Form::label('lcategory_name','Store Category Name', ['class' => 'control-label required']) }}
            {{ Form::text('lcategory_name', $LoyaltyStores->lcategory_name, ['class' => 'form-control '.($errors->has('lcategory_name') ? 'is-invalid':''), 'placeholder' => 'Store Category Name']) }}
            @if ($errors->has('lcategory_name'))
            <span class="invalid-feedback">{{ $errors->first('lcategory_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" name="status" value="0" checked=" " @if(isset($LoyaltyStores) && $LoyaltyStores->status=='0')
            checked @endif/>
            Active
            <input type="radio" name="status" value="1" @if(isset($LoyaltyStores) && $LoyaltyStores->status=='1')
            checked @endif/>
            Inactive
            <br />
            @if ($errors->has('status'))
            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
            @endif
            <div class="error_msg"></div>
        </div>
    </div>
</div>