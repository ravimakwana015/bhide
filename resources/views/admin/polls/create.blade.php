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
                            <h3 class="card-title">Add Poll</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {{ Form::open(['route' => 'poll.store','role' => 'form', 'method' => 'post', 'id' => 'create-polls']) }}
                        <div class="card-body">
                            @include("admin.polls.form")
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
