<div class="modal fade bd-example-modal-lg" id="addService" tabindex="-1" role="dialog"
    aria-labelledby="addServiceTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Add Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'services.store','role' => 'form', 'method' => 'post', 'id' => 'create-service']) }}
            <div class="modal-body">
                <div class="msg"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="{{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                            {{ Form::label('category_id','Service Category', ['class' => 'control-label required']) }}
                            {{ Form::select('category_id', $flats,null, ['class' => 'form-control']) }}
                            @if ($errors->has('category_id'))
                            <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('service_name') ? ' is-invalid' : '' }}">
                            {{ Form::label('service_name','Type of Service', ['class' => 'control-label required']) }}
                            {{ Form::text('service_name', null, ['class' => 'form-control '.($errors->has('service_name') ? 'is-invalid':''), 'placeholder' => 'Type of Service']) }}
                            @if ($errors->has('service_name'))
                            <span class="invalid-feedback">{{ $errors->first('service_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('service_provider_name') ? ' is-invalid' : '' }}">
                            {{ Form::label('service_provider_name','Service Provider', ['class' => 'control-label required']) }}
                            {{ Form::text('service_provider_name', null, ['class' => 'form-control '.($errors->has('service_provider_name') ? 'is-invalid':''), 'placeholder' => 'Service Provider']) }}
                            @if ($errors->has('service_provider_name'))
                            <span class="invalid-feedback">{{ $errors->first('service_provider_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('contact_number') ? ' is-invalid' : '' }}">
                            {{ Form::label('contact_number','Contact Number', ['class' => 'control-label required']) }}
                            {{ Form::text('contact_number', null, ['class' => 'form-control '.($errors->has('contact_number') ? 'is-invalid':''), 'placeholder' => 'Contact Number']) }}
                            @if ($errors->has('contact_number'))
                            <span class="invalid-feedback">{{ $errors->first('contact_number') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="form-group {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}">
                            {{ Form::label('mobile_number','Mobile Number', ['class' => 'control-label required']) }}
                            {{ Form::text('mobile_number', null, ['class' => 'form-control '.($errors->has('mobile_number') ? 'is-invalid':''), 'placeholder' => 'Mobile Number']) }}
                            @if ($errors->has('mobile_number'))
                            <span class="invalid-feedback">{{ $errors->first('mobile_number') }}</span>
                            @endif
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
                            {{ Form::label('email','Email', ['class' => 'control-label required']) }}
                            {{ Form::text('email', null, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid':''), 'placeholder' => 'Email']) }}
                            @if ($errors->has('email'))
                            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('address') ? ' is-invalid' : '' }}">
                            {{ Form::label('address','Location', ['class' => 'control-label required']) }}
                            {{ Form::textarea('address', null, ['class' => 'form-control'.($errors->has('address') ? 'is-invalid':''), 'placeholder' => 'Location','rows'=>'1']) }}
                            @if ($errors->has('address'))
                            <span class="invalid-feedback">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
                            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
                            <br />
                            <input type="radio" name="status" value="1" @if(isset($service) && $service->status=='1')
                            checked @else checked @endif/>
                            Open
                            <input type="radio" name="status" value="0" @if(isset($service) && $service->status=='0')
                            checked @endif/>
                            Close
                            <br />
                            @if ($errors->has('status'))
                            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
                            @endif
                            <div class="error_msg"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Submit</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
