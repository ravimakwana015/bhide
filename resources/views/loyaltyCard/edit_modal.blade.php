<div class="modal fade bd-example-modal-lg" id="editService" tabindex="-1" role="dialog" aria-labelledby="editStoreTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Edit Loyalty Card Store</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::model($loyaltyCard, ['route' => ['loyaltyCard.update', $loyaltyCard->id], 'role' => 'form',
            'method' =>
            'PATCH','id'=>'loyaltyCard-edit','files' => true]) !!}
            <div class="modal-body">
                <div class="msg"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="{{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                            {{ Form::label('category_id','Loyalty Card Category', ['class' => 'control-label required']) }}
                            {{ Form::select('category_id', $flats,null, ['class' => 'form-control']) }}
                            @if ($errors->has('category_id'))
                            <span class="invalid-feedback">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group  {{ $errors->has('store_name') ? ' is-invalid' : '' }}">
                            {{ Form::label('store_name','Store name', ['class' => 'control-label required']) }}
                            {{ Form::text('store_name', null, ['class' => 'form-control '.($errors->has('store_name') ? 'is-invalid':''), 'placeholder' => 'Store name']) }}
                            @if ($errors->has('store_name'))
                            <span class="invalid-feedback">{{ $errors->first('store_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group  {{ $errors->has('store_address') ? ' is-invalid' : '' }}">
                            {{ Form::label('store_address','Store address', ['class' => 'control-label required']) }}
                            {{ Form::textarea('store_address', null, ['class' => 'form-control '.($errors->has('store_address') ? 'is-invalid':''), 'placeholder' => 'Store address','rows'=>2]) }}
                            @if ($errors->has('store_address'))
                            <span class="invalid-feedback">{{ $errors->first('store_address') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <div class="form-group  {{ $errors->has('store_offers') ? ' is-invalid' : '' }}">
                                {{ Form::label('store_offers','Store offers', ['class' => 'control-label required']) }}
                                {{ Form::textarea('store_offers', null, ['class' => 'form-control '.($errors->has('store_offers') ? 'is-invalid':''), 'placeholder' => 'Store offers','rows'=>2]) }}
                                @if ($errors->has('store_offers'))
                                <span class="invalid-feedback">{{ $errors->first('store_offers') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
                            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
                            <br />
                            <input type="radio" name="status" value="1" @if(isset($loyaltyCard) && $loyaltyCard->status=='1') checked @else checked @endif/>
                            Active
                            <input type="radio" name="status" value="0" @if(isset($loyaltyCard) && $loyaltyCard->status=='0') checked @endif/>
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
<script>
    $(document).ready(function () {
        $('#loyaltyCard-edit').validate({
        rules:{
          'store_name': {
            required: true
          },
          'store_address': {
            required: true
          },
          'store_offers': {
            required: true
          },

        },
        messages: {
         loyalty_card_image: {
            required: "Please select Loyalty Card image",
          },
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
