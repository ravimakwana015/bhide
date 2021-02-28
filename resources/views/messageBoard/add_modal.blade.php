<div class="modal fade bd-example-modal-lg" id="addNotice" tabindex="-1" role="dialog"
    aria-labelledby="addServiceTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Add Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'messageBoard.store','role' => 'form', 'method' => 'post', 'id' => 'create-messageBoard','files' => true]) }}
            <div class="modal-body">
                <div class="msg"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('title') ? ' is-invalid' : '' }}">
                            {{ Form::label('title','Title', ['class' => 'control-label required']) }}
                            {{ Form::text('title', null, ['class' => 'form-control '.($errors->has('title') ? 'is-invalid':''), 'placeholder' => 'Title']) }}
                            @if ($errors->has('title'))
                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('description') ? ' is-invalid' : '' }}">
                            {{ Form::label('description','Description', ['class' => 'control-label required']) }}

                            {{ Form::textarea('description', null, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid':''), 'placeholder' => 'Description', 'rows'=>'1']) }}
                            @if ($errors->has('description'))
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
                            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
                            <br />
                            <input type="radio" name="status" value="1" @if(isset($messageBoard) && $messageBoard->status=='1') checked @else checked="" @endif/>
                            Active
                            <input type="radio" name="status" value="0" @if(isset($messageBoard) && $messageBoard->status=='0') checked @endif/>
                            In Active
                            <br />
                            @if ($errors->has('status'))
                            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group {{ $errors->has('notice_valid_until') ? ' is-invalid' : '' }}">
                            {{ Form::label('notice_valid_until','Notice Valid Until', ['class' => 'control-label required']) }}
                            <br />
                            {{ Form::text('notice_valid_until', null, ['class' => 'form-control datetimepicker '.($errors->has('notice_valid_until') ? 'is-invalid':''), 'placeholder' => 'Notice Valid Until','readonly']) }}
                            @if ($errors->has('notice_valid_until'))
                            <span class="invalid-feedback">{{ $errors->first('notice_valid_until') }}</span>
                            @endif
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
