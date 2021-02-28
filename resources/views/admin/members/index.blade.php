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
                                    <h3 class="card-title">Concierge Users</h3>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ route('concierge.create') }}" class="btn btn-primary float-right elevation-4" id="addButton"><i class="fas fa-plus"></i> Add Concierge User</a>

                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="concierges" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('Image')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Shift')}}</th>
                                        <th>{{__('Gate Name')}}</th>
                                        <th>{{__('Date Of Birth')}}</th>
                                        <th>{{__('Email')}}</th>
                                        <th>{{__('Mobile')}}</th>
                                        <th>{{__('Created Date')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
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
{{-- @include('dentist-booking.modal') --}}
@endsection
@section('after-scripts')
<script>
    (function () {
        var dataTable = $('#concierges').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route("get.concierge") }}',
                type: 'post',
            },
            columns: [
            {data: null, searchable: false, sortable: false},
            {data: 'concierge_image', name: 'concierge_image', searchable: false, sortable: false},
            {data: 'name', name: 'name'},
            {data: 'shift', name: 'shift', "width": "15%"},
            {data: 'gate', name: 'gate'},
            {data: 'date_of_birth', name: 'date_of_birth'},
            {data: 'email', name: 'email'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "10%"}
            ],
            order: [[8, "asc"]
            ],
            searchDelay: 500,
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
                return nRow;
            }
        });
        // Backend.DataTableSearch.init(dataTable);
    })();
</script>
@endsection
