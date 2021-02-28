@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Edit Facility') }}</h3>
            </div>
        </div>
        <!-- form start -->
        {!! Form::model($facility, ['route' => ['facilities.update', $facility->id], 'role' => 'form', 'method' =>
        'PATCH','id'=>'facility-edit']) !!}
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
      $('#facility-edit').validate({
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
