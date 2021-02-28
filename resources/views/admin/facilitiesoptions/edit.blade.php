<div class="msg"></div>
<div class="row">
	<div class="col-md-6">
		<input type="hidden" name="id" value="{{ $facilitiesoptions->id }}">
		<div class="form-group {{ $errors->has('title') ? ' is-invalid' : '' }}">
			{{ Form::label('title','Title', ['class' => 'control-label required']) }}
			{{ Form::text('title', $facilitiesoptions->title, ['class' => 'form-control '.($errors->has('title') ? 'is-invalid':''), 'placeholder' => 'Title']) }}
			@if ($errors->has('title'))
			<span class="invalid-feedback">{{ $errors->first('title') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
			{{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
			<br />
			<input type="radio" name="status" value="1" @if(isset($facilitiesoptions) && $facilitiesoptions->status=='1')
			checked @else checked="" @endif/>
			Active
			<input type="radio" name="status" value="0" @if(isset($facilitiesoptions) && $facilitiesoptions->status=='0')
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

