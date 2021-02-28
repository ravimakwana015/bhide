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
                            <h3 class="card-title">Add Company</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::open(['route' => 'companies.store','role' => 'form', 'method' => 'post', 'id' => 'create-company']) }}
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
          },
          landline: {
            required: true,
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
@endsection
