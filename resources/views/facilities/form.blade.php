<div class="modal fade bd-example-modal-lg" id="addFacility" tabindex="-1" role="dialog"
    aria-labelledby="addFacilityTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Add Facility</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'facilities.store','role' => 'form', 'method' => 'post', 'id' => 'create-facility']) }}
            <div class="modal-body">
                <div class="msg"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('facility_name') ? ' is-invalid' : '' }}">
                            {{ Form::label('facility_name','Facility Name', ['class' => 'control-label required']) }}
                            {{ Form::text('facility_name', null, ['class' => 'form-control '.($errors->has('facility_name') ? 'is-invalid':''), 'placeholder' => 'Facility Name']) }}
                            @if ($errors->has('facility_name'))
                            <span class="invalid-feedback">{{ $errors->first('facility_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('contact') ? ' is-invalid' : '' }}">
                            {{ Form::label('contact','Contact Details', ['class' => 'control-label required']) }}
                            {{ Form::text('contact', null, ['class' => 'form-control '.($errors->has('contact') ? 'is-invalid':''), 'placeholder' => 'Contact Details']) }}
                            @if ($errors->has('contact'))
                            <span class="invalid-feedback">{{ $errors->first('contact') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('availability') ? ' is-invalid' : '' }}">
                            {{ Form::label('availability','Availability Time', ['class' => 'control-label required']) }}
                            {{ Form::text('availability', null, ['class' => 'form-control '.($errors->has('availability') ? 'is-invalid':''), 'placeholder' => 'Availability Time']) }}
                            @if ($errors->has('availability'))
                            <span class="invalid-feedback">{{ $errors->first('availability') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('description') ? ' is-invalid' : '' }}">
                            {{ Form::label('description','Description', ['class' => 'control-label required']) }}
                            {{ Form::textarea('description', null, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid':''), 'placeholder' => 'Description','rows'=>'2']) }}
                            @if ($errors->has('description'))
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
                            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
                            <br />
                            <input type="radio" name="status" value="1" @if(isset($facility) && $facility->status=='1') checked @else checked @endif/>
                            Active
                            <input type="radio" name="status" value="0" @if(isset($facility) && $facility->status=='0') checked @endif/>
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
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Submit</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
