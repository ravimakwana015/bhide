@extends('layouts.app')

@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Edit Building Details') }}</h3>
            </div>
            <div class="btn-wrap" style="padding-left: 0px;">
                <a class="btn mb-0" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form enctype="multipart/form-data" action="{{ route("update", [\Auth::user()->id]) }}" method="POST"
                id="profile_form" autocomplete="off">
                @csrf
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('company_name') ? ' is-invalid' : '' }}">
                            {{ Form::label('company_name','Building Name', ['class' => 'control-label required']) }}
                            {{ Form::text('company_name', Auth::user()->company->company_name, ['class' => 'form-control '.($errors->has('company_name') ? 'is-invalid':''), 'placeholder' => 'Building Name']) }}
                            @if ($errors->has('company_name'))
                            <span class="text-danger">{{ $errors->first('company_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('person_name') ? ' is-invalid' : '' }}">
                            {{ Form::label('person_name','Building Manager', ['class' => 'control-label required']) }}
                            {{ Form::text('person_name', Auth::user()->company->person_name, ['class' => 'form-control '.($errors->has('person_name') ? 'is-invalid':''), 'placeholder' => 'Building Manager']) }}
                            @if ($errors->has('person_name'))
                            <span class="invalid-feedback">{{ $errors->first('person_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
                            {{ Form::label('email','Building Email', ['class' => 'control-label required']) }}
                            <br />
                            @if(isset(Auth::user()->company->email))
                            {{ Auth::user()->company->email }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('mobile') ? ' is-invalid' : '' }}">
                            {{ Form::label('mobile','Mobile Number', ['class' => 'control-label required']) }}
                            {{ Form::text('mobile', Auth::user()->company->mobile, ['class' => 'form-control '.($errors->has('mobile') ? 'is-invalid':''), 'placeholder' => 'Mobile Number']) }}
                            @if ($errors->has('mobile'))
                            <span class="invalid-feedback">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('landline') ? ' is-invalid' : '' }}">
                            {{ Form::label('landline','Landline Number', ['class' => 'control-label required']) }}
                            {{ Form::text('landline', Auth::user()->company->landline, ['class' => 'form-control '.($errors->has('landline') ? 'is-invalid':''), 'placeholder' => 'Landline Number']) }}
                            @if ($errors->has('landline'))
                            <span class="invalid-feedback">{{ $errors->first('landline') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('subscription_time') ? ' is-invalid' : '' }}">
                            {{ Form::label('subscription_time','Subscription Renewal', ['class' => 'control-label required']) }}
                            <br />
                            @if(isset(Auth::user()->company->subscription_time))
                            {{ Auth::user()->company->subscription_time }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('apartment_count') ? ' is-invalid' : '' }}">
                            {{ Form::label('apartment_count','Number of Apartments', ['class' => 'control-label required']) }}
                            <br />
                            @if(isset(Auth::user()->company))
                            {{ Auth::user()->company->apartment_count }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('per_apartment_amount') ? ' is-invalid' : '' }}">
                            {{ Form::label('per_apartment_amount','Apartment Fee', ['class' => 'control-label required']) }}
                            <br />
                            @if(isset(Auth::user()->company->per_apartment_amount))
                            {{ $settings->currency_symbol }}{{ number_format(Auth::user()->company->per_apartment_amount,2) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('subscription_amount') ? ' is-invalid' : '' }}">
                            {{ Form::label('subscription_amount','Total Subscription Amount', ['class' => 'control-label required']) }}
                            <br />
                            @if(isset(Auth::user()->company->subscription_amount))
                            {{ $settings->currency_symbol }}{{ number_format(Auth::user()->company->subscription_amount,2) }}
                            @endif
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="form-group {{ $errors->has('company_address') ? ' is-invalid' : '' }}">
                            {{ Form::label('company_address','Company Address', ['class' => 'control-label required']) }}
                            {{ Form::textarea('company_address', Auth::user()->company->company_address, ['class' => 'form-control '.($errors->has('company_address') ? 'is-invalid':''), 'placeholder' => 'Company Address', 'rows'=>"3"]) }}
                            @if ($errors->has('company_address'))
                            <span class="invalid-feedback">{{ $errors->first('company_address') }}</span>
                            @endif
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('building_address') ? ' is-invalid' : '' }}">
                            {{ Form::label('building_address','Building Address', ['class' => 'control-label required']) }}
                            <br />
                            @if(isset(Auth::user()->company->building_address))
                            {{ Auth::user()->company->building_address }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{ Form::label('building_image', 'Building Image', ['class' => 'control-label required']) }}
                            <input type="hidden" name="image_name" id="profile-img-tag-textarea">
                            @if(isset(Auth::user()->company->building_image))
                            <input type="file" name="building_image" id="building_image-1" class="inputfile inputfile-1" value="{{ Auth::user()->company->building_image }}" />
                            <br/>
                            <br/>
                            <img src="{{ asset('public/front/building_image/' . Auth::user()->company->building_image) }}" width="80" height="80" id="career_img">
                            @else
                            <input type="file" accept="image/*" name="building_image" id="building_image-1" class="inputfile inputfile-1"/>
                            <br/>
                            @endif
                            @include('profile.image-crop-wrap')
                        </div>
                        <span class="text-danger" id="image-dimension"></span>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" id="profile_submit">{{__('Save Details')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')

<script>
    $(document).ready(function() {
        $("#profile_form").validate({
            rules: {
                'company_name':{
                    'required': true
                },
                'person_name':{
                    'required': true
                },
                'mobile':{
                    'required': true,
                    minlength:11,
                    maxlength:11,
                    digits: true,
                },
                'landline':{
                    'required': true,
                    minlength:10,
                    maxlength:10,
                    digits: true,
                },
                'company_address':{
                    'required': true
                },
            },
            messages: {
                'mobile':{
                    minlength:'Please Enter Valid Mobile No',
                    maxlength:'Please Enter Valid Mobile No',
                },
                'landline':{
                    minlength:'Please Enter Valid Landline Number',
                    maxlength:'Please Enter Valid Landline Number',
                }
            },
        });
    });
</script>


<script>
    var resize = $('#upload-demo').croppie({
        enableExif: true,
        viewport: { 
            width: 300,
            height: 300,
            type: 'square'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $('#building_image-1').on('change', function () {
        $('#myModal').show('model');
        var reader = new FileReader();
        reader.onload = function (e) {
            resize.croppie('bind',{
                points: [77,469,280,739],
                url: e.target.result
            }).then(function(){
                resize.croppie('setZoom', 0.2);
                $('.profile-image-preview').addClass('active');
                $('body').addClass('profile-popup');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#close_image_crop').click(function(event) {
        $('.profile-image-preview').removeClass('active');
        $('body').removeClass('profile-popup');
        $('#building_image-1').val('');
        $('#myModal').hide('model');
    });

    $('.upload-image').on('click', function (ev) {
        resize.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (img) {
            $('#loading').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('upload-profile-pic') }}",
                type: "POST",
                data: {"image":img},
                success: function (data) {
                    $('#myModal').hide('model');
                    $('#loading').hide(); 
                    var path ='{{ asset('public/front/building_image/') }}';
                    $('#profile-img-tag').attr('src', path+'/'+data);
                    $('#profile-img-tag-textarea').val(data);

                    $('#yellowbutton').trigger('click');
                    setTimeout(function() { 
                        $('#loadings').hide(); 
                    }, 4000);
                }
            });
        });
    });
</script>

@endpush
