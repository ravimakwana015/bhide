<div class="row">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('title') ? ' is-invalid' : '' }}">
            {{ Form::label('title','Poll Title', ['class' => 'control-label required']) }}
            {{ Form::text('title', null, ['class' => 'form-control '.($errors->has('title') ? 'is-invalid':''), 'placeholder' => 'Poll Title']) }}
            @if ($errors->has('title'))
            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('poll_valid_until') ? ' is-invalid' : '' }}">
            {{ Form::label('poll_valid_until','Poll Valid Until', ['class' => 'control-label required']) }}
            <br />
            {{ Form::text('poll_valid_until', null, ['class' => 'form-control datetimepicker '.($errors->has('poll_valid_until') ? 'is-invalid':''), 'placeholder' => 'Poll Valid Until','readonly']) }}
            @if ($errors->has('poll_valid_until'))
            <span class="invalid-feedback">{{ $errors->first('poll_valid_until') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
            <br />
            <input type="radio" name="status" value="1" @if(isset($poll) && $poll->status=='1') checked @else checked @endif/>
            Active
            <input type="radio" name="status" value="0" @if(isset($poll) && $poll->status=='0') checked @endif/>
            In Active
            <br />
            @if ($errors->has('status'))
            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
            @endif
        </div>
    </div>
</div>
<hr />
<h4>Options</h4>
<hr />
<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-4">
        <a class="store_details btn" href="javascript:;">Add Option</a>
    </div>
</div>
<br />
@php
$count=2;
if(isset($poll)){
$options = $poll->options;
$count=count($options);
}
@endphp
@if(isset($poll))
@if(count($options))
@foreach ($options as $key=>$val)
<div class="row remove_{{ $key }}">
    <div class="col-6">
        <input type="hidden" name="id[]" id="option_{{ $key }}" value="{{ $val['id'] }}" />
        <div class="form-group">
            <label>Option {{ $key+1 }}</label>
            <input type="text" class="form-control" name="options[]" value="{{ $val['option'] }}">
        </div>
    </div>
    @if($key>1)
    <div class="col-md-4">
        <a class="remove-field btn" data-id="{{ $key }}" href="javascript:;">Remove</a>
    </div>
    @endif
</div>
@endforeach
@endif
@else
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label>Option 1</label>
            <input type="text" class="form-control" name="options[]">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label>Option 2</label>
            <input type="text" class="form-control" name="options[]">
        </div>
    </div>
</div>
@endif
<input type="hidden" value="{{ $count }}" id="count" />
<div class="store_details_dynamic"></div>
