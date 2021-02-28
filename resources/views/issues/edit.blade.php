@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
  <div class="card shadow">
    <div class="card-header ">
      <div class="titleText">
        <h3 class="mb-0">{{ __('Edit issues') }}</h3>
      </div>
      <div class="btn-wrap">
        <a class="btn mb-0" href="{{ route('issues.index') }}"><i class="fas fa-arrow-left"></i>Back</a>
      </div>
    </div>
    <!-- form start -->
    {!! Form::model($issues, ['route' => ['issues.update', $issues->id], 'role' => 'form', 'method' =>
    'PATCH','id'=>'issue-edit']) !!}
    <div class="card-body">
      @include("issues.form")
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
    $('#issue-edit').validate({
      rules:{
        issue_name: {
          required: true
        },
        issue_provider_name: {
          required: true
        },
        contact_number: {
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

<script type="text/javascript">
  $('#done').change(function(){

    $('#commentsdata').css('display','');

  });
</script>

@endpush
