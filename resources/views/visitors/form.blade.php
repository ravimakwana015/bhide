<div class="row">
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('gate_id') ? ' is-invalid' : '' }}">
            {{ Form::label('gate_id','Choose Core', ['class' => 'control-label required']) }}
            <br />
            @if(isset($visitor))
            <div id="new_gate">
                @foreach ($gates as $key=>$gate)
                <input type="radio" name="gate_id" value="{{ $key }}" @if($visitor->gate_id==$key) checked @endif/> {{ $gate }}
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
        <button type="button" onclick="addRemoveGate('{{ route('get.gates') }}')" style="margin-top:30px;"
            class="btn btn-primary btn-sm">Add or remove Core</button>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('reason_id') ? ' is-invalid' : '' }}">
            {{ Form::label('reason_id','Reason For Visit', ['class' => 'control-label required']) }}
            <br />
            @if(isset($visitor))
            {{ Form::select('reason_id', $reasons,$visitor->reason_id, ['class' => 'form-control', 'id'=>'reason_select']) }}
            @else
            {{ Form::select('reason_id', $reasons,null, ['class' => 'form-control', 'id'=>'reason_select']) }}
            @endif
            @if ($errors->has('reason_id'))
            <span class="invalid-feedback">{{ $errors->first('reason_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <button type="button" onclick="addRemoveReason('{{ route('get.reasons') }}')" style="margin-top:30px;"
            class="btn btn-primary btn-sm">Add Or Remove reason</button>
    </div>
</div>
<hr />
<div class="row">
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('unit_id') ? ' is-invalid' : '' }}">
            {{ Form::label('unit_id','Apartment Number', ['class' => 'control-label required']) }}
            {{ Form::select('unit_id', $flats,null, ['class' => 'select2']) }}
            @if ($errors->has('unit_id'))
            <span class="invalid-feedback">{{ $errors->first('unit_id') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('check_in_date') ? ' is-invalid' : '' }}">
            {{ Form::label('check_in_date','Check In Date', ['class' => 'control-label required']) }}
            <br />
            {{ Form::text('check_in_date', null, ['class' => 'form-control datetimepicker '.($errors->has('check_in_date') ? 'is-invalid':''), 'placeholder' => 'Check In Date','readonly']) }}
            @if ($errors->has('check_in_date'))
            <span class="invalid-feedback">{{ $errors->first('check_in_date') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('check_in_time') ? ' is-invalid' : '' }}">
            {{ Form::label('check_in_time','Check In Time', ['class' => 'control-label required']) }}
            <br />
            {{ Form::text('check_in_time', null, ['class' => 'form-control check_in_time'.($errors->has('check_in_time') ? 'is-invalid':''), 'placeholder' => 'Check In Time' ,'readonly']) }}
            @if ($errors->has('check_in_time'))
            <span class="invalid-feedback">{{ $errors->first('check_in_time') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('visitor_name') ? ' is-invalid' : '' }}">
            {{ Form::label('visitor_name','Visitor Name', ['class' => 'control-label required']) }}
            {{ Form::text('visitor_name', null, ['class' => 'form-control'.($errors->has('visitor_name') ? 'is-invalid':''), 'placeholder' => 'Visitor Name']) }}
            @if ($errors->has('visitor_name'))
            <span class="invalid-feedback">{{ $errors->first('visitor_name') }}</span>
            @endif
        </div>
    </div>
    {{-- <div class="col-md-3">
        <div class="form-group {{ $errors->has('description') ? ' is-invalid' : '' }}">
            {{ Form::label('description','Visitor Address', ['class' => 'control-label required']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control'.($errors->has('description') ? 'is-invalid':''), 'placeholder' => 'Visitor Address','rows'=>'1']) }}
            @if ($errors->has('description'))
            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
            @endif
        </div>
    </div> --}}
    
    {{-- <div class="col-md-3">
        <div class="form-group {{ $errors->has('id_name') ? ' is-invalid' : '' }}">
            {{ Form::label('id_name','ID Name', ['class' => 'control-label required']) }}
            {{ Form::text('id_name', null, ['class' => 'form-control'.($errors->has('id_name') ? 'is-invalid':''), 'placeholder' => 'ID Name']) }}
            @if ($errors->has('id_name'))
            <span class="invalid-feedback">{{ $errors->first('id_name') }}</span>
            @endif
        </div>
    </div> --}}
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('id_number') ? ' is-invalid' : '' }}">
            {{ Form::label('id_number','ID Number', ['class' => 'control-label required']) }}
            {{ Form::text('id_number', null, ['class' => 'form-control'.($errors->has('id_number') ? 'is-invalid':''), 'placeholder' => 'ID Number']) }}
            @if ($errors->has('id_number'))
            <span class="invalid-feedback">{{ $errors->first('id_number') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('vehicle_number') ? ' is-invalid' : '' }}">
            {{ Form::label('vehicle_number','Vehicle Number', ['class' => 'control-label required']) }}
            {{ Form::text('vehicle_number', null, ['class' => 'form-control'.($errors->has('vehicle_number') ? 'is-invalid':''), 'placeholder' => 'Vehicle Number']) }}
            @if ($errors->has('vehicle_number'))
            <span class="invalid-feedback">{{ $errors->first('vehicle_number') }}</span>
            @endif
        </div>
    </div>
</div>
