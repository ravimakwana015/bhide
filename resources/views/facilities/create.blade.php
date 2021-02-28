@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Add Facilities') }}</h3>
            </div>
            <div class="btn-wrap">
              <a class="btn mb-0" href="{{ route('facilities.index') }}"><i class="fas fa-arrow-left"></i> Back</a>
            </div>
      </div>
      <!-- form start -->
      {{ Form::open(['route' => 'facilities.store','role' => 'form', 'method' => 'post', 'id' => 'create-facility']) }}
      <div class="card-body">
        @include("facilities.form")
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
      $('#create-facility').validate({
        rules:{
          facility_name: {
            required: true
        },
        //   amount_charge: {
        //     required: true
        //   },
        //   charge_per: {
        //     required: true
        //   },
        status: {
            required: true
        },
    },
    messages: {

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
