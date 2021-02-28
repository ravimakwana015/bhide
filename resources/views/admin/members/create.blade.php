@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a class="btn btn-info" href="{{ route('concierge.index') }}"><i class="fas fa-chevron-circle-left"></i> Back</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
  <!-- Main content -->
  <section class="content mt-3">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Add Concierges User</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            {{ Form::open(['route' => 'concierge.store','role' => 'form', 'method' => 'post', 'id' => 'create-visitor','files' => true]) }}
            <div class="card-body">
              @include("admin.members.form")
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-secondary">Submit</button>
            </div>
            {!! Form::close() !!}
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@include('admin.include.modals')
@endsection

@section('after-scripts')
<script type="text/javascript">
  $(document).ready(function () {
    var options = {
      title: 'Check In Time',
      twentyFour: true,
    };
    $('.shift_start').wickedpicker(options);
    $('.shift_end').wickedpicker(options);

    var dt = new Date();
    dt.setFullYear(new Date().getFullYear()-18);
    $('.datetimepicker').datepicker({
      format: 'DD/MM/YYYY',
      'autoHide':true,
      endDate : dt
    });

    $('#create-visitor').validate({
      rules:{
       gate_id: {
        required: true
      },company_id: {
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
      state: {
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
      phone_number: {
        required: true,
      },
      concierge_image: {
        required: true,
      },
      shift_start: {
        required: true,
      },
      shift_end: {
        required: true,
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
      phone_number: {
        required: "Please enter a Mobile number",
      },
      concierge_image: {
        required: "Please select concierge image",
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

  $('#concierge_image-1').on('change', function () {
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
    $('#building_image-1').val('');
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
        url: "{{ route('upload-concierges-pic-admin') }}",
        type: "POST",
        data: {"image":img},
        success: function (data) {
          $('#myModal').hide('model');
          $('#loading').hide(); 
          var path ='{{ asset('public/front/concierges_image/') }}';
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
@endsection
