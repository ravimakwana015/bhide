@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a class="btn btn-info" href="{{ route('admin.home') }}"><i class="fas fa-chevron-circle-left"></i>
                        Back</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include("admin.include.message")
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h3 class="card-title">Advertise</h3>
                                </div>
                                <div class="col-sm-6">
                                    <a href="javascript:;" class="btn btn-primary float-right elevation-4"
                                        id="add-ads"><i class="fas fa-plus"></i> Add Advertise</a>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="advert" class="table table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Redirect url</th>
                                        <th>Instagram url</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
@include('admin.adverts.form')

<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addServiceTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Edit Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" role="form" id="editForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="register-form-errors"></div>
                    {{csrf_field()}}
                    <div id="edi_data_wrap"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="deletemodel" tabindex="-1" role="dialog"
    aria-labelledby="addServiceTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Are you Sure You want Delete Advertise Record ??</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.advert.delete') }}" method="post" role="form" id="editForm"
                enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="id" id="delete_id">
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('after-scripts')
<script>
    $('#add-ads').click(function (e) {
        $('#addAdvert').modal('show');
    });

    function getData(id)
    {

       $('#edi_data_wrap').html('');
        // $('#loading').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{!! route('admin.advert.edit') !!}',
            type: "post",
            data:{
                id:id
            },
            dataType: 'json',
            success: function (data) {
                $('#loading').hide();
                $('#edi_data_wrap').html(data.data);
                $('#editModal').modal('show');
            },
            error: function (data) {
            },
        });
    }
    $(document).ready(function () {
      $('#create-ads').validate({
        rules:{
            title: {
            required: true
        },
        redirect_url: {
            required: true,
        },
        instagram_url: {
            required: true,
        },
        image: {
            required: true
        },
    },
    messages: {},
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
  },
  submitHandler: function (form) {
    var formData = new FormData($('#create-ads')[0]);
    console.log(formData);
    addWithImage('{{ route('advert.store') }}','create-ads','advert','addAdvert',formData);
    return false;
}
});
  });

  $('#editForm').validate({
    rules:{
        title: {
            required: true
        },
        redirect_url: {
            required: true,
        },
        instagram_url: {
            required: true,
        },
        // image: {
        //     required: true
        // },
    },
    messages: {

    },
    submitHandler: function(form) {
        $('#loading').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('admin.advert.update')}}",
            type: "POST",
            data: new FormData($('#editForm')[0]),
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $('#loading').hide();
                if(data.status==1){
                    $( '.register-form-errors' ).html('<div class="alert alert-success">Advert Update Successfully</div>');
                    $("#advert").DataTable().draw();
                    $('#editForm').trigger("reset");
                    setTimeout(function(){
                        $("#editModal").modal('hide');
                        // window.location.reload();
                    }, 2000);

                }
            },
            error: function (data) {
                $('#loading').hide();
                var errorString = '<ul>';
                $.each(data.responseJSON.errors, function( key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                errorString += '</ul>';
                $('.register-form-errors').html('');
                $( '.register-form-errors' ).html('<div class="alert alert-danger">'+errorString+'</div>');
            },
        });
        return false;
    }
});

function getDelete(id)
    {
        $('#deletemodel').modal('show');
        $('#delete_id').val(id);
    }
  (function() {
        var dataTable = $('#advert').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{!! route('get.advert') !!}',
                type: 'post'
            },
            columns: [
            {data: null, searchable: false, sortable: false},
            {data: 'image', name: 'image', searchable: false, sortable: false},
            {data: 'title', name: 'title'},
            {data: 'redirect_url', name: 'redirect_url'},
            {data: 'instagram_url', name: 'instagram_url'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false}
            ],
            order: [[6, "asc"]],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
                return nRow;
            }
        });
    })();
</script>
@endsection
