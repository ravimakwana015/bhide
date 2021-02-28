@extends('admin.layouts.app')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a class="btn btn-info" href="{{ route('features.index') }}"><i class="fas fa-chevron-circle-left"></i> Back</a>
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
                            <h3 class="card-title">Add Feature</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::open(['route' => 'features.store','role' => 'form', 'method' => 'post', 'id' => 'create-polls','files'=>true]) }}
                        <div class="card-body">
                            @include("admin.features.form")
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
    $('.store_details').click(function() {
        var count = parseInt($('#count').val()) + parseInt(1);
        var html = '<div class="row remove_'+count+'"> <div class="col-3"> <div class="form-group"> <label>Content Sub Title '+count+'</label> <input type="text" class="form-control" name="subtitle[]"> </div> </div> <div class="col-3"> <div class="form-group"> <label>Content '+count+'</label> <textarea class="form-control" name="content[]"></textarea> </div> </div><div class="col-md-4"> <label>&nbsp;</label> <br/><a class="remove-field btn" data-id="'+count+'" href="javascript:;">Remove</a> </div> </div>';
        $('#count').val(count);
        $('.store_details_dynamic').append(html);
    });

    $(document).on('click', '.remove-field', function(e) {
     var id = $(this).data('id');
     $('.remove_'+id).remove();
     e.preventDefault();
 });

     $(document).ready(function () {
      $('#create-polls').validate({
        rules:{
          company_id: {
            required: true
          },
            title: {
            required: true
          },
          status: {
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
</script>
@endsection
