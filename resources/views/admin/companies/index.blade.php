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
                                    <h3 class="card-title">Companies</h3>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ route('companies.create') }}"
                                    class="btn btn-primary float-right elevation-4"><i class="fas fa-plus"></i> Add
                                Company</a>
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
                                    <th>Contact Person name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Landline</th>
                                    <th>Status</th>
                                    <th>Apartment Count</th>
                                    <th>Subscription Amount</th>
                                    <th>Subscription Time</th>
                                    <th>Building Address</th>
                                    <th>Company Address</th>
                                    <th>Payment Url</th>
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
    $(function() {
        var dataTable = $('#company-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{!! route('get.company') !!}',
                type: 'post',
                data: function(d) {
                    d.company_name = $('select[name=company_name]').val();
                }
            },
            columns: [
            {data: null, searchable: false, sortable: false},
            {data: 'company_name', name: 'company_name'},
            {data: 'person_name', name: 'person_name'},
            {data: 'email', name: 'email'},
            {data: 'mobile', name: 'mobile'},
            {data: 'landline', name: 'landline'},
            {data: 'payment_status', name: 'payment_status'},
            {data: 'apartment_count', name: 'apartment_count'},
            {data: 'subscription_amount', name: 'subscription_amount'},
            {data: 'subscription_time', name: 'subscription_time'},
            {data: 'building_address', name: 'building_address'},
            {data: 'company_address', name: 'company_address'},
            {data: 'payment_url', name: 'payment_url', searchable: false, sortable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false}
            ],
            order: [[13, "desc"]],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
                return nRow;
            }
        });
        $('select[name=company_name]').on('change', function() {
            dataTable.draw();
        });
        Backend.DataTableSearch.init(dataTable);
    });

</script>
@endsection
