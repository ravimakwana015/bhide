<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('title') ? ' is-invalid' : '' }}">
            {{ Form::label('title','Notice Title', ['class' => 'control-label required']) }}
            {{ Form::text('title', null, ['class' => 'form-control '.($errors->has('title') ? 'is-invalid':''), 'placeholder' => 'Notice Title']) }}
            @if ($errors->has('title'))
            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('description') ? ' is-invalid' : '' }}">
            {{ Form::label('description','Notice Description', ['class' => 'control-label required']) }}
            {{ Form::text('description', null, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid':''), 'placeholder' => 'Notice Description']) }}
            @if ($errors->has('description'))
            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" name="status" value="1" @if(isset($messageBoard) && $messageBoard->status=='1') checked @endif/>
            Active
            <input type="radio" name="status" value="0" @if(isset($messageBoard) && $messageBoard->status=='0') checked @endif/>
            In Active
            <br />
            @if ($errors->has('status'))
            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {{ $errors->has('notice_valid_until') ? ' is-invalid' : '' }}">
            {{ Form::label('notice_valid_until','Notice Valid Until', ['class' => 'control-label required']) }}
            <br />
            {{ Form::text('notice_valid_until', null, ['class' => 'form-control datetimepicker '.($errors->has('notice_valid_until') ? 'is-invalid':''), 'placeholder' => 'Notice Valid Until','readonly']) }}
            @if ($errors->has('notice_valid_until'))
            <span class="invalid-feedback">{{ $errors->first('notice_valid_until') }}</span>
            @endif
        </div>
    </div>
</div>
