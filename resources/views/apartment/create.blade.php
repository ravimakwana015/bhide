@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
  <div class="card shadow">
    <div class="card-header ">
      <div class="titleText">
        <h3 class="mb-0">{{ __('Add Apartment Resident') }}</h3>
      </div>
      <div class="btn-wrap">
        <a class="btn mb-0" href="{{ route('apartment.index') }}"><i class="fas fa-arrow-left"></i> Back</a>
      </div>
    </div>
    <!-- form start -->
    {{ Form::open(['route' => 'apartment.store','role' => 'form', 'method' => 'post', 'id' => 'create-user']) }}
    <div class="card-body">
      @include("apartment.form")
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
    var dt = new Date();
    dt.setFullYear(new Date().getFullYear()-10);
    $('.datetimepicker').datepicker({
      format: 'DD-MM-YYYY',
      'autoHide':true,
      endDate : dt
    });
    $('#create-user').validate({
      rules:{
        member_type: {
          required: true
        },
        unit_id: {
          required: true
        },
        first_name: {
          required: true
        },
        last_name: {
          required: true
        },
        gender: {
          required: true
        },
        date_of_birth: {
          required: true
        },
        address: {
          required: true
        },
        city: {
          required: true
        },
        country: {
          required: true
        },
        zip_code: {
          required: true
        },
        email: {
          required: true,
          email: true,
        },
        password: {
          required: true,
        },
        phone_number: {
          required: true,
          minlength:11,
          maxlength:11,
          digits: true,
        },
      },
      messages: {
        first_name: {
          required: "Please enter a first name",
        },
        last_name: {
          required: "Please enter a Last name",
        },
        gender: {
          required: "Please Select gender",
        },
        date_of_birth: {
          required: "Please Select Date of birth",
        },
        address: {
          required: "Please Enter Address",
        },
        city: {
          required: "Please Enter city",
        },
        state: {
          required: "Please Enter state",
        },
        country: {
          required: "Please Enter country",
        },
        zip_code: {
          required: "Please Enter Postal code",
        },
        email: {
          required: "Please enter a member email address",
          email: "Please enter a valid member email address"
        },
        password: {
          required: "Please enter a member password",
        },
        phone_number: {
          required: "Please enter a Mobile number",
          minlength:'Please Enter Valid Mobile No',
          maxlength:'Please Enter Valid Mobile No',
        },
        unit_id: {
          required: "Please Select member Unit",
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


<script>
  var resize = $('#upload-demo').croppie({
    enableExif: true,
    viewport: { 
      width: 300,
      height: 300,
      type: 'square'
    },
    boundary: {
      width: 300,
      height: 300
    }
  });

  $('#member_image-1').on('change', function () {
    $('#myModal').show('model');
    var reader = new FileReader();
    reader.onload = function (e) {
      resize.croppie('bind',{
        points: [77,469,280,739],
        url: e.target.result
      }).then(function(){
        resize.croppie('setZoom', 0.2);
        $('.profile-image-preview').addClass('active');
        $('body').addClass('profile-popup');
      });
    }
    reader.readAsDataURL(this.files[0]);
  });

  $('#close_image_crop').click(function(event) {
    $('.profile-image-preview').removeClass('active');
    $('body').removeClass('profile-popup');
    $('#member_image-1').val('');
    $('#myModal').hide('model');
  });

  $('.upload-image').on('click', function (ev) {
    resize.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function (img) {
      $('#loading').show();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('upload-apartment-pic') }}",
        type: "POST",
        data: {"image":img},
        success: function (data) {
          $('#myModal').hide('model');
          $('#loading').hide(); 
          var path ='{{ asset('public/front/member_image/') }}';
          $('#profile-img-tag').attr('src', path+'/'+data);
          $('#profile-img-tag-textarea').val(data);

          $('#yellowbutton').trigger('click');
          setTimeout(function() { 
            $('#loadings').hide(); 
          }, 4000);
        }
      });
    });
  });
</script>

@endpush
