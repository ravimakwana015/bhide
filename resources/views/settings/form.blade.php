<div class="row">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('loyalty_card_image') ? ' is-invalid' : '' }}">
            {{ Form::label('loyalty_card_image', 'Loyalty Card Image', ['class' => 'control-label required']) }}
            <input type="hidden" name="loyalty_cardimage" id="loyalty_cardimage">
            @if(!empty($companySettings->loyalty_card_image))
            <input type="file" name="loyalty_card_image" id="loyalty_card_image-1" class="inputfile inputfile-1" value="{{ $companySettings->loyalty_card_image }}" />
            <br/>
            <div style="padding-top: 10px;">
                <img src="{{ asset('storage/app/img/loyaltyCard/' . $companySettings->loyalty_card_image) }}" width="180"height="180" id="career_img">
            </div>
            @else
            <input type="file" name="loyalty_card_image" id="loyalty_card_image-1" class="inputfile inputfile-1" />
            <br />
            @endif
            <br />
            @include("settings.image-crop-wrap")
            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
<hr />
<h4>Emergency Numbers</h4>
<hr />
<div class="row">
    <div class="col-md-12">
        <a class="store_details btn" href="javascript:;">Add More Emergency Numbers</a>
    </div>
</div>
<br />
@php
$count=1;
if(isset($companySettings) && !empty($companySettings->emergency_numbers) && !empty($companySettings->emergency_captions)){
    $emergency_numbers = json_decode($companySettings->emergency_numbers,true);
    $emergency_captions = json_decode($companySettings->emergency_captions,true);

    $doubledicker = array_combine($emergency_numbers, $emergency_captions);

    $count=count($emergency_numbers);
}
@endphp
<input type="hidden" value="{{ $count }}" id="count" />
@if(isset($companySettings) && !empty($companySettings->emergency_numbers) && !empty($companySettings->emergency_captions))
@if(count($emergency_numbers))
@php
 $i = 0;   
@endphp
@foreach ($doubledicker as $key=>$val)
<div class="row remove_{{ $key }} mb-5">
    <div class="col-md-3">
        <div class="form-group">
            <label>Title / Name -{{ $i+1 }}</label>
            <input type="text" class="form-control" name="emergency_captions[]" value="{{ $val }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Contact Number -{{ $i+1 }}</label>
            <input type="text" class="form-control" name="emergency_numbers[]" value="{{ $key }}">
        </div>
    </div>
    @if($key>0)
    <div class="col-md-4">
        </br>
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
    <div class="col-md-3">
        <div class="form-group">
            <label>Emergency Caption-1</label>
            <input type="text" class="form-control" name="emergency_captions[]">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Emergency Numbers-1</label>
            <input type="text" class="form-control" name="emergency_numbers[]">
        </div>
    </div>
</div>
@endif
<div class="store_details_dynamic"></div>
