<div class="box-body">
	<div class="col-md-6">
							<div class="form-group {{ $errors->has('title') ? ' is-invalid' : '' }}">
								{{ Form::label('title','Title', ['class' => 'control-label required']) }}
								{{ Form::text('title', null, ['class' => 'form-control '.($errors->has('title') ? 'is-invalid':''), 'placeholder' => 'Title']) }}
								@if ($errors->has('title'))
								<span class="invalid-feedback">{{ $errors->first('title') }}</span>
								@endif
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
								{{ Form::label('status', 'Feature Image', ['class' =>'control-label required']) }}
                                @if(isset($companySettings->feature_image))
                                <img src="{{ asset('public/front/features_image/' . $companySettings->feature_image) }}" width="80" height="80" id="career_img">
                               
                                <input name="feature_image" value="{{ $companySettings->feature_image }}" type="file" placeholder="Feature Image">
                                @else
								<input name="feature_image" value="{{ old('feature_image') }}" type="file" placeholder="Feature Image">
                                @endif
								@if ($errors->has('status'))
								<span class="invalid-feedback">{{ $errors->first('status') }}</span>
								@endif
								<div class="error_msg"></div>
							</div>
						</div>
	
<hr />
<h4>Content</h4>
<hr />
<div class="row">
    <div class="col-md-6">
    </div>
    <div class="col-md-6">
        <a class="store_details btn" href="javascript:;">Add More Content</a>
    </div>
</div>
<br />
@php
$count=1;
if(isset($companySettings) && !empty($companySettings->content) && !empty($companySettings->subtitle)){
    $content = json_decode($companySettings->content,true);
    $subtitle = json_decode($companySettings->subtitle,true);

    $doubledicker = array_combine($content, $subtitle);

    $count=count($content);
}
@endphp
<input type="hidden" value="{{ $count }}" id="count" />
@if(isset($companySettings) && !empty($companySettings->content) && !empty($companySettings->subtitle))
@if(count($content))
@php
 $i = 0;   
@endphp
@foreach ($doubledicker as $key=>$val)
<div class="row remove_{{ $key }}">
    <div class="col-3">
        <div class="form-group">
            <label>Content Sub Title -{{ $i+1 }}</label>
            <input type="text" class="form-control" name="subtitle[]" value="{{ $val }}">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label>Content-{{ $i+1 }}</label>
            <textarea class="form-control" name="content[]">{{ $key }}</textarea>
        </div>
    </div>
    @if($i>0)
    <div class="col-md-4">
        <label>&nbsp;</label> <br />
        <a class="remove-field btn" data-id="{{ $key }}" href="javascript:;">Remove</a>
    </div>
    @endif
</div>
@php
 $i++;   
@endphp
@endforeach
@endif
@else
<div class="row">
    <div class="col-3">
        <div class="form-group">
            <label>Content Sub Title-1</label>
            <input type="text" class="form-control" name="subtitle[]">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label>Content-1</label>
            <textarea class="form-control" name="content[]"></textarea>
            {{-- <input type="text" class="form-control" name="content[]"> --}}
        </div>
    </div>
</div>
@endif
<div class="store_details_dynamic"></div>
</div>
