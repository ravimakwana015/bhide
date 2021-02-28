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
                                    <h3 class="card-title">Transaction Reports</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="box-header">
                                <h3>Filter</h3>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group input-daterange">
                                            <input type="text" name="from_date" id="from_date" readonly class="form-control" data-column="6" width="276"/>
                                        </div>
                                    </div>
                                    <div>To</div>
                                    <div class="col-md-3">
                                        <div class="input-group input-daterange">
                                            <input type="text"  name="to_date" id="to_date" readonly class="form-control" data-column="6" width="276"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::selectMonth('month', null, ["class" => "search-input-select form-control filter-select2","placeholder" => "Select Month", "data-column"=>"6"]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="box-header" style="padding-top: 10px;">
                                <div class="row">
                                    <div class="col-md-3">
                                        {!! Form::select('year', array_filter(array_unique($year)), null, ["class" => "search-input-select form-control filter-select2","placeholder" => "Select Year","data-column"=>"6"]) !!}
                                    </div>
                                    <div class="col-md-3">

                                        {!! Form::select('subscription_times', array_unique($company_name), null, ["class" => "form-control filter-select2","placeholder" => "Select Company"]) !!}

                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::select('status', ['1'=>'Paid','0'=>'Pending'], null, ["class" => "form-control filter-select2","placeholder" => "Status"]) !!}
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <br/>
                            <table id="user-report-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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


<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
    (function() {
        $('[data-toggle="tooltip"]').tooltip();
        var dataTable = $('#user-report-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{!! route('get.reporttransactions') !!}',
                type: 'post',
                data: function(d) {
                    d.month = $('select[name=month]').val();
                    d.year = $('select[name=year]').val();
                    d.from_date = $('input[name="from_date"]').val();
                    d.to_date = $('input[name="to_date"]').val();
                    d.company_name = $('input[name="company_name"]').val();
                    d.status = $('select[name=status]').val();
                    d.subscription_time = $('select[name=subscription_time]').val();
                    d.subscription_times = $('select[name=subscription_times]').val();
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
            order: [[1, "desc"]],
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
                return nRow;
            }
        });
        
        $('input').on('change', function() {
            datatableDraw(dataTable);
        });
        $('select').on('change', function() {
            datatableDraw(dataTable);
        });
        Backend.DataTableSearch.init(dataTable);
    })();
    function datatableDraw(dataTable){
        dataTable.each(function() {
            dt = $(this).dataTable();
            dt.fnDraw();
        });
    }

    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#from_date').datepicker({
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        // minDate: today,
        maxDate: function () {
            return $('#to_date').val();
        }
    });
    $('#to_date').datepicker({
        uiLibrary: 'bootstrap4',
        iconsLibrary: 'fontawesome',
        minDate: function () {
            return $('#from_date').val();
        }
    });
</script>

@endsection