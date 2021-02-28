@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Add Apartment Number') }}</h3>
            </div>
            <div class="btn-wrap">
              <a class="btn mb-0" href="{{ route('units.index') }}"><i class="fas fa-arrow-left"></i> Back</a>
          </div>
      </div>
      <!-- form start -->
      {{ Form::open(['route' => 'units.store','role' => 'form', 'method' => 'post', 'id' => 'create-units']) }}
      <div class="card-body">
        @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @include("units.form")
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
      $('#create-units').validate({
        rules:{
          block_number: {
            required: true
        },
        flat_number: {
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
