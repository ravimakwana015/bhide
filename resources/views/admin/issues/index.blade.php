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
                                    <h3 class="card-title">Issues</h3>
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
                                        <th>Apartment Unit</th>
                                        <th>Member Name</th>
                                        <th>Issue</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
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
                url: '{!! route('get.issue') !!}',
                type: 'post',
                data: function(d) {
                    d.company_name = $('select[name=company_name]').val();
                }
            },
            columns: [
            {data: null, searchable: false, sortable: false},
            {data: 'company_name', name: 'company_name'},
            {data: 'unit_name', name: 'unit_name'},
            {data: 'app_user_name', name: 'app_user_name'},
            {data: 'issue', name: 'issue'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'}
            ],
            order: [[6, "asc"]],
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

@endsection
