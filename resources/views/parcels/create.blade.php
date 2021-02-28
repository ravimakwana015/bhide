@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Add parcels') }}</h3>
            </div>
        </div>
        <!-- form start -->
        {{ Form::open(['route' => 'parcels.store','role' => 'form', 'method' => 'post', 'id' => 'create-visitor']) }}
        <div class="card-body">
            @include("parcels.form")
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
      $('#create-parcels').validate({
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
@endpush
