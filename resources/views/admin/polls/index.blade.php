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
            @include("include.modals")
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h3 class="card-title">Polls</h3>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ route('poll.create') }}" class="btn btn-primary float-right elevation-4" id="addButton"><i class="fas fa-plus"></i> Add Poll</a>
                                    
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
                            <table id="polls" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <th>Title</th>
                                        <th>Poll Submission</th>
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
    <!-- /.content -->
</div>
@endsection
@section('after-scripts')

<script>

    function getPollUsers(poll_id)
    {
      $('#poll_result').html('');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: '{{ route("get.poll.users") }}',
            type: "post",
            data: {
                id: poll_id
            },
            dataType: "json",
            success: function(res) {
                if(res.status==1){
                    $('#poll_result_user').html(res.result);
                    $('#pollResultUser').modal('show');
                }else{
                    $('#poll_result_user').html('No Result Found');
                    $('#pollResultUser').modal('show');
                }
            }
        });
    }

    function getPollResult(poll_id){
        $('#poll_result').html('');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: '{{ route("get.poll.adminresult") }}',
            type: "post",
            data: {
                id: poll_id
            },
            dataType: "json",
            success: function(res) {
                if(res.status==1){
                    $('#poll_result').html(res.result);
                    $('#pollResult').modal('show');
                }else{
                    $('#poll_result').html('No Result Found');
                    $('#pollResult').modal('show');
                }
            }
        });
    }
    (function () {
        var dataTable = $('#polls').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("get.poll") }}',
                type: 'post',
                data: function(d) {
                    d.company_name = $('select[name=company_name]').val();
                }
            },
            columns: [
            {data: null, searchable: false, sortable: false},
            {data: 'company_name', name: 'company_name'},
            {data: 'title', name: 'title'},
            {data: 'poll_submission', name: 'poll_submission'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
            ],
            order: [[4, "desc"]],
            searchDelay: 500,
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