@extends('admin.layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $master['totalCompanies'] }}</h3>
                            <p>Companies</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <a href="{{ route('companies.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 style="color: white;">{{ $master['totalTransaction'] }}</h3>
                            <p style="color: white;">Transactions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <a href="{{ route('transaction.index') }}" class="small-box-footer"><span style="color: white;">More info <i class="fas fa-arrow-circle-right"></i></span></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $master['totalServices'] }}</h3>
                            <p>Services</p>
                        </div>
                        <div class="icon">
                            <i class="fab fa-servicestack"></i>
                        </div>
                        <a href="{{ route('service.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #FFA07A;">
                        <div class="inner">
                            <h3 style="color: white;">{{ $master['totalLoyaltyCard'] }}</h3>
                            <p style="color: white;">Loyalty Store</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <a href="{{ route('loyaltystores.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $master['totalParcels'] }}</h3>
                            <p>Parcels</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <a href="{{ route('parcel.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-dark">
                        <div class="inner">
                            <h3>{{ $master['totalPolls'] }}</h3>
                            <p>Polls</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-poll"></i>
                        </div>
                        <a href="{{ route('poll.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color: #FF4500;">
                        <div class="inner">
                            <h3 style="color: white;">{{ $master['totalUnitIssueRequest'] }}</h3>
                            <p style="color: white;">Issues</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bug"></i>
                        </div>
                        <a href="{{ route('issue.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">    
                    <!-- small box -->
                    <div class="small-box" style="background-color: #DA70D6;">
                        <div class="inner">
                            <h3 style="color: white;">{{ $master['totalamount'] }}</h3>
                            <p style="color: white;">Total Amount</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="{{ route('transaction.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- USERS LIST -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Apartment Members</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class="">

                                        </div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class="">

                                        </div>
                                    </div>
                                </div>
                                <canvas id="lineChart" style="height: 250px; min-height: 250px; display: block; width: 487px;" width="487" height="250" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!--/.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Transaction Chart</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="areaChart" style="height: 250px; min-height: 250px; display: block; width: 487px;" width="487" height="250" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <!-- USERS LIST -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Latest Apartment Members</h3>

                            <div class="card-tools">
                                <span class="badge badge-danger">New Apartment Members</span>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                                @if(!empty($master['latestnewappusers']))
                                @foreach($master['latestnewappusers'] as $latestappuser)
                                <li>
                                    @if(isset($latestappuser->member_image))
                                    <img src="{{ asset('public/front') }}/member_image/{{ $latestappuser->member_image }}" alt="User Image">
                                    @else
                                    @if($latestappuser->gender == 'male')
                                    <img src="{{ asset('public/front') }}/images/male.jpg" alt="User Image">
                                    @else
                                    <img src="{{ asset('public/front') }}/images/female.jpg" alt="User Image">
                                    @endif
                                    @endif
                                    <a class="users-list-name" href="javascript:;">{{ $latestappuser->first_name }} {{ $latestappuser->last_name }}</a>
                                    <span class="users-list-date">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($latestappuser->created_at))->diffForHumans() }}</span>
                                </li>
                                @endforeach
                                @else
                                Apartment Members Not Available
                                @endif
                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        {{-- <div class="card-footer text-center">
                            <a href="javascript::">View All Users</a>
                        </div> --}}
                        <!-- /.card-footer -->
                    </div>
                    <!--/.card -->
                </div>
                <div class="col-md-6">
                    <!-- USERS LIST -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Latest Concierge Users</h3>

                            <div class="card-tools">
                                <span class="badge badge-danger">New Concierge Users</span>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <ul class="users-list clearfix">
                                @if(!empty($master['latestcoinusers']))
                                @foreach($master['latestcoinusers'] as $latestappuser)
                                <li>
                                    @if(isset($latestappuser->concierge_image))
                                    <img src="{{ asset('public/front') }}/concierges_image/{{ $latestappuser->concierge_image }}" alt="User Image">
                                    @else
                                    @if($latestappuser->gender == 'male')
                                    <img src="{{ asset('public/front') }}/images/male.jpg" alt="User Image">
                                    @else
                                    <img src="{{ asset('public/front') }}/images/female.jpg" alt="User Image">
                                    @endif
                                    @endif
                                    <a class="users-list-name" href="javascript:;">{{ $latestappuser->first_name }} {{ $latestappuser->last_name }}</a>
                                    <span class="users-list-date">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($latestappuser->created_at))->diffForHumans() }}</span>
                                </li>
                                @endforeach
                                @else
                                Concierge Members Not Available
                                @endif
                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card-body -->
                        {{-- <div class="card-footer text-center">
                            <a href="javascript::">View All Users</a>
                        </div> --}}
                        <!-- /.card-footer -->
                    </div>
                    <!--/.card -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"> 
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title"><b>Latest Companies</b></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0" id="latestCompanies">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Person Name</th>
                                            <th>Email</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($master['latestCompanies']))
                                        @foreach($master['latestCompanies'] as $latestCompanie)
                                        <tr>
                                            <td><a href="{{ route('companies.show', $latestCompanie->id) }}">{{ $latestCompanie->company_name }}</a></td>
                                            <td>{{ $latestCompanie->person_name }}</td>
                                            <td>{{ $latestCompanie->email }}</td>
                                            <td>
                                                @if($latestCompanie->payment_status == 1)
                                                <span class="badge badge-success">Paid</span>
                                                @else
                                                <span class="badge badge-danger">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td>
                                                Company Not Available
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title"><b>Latest Transactions</b></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0" id="latestTransactions">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Person Name</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($master['latestTransactions']))
                                        @foreach($master['latestTransactions'] as $latestTransaction)
                                        <tr>
                                            <td><a href="{{ route('companies.show', $latestTransaction->company_id) }}">{{ $latestTransaction->company_name }}</a></td>
                                            <td>{{ $latestTransaction->person_name }}</td>
                                            <td>{{ $latestTransaction->amount }}</td>
                                            <td>
                                                @if($latestCompanie->payment_status == 1)
                                                <span class="badge badge-success">Paid</span>
                                                @else
                                                <span class="badge badge-danger">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td>
                                                Transactions Not Available
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"> 
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title"><b>Latest Polls</b></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0" id="latestpolls">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Poll Title</th>
                                            <th>Status</th>
                                            <th>Poll End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($master['latestPolls']))
                                        @foreach($master['latestPolls'] as $latestpoll)
                                        <tr>
                                            <td><a href="{{ route('companies.show', $latestpoll->company_id) }}">{{ $latestpoll->company_name }}</a></td>
                                            <td>{{ $latestpoll->title }}</td>
                                            <td>
                                                @if($latestCompanie->status == 0)
                                                <span class="badge badge-success">Active</span>
                                                @else
                                                <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{  Carbon\Carbon::parse($latestpoll->poll_valid_until)->format('d/m/Y')  }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td>
                                                Polls Not Available
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title"><b>Latest Issues</b></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0" id="latestissues">
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Apartment Unit</th>
                                            <th>Member Name</th>
                                            <th>Issue</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($master['latestissues']))
                                        @foreach($master['latestissues'] as $latestissue)
                                        <tr>
                                            <td><a href="{{ route('companies.show', $latestissue->company_id) }}">{{ $latestissue->company_name }}</a></td>
                                            <td>{{ $latestissue->block_number }}{{ $latestissue->flat_number }}</td>
                                            <td>{{ $latestissue->first_name }} {{ $latestissue->middle_name }} {{ $latestissue->last_name }}</td>
                                            <td>{{ $latestissue->issue }}</td>
                                            <td>
                                                @if($latestissue->unit_issue_requests_status == 1)
                                                <span class="badge badge-success">Done</span>
                                                @elseif($latestissue->unit_issue_requests_status == 2)
                                                <span class="badge badge-warning">In Review</span>
                                                @else
                                                <span class="badge badge-danger">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td>
                                                Polls Not Available
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('after-scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('#latestCompanies').DataTable( {
            "paging":   false,
            "searching": false,
            "bInfo" : false,
            "order": [[ 3, "desc" ]]
        } );
        $('#latestTransactions').DataTable( {
            "paging":   false,
            "searching": false,
            "bInfo" : false,
            "order": [[ 3, "desc" ]]
        } );
        $('#latestpolls').DataTable( {
            "paging":   false,
            "searching": false,
            "bInfo" : false,
            "order": [[ 2, "desc" ]]
        } );
        $('#latestissues').DataTable( {
            "paging":   false,
            "searching": false,
            "bInfo" : false,
            "order": [[ 4, "desc" ]]
        } );
    } );
</script>

<script>

    $.ajax({
        url: "{{ route('admin.chart') }}",
        success: function (data) {

            function addData(chart, label, color, data, bcolor) {
                chart.data.datasets.push({
                    label: label,
                    backgroundColor: color,
                    borderColor: bcolor,
                    data: data,
                    fill: true,
                });
                chart.update();
            }

            setTimeout(function () {

                function random_rgba() {
                    var trans = '0.5'; 
                    var color = 'rgba(';
                    for (var i = 0; i < 3; i++) {
                        color += Math.floor(Math.random() * 255) + ',';
                    }
                    color += trans + ')'; 
                    return color;
                }

                function random_hash() {
                    var trans = '0.5'; 
                    var color = 'rgba(';
                    for (var i = 0; i < 3; i++) {
                        color += Math.floor(Math.random() * 255) + ',';
                    }
                    color += trans + ')'; 
                    return color;
                }

                $.each(data.data, function (key, value) {
                    var count = [];
                    $.each(value, function (innerkey, innervalue) {
                        count.push(innervalue);
                    });
                    addData(chart, "Apartment Members of :" + key + "", random_rgba(), count, random_hash());
                });
            }, 0);
            var ctx = document.getElementById("lineChart").getContext('2d');
            var chart = new Chart(ctx, { type: 'line', 
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    datasets: [],}, 
                    options: {
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Months'
                                }
                            }],
                            yAxes: [{
                                display: true,

                                ticks: {
                                    min: 0,
                                }
                            }]
                        },
                        responsive: true,
                        maintainAspectRatio: true} 
                    });
        },
    });




    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })


</script>

@endsection