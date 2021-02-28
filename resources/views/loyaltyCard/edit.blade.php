@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Edit Store') }}</h3>
            </div>
        </div>
        <!-- form start -->
        {!! Form::model($loyaltyCard, ['route' => ['loyaltyCard.update', $loyaltyCard->id], 'role' => 'form', 'method' =>
        'PATCH','id'=>'loyaltyCard-edit','files' => true]) !!}
        <div class="card-body">
            @include("loyaltyCard.form")
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-secondary">Submit</button>
        </div>
        {!! Form::close() !!}
        <!-- /.card -->
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
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
@endpush
