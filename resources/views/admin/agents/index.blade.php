@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a class="btn btn-info" href="{{ route('admin.home') }}"><i class="fas fa-chevron-circle-left"></i> Back</a>
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
                                    <h3 class="card-title">Facilities</h3>
                                </div>
                                <div class="col-sm-6">
                                    <a href="javascript:;" class="btn btn-primary float-right elevation-4" id="addButton"><i class="fas fa-plus"></i> Add Facilitie</a>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="box-header">
                                <h3>Filter</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Select Company Name</label>
                                        {!! Form::select('company_name', array_unique($companys), null, ["class" => "select2 form-control search-input-select"]) !!}
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <br/>
                            <table id="company-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <th>Facility Name</th>
                                        <th>Contact Details</th>
                                        <th>Availability Time</th>
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


    <div class="modal fade bd-example-modal-lg" id="addService" tabindex="-1" role="dialog"
    aria-labelledby="addServiceTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLongTitle">Add Facilitie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['route' => 'facilitie.store','role' => 'form', 'method' => 'post', 'id' => 'create-service']) }}
            <div class="modal-body">
                <div class="msg"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
                            {{ Form::label('company_id','Company Name', ['class' => 'control-label required']) }}
                            {{ Form::select('company_id', $companys,null, ['class' => 'form-control select2']) }}
                            @if ($errors->has('company_id'))
                            <span class="invalid-feedback">{{ $errors->first('company_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('facility_name') ? ' is-invalid' : '' }}">
                            {{ Form::label('facility_name','Facility Name', ['class' => 'control-label required']) }}
                            {{ Form::text('facility_name', null, ['class' => 'form-control '.($errors->has('facility_name') ? 'is-invalid':''), 'placeholder' => 'Facility Name']) }}
                            @if ($errors->has('facility_name'))
                            <span class="invalid-feedback">{{ $errors->first('facility_name') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('contact') ? ' is-invalid' : '' }}">
                            {{ Form::label('contact','Contact Details', ['class' => 'control-label required']) }}
                            {{ Form::text('contact', null, ['class' => 'form-control '.($errors->has('contact') ? 'is-invalid':''), 'placeholder' => 'Contact Details']) }}
                            @if ($errors->has('contact'))
                            <span class="invalid-feedback">{{ $errors->first('contact') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('availability') ? ' is-invalid' : '' }}">
                            {{ Form::label('availability','Availability Time', ['class' => 'control-label required']) }}
                            {{ Form::text('availability', null, ['class' => 'form-control '.($errors->has('availability') ? 'is-invalid':''), 'placeholder' => 'Availability Time']) }}
                            @if ($errors->has('availability'))
                            <span class="invalid-feedback">{{ $errors->first('availability') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('description') ? ' is-invalid' : '' }}">
                            {{ Form::label('description','Description', ['class' => 'control-label required']) }}
                            {{ Form::textarea('description', null, ['class' => 'form-control '.($errors->has('description') ? 'is-invalid':''), 'placeholder' => 'Description','rows'=>'2']) }}
                            @if ($errors->has('description'))
                            <span class="invalid-feedback">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
                            {{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
                            <br />
                            <input type="radio" name="status" value="1" @if(isset($facility) && $facility->status=='1') checked @endif/>
                            Active
                            <input type="radio" name="status" value="0" @if(isset($facility) && $facility->status=='0') checked @endif/>
                            In Active
                            <br />
                            @if ($errors->has('status'))
                            <span class="invalid-feedback">{{ $errors->first('status') }}</span>
                            @endif
                            <div class="error_msg"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Submit</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
aria-labelledby="addServiceTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLongTitle">Edit Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form  method="post" role="form" id="editForm" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="register-form-errors"></div>
                {{csrf_field()}}
                <div id="edi_data_wrap"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
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
            <h5 class="modal-title" id="deleteModalLongTitle">Are you Sure You want Delete Facilitie ??</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ route('admin.facilitie.delete') }}" method="post" role="form" id="editForm" enctype="multipart/form-data">
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


<!-- /.content -->
</div>
@endsection
@section('after-scripts')

<script>

    function getDelete(id)
    {
        $('#deletemodel').modal('show');
        $('#delete_id').val(id);
    }

    $('#addButton').click(function (e) {
        $('#addService').modal('show');
    });
    $(document).ready(function () {
        $('#create-service').validate({
            rules:{
                company_id: {
                    required: true
                },
                facility_name: {
                    required: true
                },
                status: {
                    required: true
                },
                contact: {
                    required: true
                },
                availability: {
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
            },
            submitHandler: function (form) {
                addService('{{ route('facilitie.store') }}','create-service','services','addService');
                return false;
            }
        });
    });
    (function() {
        var dataTable = $('#company-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{!! route('get.facilitie') !!}',
                type: 'post',
                data: function(d) {
                    d.company_name = $('select[name=company_name]').val();
                }
            },
            columns: [
            {data: null, searchable: false, sortable: false},
            {data: 'company_name', name: 'company_name'},
            {data: 'facility_name', name: 'facility_name'},
            {data: 'contact', name: 'contact'},
            {data: 'availability', name: 'availability'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false}
            ],
            order: [[5, "asc"]],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
                return nRow;
            }
        });
        $('select[name=company_name]').on('change', function() {
            dataTable.draw();
        });
        Backend.DataTableSearch.init(dataTable);
    })();
</script>

<script type="text/javascript">

    function getData(id)
    {
        var getUrl = window.location;
        var routeUrl = getUrl + '/edit' + "/" + id;
        
        $('#edi_data_wrap').html('');
        $('#loading').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: routeUrl,
            type: "get",
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


    $('#editForm').validate({ 
        rules:{
          company_id: {
            required: true
        },
        facility_name: {
            required: true
        },
        status: {
            required: true
        },
        contact: {
            required: true
        },
        availability: {
            required: true
        },
    },
    messages: {

    },
    submitHandler: function(form) {
        $('#loading').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('admin.facilitie.update')}}",
            type: "POST",
            data: $("#editForm").serialize(),
            dataType: 'json',
            success: function (data) {
                $('#loading').hide();
                if(data.status==1){
                    $( '.register-form-errors' ).html('<div class="alert alert-success">Facilitie Update Successfully</div>');
                    setTimeout(function(){ 
                        $("#editModal").modal('hide');
                        window.location.reload();
                    }, 5000);

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

</script>

@endsection
