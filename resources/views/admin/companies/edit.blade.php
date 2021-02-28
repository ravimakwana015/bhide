@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content mt-3">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Edit Company</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            {!! Form::model($company, ['route' => ['companies.update', $company->id], 'role' => 'form', 'method' => 'PATCH']) !!}
            <div class="card-body">
              @include("admin.companies.form")
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
@endsection

@section('after-scripts')
<script type="text/javascript">
  $('.apartment_count').change(function (e) {
    e.preventDefault();
    var amount = $('.apartment_count').val() * $('.per_apartment_amount').val();
    $('.subscription_amount').html(amount);
  });
  $('.per_apartment_amount').change(function (e) {
    e.preventDefault();
    var amount = $('.apartment_count').val() * $('.per_apartment_amount').val();
    $('.subscription_amount').html(amount);
  });
  $(document).ready(function () {
    $('#create-company').validate({
      rules: {
        company_name: {
          required: true
        },
        person_name: {
          required: true
        },
        email: {
          required: true,
          email: true,
        },
        mobile: {
          required: true,
          minlength:11,
          maxlength:11,
          digits: true,
        },
        landline: {
          required: true,
          minlength:11,
          maxlength:11,
          digits: true,
        },
        apartment_count: {
          required: true,
        },
        per_apartment_amount: {
          required: true,
        },
        subscription_time: {
          required: true,
        },
        building_address: {
          required: true,
        },
        company_address: {
          required: true,
        },

      },
      messages: {
        company_name: {
          required: "Please enter a company name",
        },
        person_name: {
          required: "Please enter a person name",
        },
        email: {
          required: "Please enter a company email address",
          email: "Please enter a valid company email address"
        },
        mobile: {
          required: "Please enter a mobile Number",
        },
        landline: {
          required: "Please enter a landline Number",
        },
        apartment_count: {
          required: "Please enter a Number of Apartments",
        },
        subscription_amount: {
          required: "Please enter a Subscription Amount",
        },
        subscription_time: {
          required: "Please enter a Subscription Time",
        },
        building_address: {
          required: "Please enter a  Building Address",
        },
        company_address: {
          required: "Please enter a company Address",
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

  $('#building_image-1').on('change', function () {
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
        url: "{{ route('upload-profile-pic') }}",
        type: "POST",
        data: {"image":img},
        success: function (data) {
          $('#myModal').hide('model');
          $('#loading').hide(); 
          var path ='{{ asset('public/front/building_image/') }}';
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
