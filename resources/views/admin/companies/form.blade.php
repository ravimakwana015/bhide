<div class="row">
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('company_name') ? ' is-invalid' : '' }}">
            {{ Form::label('company_name','Company Name', ['class' => 'control-label required']) }}
            {{ Form::text('company_name', null, ['class' => 'form-control '.($errors->has('company_name') ? 'is-invalid':''), 'placeholder' => 'Company Name']) }}
            @if ($errors->has('company_name'))
            <span class="text-danger">{{ $errors->first('company_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('person_name') ? ' is-invalid' : '' }}">
            {{ Form::label('person_name','Contact Person Name', ['class' => 'control-label required']) }}
            {{ Form::text('person_name', null, ['class' => 'form-control '.($errors->has('person_name') ? 'is-invalid':''), 'placeholder' => 'Contact Person Name']) }}
            @if ($errors->has('person_name'))
            <span class="invalid-feedback">{{ $errors->first('person_name') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
            {{ Form::label('email','Company Email', ['class' => 'control-label required']) }}
            <br/>
            @if(isset($company))
            {{ $company->email }}
            @else
            {{ Form::text('email', null, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid':''), 'placeholder' => 'Company Email']) }}
            @if ($errors->has('email'))
            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
            @endif
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('mobile') ? ' is-invalid' : '' }}">
            {{ Form::label('mobile','Mobile Number', ['class' => 'control-label required']) }}
            {{ Form::text('mobile', null, ['class' => 'form-control '.($errors->has('mobile') ? 'is-invalid':''), 'placeholder' => 'Mobile Number']) }}
            @if ($errors->has('mobile'))
            <span class="invalid-feedback">{{ $errors->first('mobile') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('landline') ? ' is-invalid' : '' }}">
            {{ Form::label('landline','Landline Number', ['class' => 'control-label required']) }}
            {{ Form::text('landline', null, ['class' => 'form-control '.($errors->has('landline') ? 'is-invalid':''), 'placeholder' => 'Landline Number']) }}
            @if ($errors->has('landline'))
            <span class="invalid-feedback">{{ $errors->first('landline') }}</span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group {{ $errors->has('subscription_time') ? ' is-invalid' : '' }}">
            {{ Form::label('subscription_time','Subscription time', ['class' => 'control-label required']) }}
            <br />
            @if(isset($company))
            {{ $company->subscription_time }}
            @else
            {!! Form::select('subscription_time', [''=> 'Select Subscription
                time','month'=>'Monthly','quarter'=>'Quarterly','year'=>'Yearly'], null,
                ['class' => 'form-control '.($errors->has('subscription_time') ? 'is-invalid':'')]) !!}
                @if ($errors->has('subscription_time'))
                <span class="invalid-feedback">{{ $errors->first('subscription_time') }}</span>
                @endif
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('package_amount') ? ' is-invalid' : '' }}">
                {{ Form::label('package_amount','Package Amount', ['class' => 'control-label required']) }}
                <br />
                @if(isset($company))
                {{ $company->package_amount }}
                @else
                {{ Form::number('package_amount', null, ['class' => 'form-control package_amount '.($errors->has('package_amount') ? 'is-invalid':''), 'placeholder' => 'Package Amount']) }}
                @if ($errors->has('package_amount'))
                <span class="invalid-feedback">{{ $errors->first('package_amount') }}</span>
                @endif
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('apartment_count') ? ' is-invalid' : '' }}">
                {{ Form::label('apartment_count','Apartment Count', ['class' => 'control-label required']) }}
                <br />
                @if(isset($company))
                {{ $company->apartment_count }}
                @else
                {{ Form::number('apartment_count', null, ['class' => 'form-control apartment_count '.($errors->has('apartment_count') ? 'is-invalid':''), 'placeholder' => 'Apartment Count']) }}
                @if ($errors->has('apartment_count'))
                <span class="invalid-feedback">{{ $errors->first('apartment_count') }}</span>
                @endif
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('per_apartment_amount') ? ' is-invalid' : '' }}">
                {{ Form::label('per_apartment_amount','Per Apartment Amount', ['class' => 'control-label required']) }}
                <br />
                {{-- @if(isset($company))
                {{ $company->per_apartment_amount }}
                @else --}}
                {{-- @if(isset($settings->default_apartment_price))
                {{ Form::number('per_apartment_amount', $settings->default_apartment_price, ['class' => 'form-control per_apartment_amount '.($errors->has('per_apartment_amount') ? 'is-invalid':''), 'placeholder' => 'Per Apartment Amount']) }}
                @else --}}
                @if(isset($company))
                <span class="per_apartment_amount">{{ $company->per_apartment_amount }}</span>
                @else
                <span id="per_apartment_amount" class="per_apartment_amount">0</span>
                @endif
                {{ Form::hidden('per_apartment_amount', null, ['class' => 'form-control per_apartment_amount '.($errors->has('per_apartment_amount') ? 'is-invalid':''), 'placeholder' => 'Per Apartment Amount']) }}
                {{-- @endif --}}
                @if ($errors->has('per_apartment_amount'))
                <span class="invalid-feedback">{{ $errors->first('per_apartment_amount') }}</span>
                @endif
                {{-- @endif --}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('subscription_amount') ? ' is-invalid' : '' }}">
                {{ Form::label('subscription_amount','Subscription Amount', ['class' => 'control-label required']) }}
                <br />
                @if(isset($company))
                <span class="subscription_amount">{{ $company->subscription_amount }}</span>
                @else
                <span id="SubAmount" class="subscription_amount">0</span>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group {{ $errors->has('building_address') ? ' is-invalid' : '' }}">
                {{ Form::label('building_address','Building Address', ['class' => 'control-label required']) }}
                <br/>
                @if(isset($company))
                {{ $company->building_address }}
                @else
                {{ Form::textarea('building_address', null, ['class' => 'form-control '.($errors->has('building_address') ? 'is-invalid':''), 'placeholder' => 'Building Address', 'rows'=>"3"]) }}
                @if ($errors->has('building_address'))
                <span class="invalid-feedback">{{ $errors->first('building_address') }}</span>
                @endif
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('company_address') ? ' is-invalid' : '' }}">
                {{ Form::label('company_address','Company Address', ['class' => 'control-label required']) }}
                {{ Form::textarea('company_address', null, ['class' => 'form-control '.($errors->has('company_address') ? 'is-invalid':''), 'placeholder' => 'Company Address', 'rows'=>"3"]) }}
                @if ($errors->has('company_address'))
                <span class="invalid-feedback">{{ $errors->first('company_address') }}</span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('building_image', 'Building Image', ['class' => 'control-label required']) }}
                <input type="hidden" name="image_name" id="profile-img-tag-textarea">
                @if(isset($company->building_image))
                <input type="file" name="building_image" id="building_image-1" class="inputfile inputfile-1" value="{{ $company->building_image }}" />
                <br/>
                <br/>
                <img src="{{ asset('public/front/building_image/' . $company->building_image) }}" width="80" height="80" id="career_img">
                @else
                <input type="file" accept="image/*" name="building_image" id="building_image-1" class="inputfile inputfile-1"/>
                <br/>
                @endif
                @include('profile.image-crop-wrap')
            </div>
            <span class="text-danger" id="image-dimension"></span>
        </div>
        <div class="col-md-4">
            <div class="form-group {{ $errors->has('payment_type') ? ' is-invalid' : '' }}">
                {{ Form::label('payment_type', 'Payment Type', ['class' =>'control-label required']) }}
                <br />
                <input type="radio" name="payment_type" value="1" checked=" " @if(isset($pages) && $pages->status=='1') checked @else checked @endif/>
                Offline
                <input type="radio" name="payment_type" value="0" @if(isset($pages) && $pages->status=='0') checked @endif/>
                Online
                <br />
                @if ($errors->has('payment_type'))
                <span class="invalid-feedback">{{ $errors->first('payment_type') }}</span>
                @endif
                <div class="error_msg"></div>
            </div>
        </div>
    </div>
