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
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('category_id') ? ' is-invalid' : '' }}">
            {{ Form::label('category_id','Company Category Name', ['class' => 'control-label required']) }}
            {{-- {{ Form::select('category_id', $companys,null, ['class' => 'form-control select2']) }} --}}
            <select class="form-control select2" name="category_id">
                @foreach($serviceCategorys as $company)
                <option value="{{ $company->id }}" {{ $company->id == $LoyaltyStores->category_id ? 'selected' : '' }}>{{ $company->lcategory_name }}</option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
            <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group  {{ $errors->has('store_name') ? ' is-invalid' : '' }}">
            {{ Form::label('store_name','Store name', ['class' => 'control-label required']) }}
            {{ Form::text('store_name', $LoyaltyStores->store_name, ['class' => 'form-control '.($errors->has('store_name') ? 'is-invalid':''), 'placeholder' => 'Store name']) }}
            @if ($errors->has('store_name'))
            <span class="invalid-feedback">{{ $errors->first('store_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group  {{ $errors->has('store_address') ? ' is-invalid' : '' }}">
            {{ Form::label('store_address','Store address', ['class' => 'control-label required']) }}
            {{ Form::textarea('store_address', $LoyaltyStores->store_address, ['class' => 'form-control '.($errors->has('store_address') ? 'is-invalid':''), 'placeholder' => 'Store address','rows'=>2]) }}
            @if ($errors->has('store_address'))
            <span class="invalid-feedback">{{ $errors->first('store_address') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="form-group  {{ $errors->has('store_offers') ? ' is-invalid' : '' }}">
                {{ Form::label('store_offers','Store offers', ['class' => 'control-label required']) }}
                {{ Form::textarea('store_offers', $LoyaltyStores->store_offers, ['class' => 'form-control '.($errors->has('store_offers') ? 'is-invalid':''), 'placeholder' => 'Store offers','rows'=>2]) }}
                @if ($errors->has('store_offers'))
                <span class="invalid-feedback">{{ $errors->first('store_offers') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>