<div class="box-body">
	<div class="row">
		<div class="col-md-11">
			<div class="form-group">
				{{ Form::label('Page Title','Page Title', ['class' => 'control-label required']) }}
				{{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Page Title']) }}
				@if ($errors->has('title'))
				<span class="text-danger">{{ $errors->first('title') }}</span>
				@endif
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{{ Form::label('Content',"Content", ['class' => 'control-label required']) }}
				{{ Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => "content",'id'=>'page_description']) }}
				@if ($errors->has('content'))
				<span class="text-danger">{{ $errors->first('content') }}</span>
				@endif
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-11">
			<div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
				{{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
				<br />
				<input type="radio" name="status" value="1" checked=" " @if(isset($pages) && $pages->status=='1') checked @else checked @endif/>
				Active
				<input type="radio" name="status" value="0" @if(isset($pages) && $pages->status=='0') checked @endif/>
				In Active
				<br />
				@if ($errors->has('status'))
				<span class="invalid-feedback">{{ $errors->first('status') }}</span>
				@endif
				<div class="error_msg"></div>
			</div>
		</div>
	</div>
</div>
