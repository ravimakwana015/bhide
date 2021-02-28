<div class="msg"></div>
<div class="row">
	<div class="col-md-6">
		<input type="hidden" name="id" value="{{ $pages->id }}">
		<div class="form-group {{ $errors->has('title') ? ' is-invalid' : '' }}">
			{{ Form::label('title','Page Title', ['class' => 'control-label required']) }}
			{{ Form::text('title', $pages->title, ['class' => 'form-control '.($errors->has('title') ? 'is-invalid':''), 'placeholder' => 'Page Title']) }}
			@if ($errors->has('title'))
			<span class="invalid-feedback">{{ $errors->first('title') }}</span>
			@endif
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
			{{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
			<br />
			<input type="radio" name="status" value="1" @if(isset($pages) && $pages->status=='1')
			checked @else checked="" @endif/>
			Active
			<input type="radio" name="status" value="0" @if(isset($pages) && $pages->status=='0')
			checked @endif/>
			Inactive
			<br />
			@if ($errors->has('status'))
			<span class="invalid-feedback">{{ $errors->first('status') }}</span>
			@endif
			<div class="error_msg"></div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group {{ $errors->has('content') ? ' is-invalid' : '' }}">
			{{ Form::label('content','Content', ['class' => 'control-label required']) }}
			{{ Form::textarea('content', $pages->content, ['class' => 'form-control'.($errors->has('content') ? 'is-invalid':''), 'placeholder' => 'Content','rows'=>'1','id'=>'editcontent']) }}
			@if ($errors->has('content'))
			<span class="invalid-feedback">{{ $errors->first('content') }}</span>
			@endif
		</div>
	</div>
</div>

