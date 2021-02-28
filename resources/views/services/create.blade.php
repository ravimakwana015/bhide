@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
  <div class="card shadow">
    <div class="card-header ">
      <div class="titleText">
        <h3 class="mb-0">{{ __('Add Services') }}</h3>
      </div>
    </div>
    <!-- form start -->
    {{ Form::open(['route' => 'services.store','role' => 'form', 'method' => 'post', 'id' => 'create-service']) }}
    <div class="card-body">
      @include("services.form")
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
    $('#create-service').validate({
      rules:{
        category_id: {
          required: true
        },
        service_name: {
          required: true
        },
        service_provider_name: {
          required: true
        },
        contact_number: {
          required: true,
          minlength:11,
          maxlength:11,
          digits: true,
        },
        status: {
          required: true
        },
      },
      messages: {
        contact_number: {
          required: "Please enter a Mobile number",
          minlength:'Please Enter Valid Mobile No',
          maxlength:'Please Enter Valid Mobile No',
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
