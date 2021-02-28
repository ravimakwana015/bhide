<div class="modal fade bd-example-modal-lg" id="editService" tabindex="-1" role="dialog" aria-labelledby="editStoreTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Edit Parcel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::model($parcel, ['route' => ['parcels.update', $parcel->id], 'role' => 'form', 'method' =>
            'PATCH','id'=>'parcel-edit']) !!}
            <div class="modal-body">
                <div class="msg"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('unit_id') ? ' is-invalid' : '' }}">
                            {{ Form::label('unit_id','Apartment Units', ['class' => 'control-label required']) }}
                            <br/>
                            {{ Form::select('unit_id', $flats,null, ['class' => 'select2']) }}
                            @if ($errors->has('unit_id'))
                            <span class="invalid-feedback">{{ $errors->first('unit_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('total_parcel') ? ' is-invalid' : '' }}">
                            {{ Form::label('total_parcel','How many parcels', ['class' => 'control-label required']) }}
                            {{ Form::text('total_parcel', null, ['class' => 'form-control'.($errors->has('total_parcel') ? 'is-invalid':''), 'placeholder' => 'How many parcels']) }}
                            @if ($errors->has('total_parcel'))
                            <span class="invalid-feedback">{{ $errors->first('total_parcel') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
                            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
                            <br />
                            <input type="radio" name="status" value="0" @if(isset($parcel) && $parcel->status=='0') checked  @endif/>
                            Pending
                            <input type="radio" name="status" value="1" @if(isset($parcel) && $parcel->status=='1') checked @endif/>
                            Collected
                            <br />
                            @if ($errors->has('status'))
                            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
                            @endif
                            <div class="error_msg"></div>
                        </div>
                    </div>
                    @if(isset($parcel))
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('name') ? ' is-invalid' : '' }}">
                            {{ Form::label('name','Collected By', ['class' => 'control-label required']) }}
                            {{ Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? 'is-invalid':''), 'placeholder' => 'Collected By']) }}
                            @if ($errors->has('name'))
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <div class="form-group  {{ $errors->has('comment') ? ' is-invalid' : '' }}">
                                {{ Form::label('comment','Comment', ['class' => 'control-label required']) }}
                                {{ Form::textarea('comment', null, ['class' => 'form-control '.($errors->has('comment') ? 'is-invalid':''), 'placeholder' => 'Comment','rows'=>2]) }}
                                @if ($errors->has('comment'))
                                <span class="invalid-feedback">{{ $errors->first('comment') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
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
<script>
    $('.select2').select2();
    $(document).ready(function () {
      $('#parcel-edit').validate({
        rules:{
          unit_id: {
            required: true
          },
          total_parcel: {
            required: true,
            digits: true
          },
          status: {
            required: true
          },
        },
        messages: {
            total_parcel:{
                digits:'Please Enter Number Only'
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
</script>
