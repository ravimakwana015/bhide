<div class="msg"></div>
<div class="row">
    <input type="hidden" name="id" value="{{ $parcels->id }}">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
            {{ Form::label('company_id','Company Name', ['class' => 'control-label required']) }}
            
            <select class="form-control select2" name="company_id" id="companysids">
                @foreach($companys as $company)
                <option value="{{ $company->id }}" {{ $company->id == $parcels->company_id ? 'selected' : '' }}>{{ $company->company_name }}</option>
                @endforeach
            </select>
            @if ($errors->has('company_id'))
            <span class="invalid-feedback">{{ $errors->first('company_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('unit_id') ? ' is-invalid' : '' }}">
            {{ Form::label('unit_id','Apartment Units', ['class' => 'control-label required']) }}
            <br/>
            {{-- {{ Form::select('unit_id', $flats,'unit_id', ['class' => 'select2']) }} --}}
            <select class="form-control select2" name="unit_id">
                @foreach($units as $unit)
                <option value="{{ $unit->id }}" {{ $unit->id == $parcels->unit_id ? 'selected' : '' }}>{{ $unit->block_number }}-{{ $unit->flat_number }}</option>
                @endforeach
            </select>
            @if ($errors->has('unit_id'))
            <span class="invalid-feedback">{{ $errors->first('unit_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('total_parcel') ? ' is-invalid' : '' }}">
            {{ Form::label('total_parcel','How many parcels', ['class' => 'control-label required']) }}
            {{ Form::text('total_parcel', $parcels->total_parcel, ['class' => 'form-control'.($errors->has('total_parcel') ? 'is-invalid':''), 'placeholder' => 'How many parcels']) }}
            @if ($errors->has('total_parcel'))
            <span class="invalid-feedback">{{ $errors->first('total_parcel') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" name="status" value="0" @if(isset($parcels) && $parcels->status=='0') checked  @endif/>
            Pending
            <input type="radio" name="status" value="1" @if(isset($parcels) && $parcels->status=='1') checked @endif/>
            Collected
            <br />
            @if ($errors->has('status'))
            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
            @endif
            <div class="error_msg"></div>
        </div>
    </div>
    @if(isset($parcels))
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('name') ? ' is-invalid' : '' }}">
            {{ Form::label('name','Collected By', ['class' => 'control-label required']) }}
            {{ Form::text('name', $parcels->name, ['class' => 'form-control'.($errors->has('name') ? 'is-invalid':''), 'placeholder' => 'Collected By']) }}
            @if ($errors->has('name'))
            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
            @endif
        </div>
    </div>
    @endif
</div>