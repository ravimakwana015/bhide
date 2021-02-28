<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('block_number') ? ' is-invalid' : '' }}">
            {{ Form::label('block_number','Core', ['class' => 'control-label required']) }}
            {{ Form::text('block_number', null, ['class' => 'form-control '.($errors->has('block_number') ? 'is-invalid':''), 'placeholder' => 'Core']) }}
            @if ($errors->has('block_number'))
            <span class="invalid-feedback">{{ $errors->first('block_number') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('flat_number') ? ' is-invalid' : '' }}">
            {{ Form::label('flat_number','Apartment Number', ['class' => 'control-label required']) }}
            {{ Form::text('flat_number', null, ['class' => 'form-control '.($errors->has('flat_number') ? 'is-invalid':''), 'placeholder' => 'Apartment Number']) }}
            @if ($errors->has('flat_number'))
            <span class="invalid-feedback">{{ $errors->first('flat_number') }}</span>
            @endif
        </div>
    </div>
</div>
