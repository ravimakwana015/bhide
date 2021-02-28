@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Edit Notice') }}</h3>
            </div>
        </div>
        <!-- form start -->
        {!! Form::model($messageBoard, ['route' => ['messageBoard.update', $messageBoard->id], 'role' => 'form', 'method' =>
        'PATCH','id'=>'concierge-edit','files' => true]) !!}
        <div class="card-body">
            @include("messageBoard.form")
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
        $('.datetimepicker').datepicker({
            format: 'DD/MM/YYYY',
            'autoHide':true,
            'startDate' : new Date()
        });
      $('#create-visitor').validate({
        rules:{
          title: {
            required: true
          },
          description: {
            required: true
          },
          status: {
            required: true
          },
          notice_valid_until: {
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
