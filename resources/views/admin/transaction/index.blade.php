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
                                    <h3 class="card-title">Transactions</h3>
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
                            <table id="transaction-table" class="table table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Transaction Id</th>
                                        <th>Company Name</th>
                                        <th>Contact Person name</th>
                                        <th>Status</th>
                                        <th>Amount</th>
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
    (function() {
 		var dataTable = $('#transaction-table').dataTable({
 			processing: true,
 			serverSide: true,
 			ajax: {
 				headers: {
 					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
 				},
 				url: '{!! route('get.transaction') !!}',
 				type: 'post',
                data: function(d) {
                    d.company_name = $('select[name=company_name]').val();
                }
 			},
 			columns: [
 			{data: null, searchable: false, sortable: false},
 			{data: 'transaction_id', name: 'transaction_id', searchable: false, sortable: false},
 			{data: 'company_name', name: 'company_name'},
 			{data: 'person_name', name: 'person_name'},
 			{data: 'payment_status', name: 'payment_status'},
 			{data: 'amount', name: 'amount'},
 			{data: 'created_at', name: 'created_at'},
 			],
 			order: [[6, "desc"]],
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
