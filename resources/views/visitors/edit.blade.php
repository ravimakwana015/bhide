@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
  <div class="card shadow">
    <div class="card-header ">
      <div class="titleText">
        <h3 class="mb-0">{{ __('Edit Visitor') }}</h3>
      </div>
      <div class="btn-wrap">
        <a class="btn mb-0" href="{{ route('visitors.index') }}"><i class="fas fa-arrow-left"></i> Back</a>
      </div>
    </div>
    <!-- form start -->
    {!! Form::model($visitor, ['route' => ['visitors.update', $visitor->id], 'role' => 'form', 'method' =>
    'PATCH','id'=>'visitor-edit']) !!}
    <div class="card-body">
      @include("visitors.form")
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
    var options = {
      title: 'Check In Time',
      twentyFour: true,
      now: "{{ $visitor->check_in_time }}"
    };
    $('.check_in_time').wickedpicker(options);
    $('.datetimepicker').datepicker({
      format: 'D/M/YYYY',
      'autoHide':true,
      'startDate' : new Date(),
      'endDate' : new Date(),
    });
    $('#create-visitor').validate({
      rules:{
       gate_id: {
        required: true
      },
      reason_id: {
        required: true
      },
      unit_id: {
        required: true
      },
      check_in_date: {
        required: true
      },
      check_in_time: {
        required: true
      },
      visitor_name: {
        required: true
      },
      id_number: {
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
