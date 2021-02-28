@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
  <div class="card shadow">
    <div class="card-header ">
      <div class="titleText">
        <h3 class="mb-0">{{ __('Add Polls') }}</h3>
      </div>
      <div class="btn-wrap">
        <a class="btn mb-0" href="{{ route('polls.index') }}"><i class="fas fa-arrow-left"></i> Back</a>
      </div>
    </div>
    <!-- form start -->
    {{ Form::open(['route' => 'polls.store','role' => 'form', 'method' => 'post', 'id' => 'create-polls']) }}
    <div class="card-body">
      @if (session('error'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @include("polls.form")
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
  $('.store_details').click(function() {
    var count = parseInt($('#count').val()) + parseInt(1);
    var html = '<div class="row remove_'+count+'"> <div class="col-6"> <div class="form-group"> <label>Option '+count+'</label> <input type="text" class="form-control" name="options[]"> </div> </div> <div class="col-md-4"> <label>&nbsp;</label> <br/><a class="remove-field btn" data-id="'+count+'" href="javascript:;">Remove</a> </div> </div>';
    $('#count').val(count);

    $('.store_details_dynamic').append(html);
  });

  $(document).on('click', '.remove-field', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    $('.remove_'+id).remove();
    var count = parseInt($('#count').val()) - parseInt(1);
    $('#count').val(count);
  });
  $(document).ready(function () {
    $('#create-polls').validate({
      rules:{
        title: {
          required: true
        },
        status: {
          required: true
        },poll_valid_until: {
          required: true
        },
        'options[]': {
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


  $('.datetimepicker').datepicker({
    format: 'YYYY-MM-DD',
    'autoHide':true,
    'startDate' : new Date()
  });
</script>
@endpush
