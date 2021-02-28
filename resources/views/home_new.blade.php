@extends('layouts.appnew')

@section('content')
<div class="main new-theme new-dashboard-page">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <section class="appointment-info till-grids">
        <div class="three-col-grids">
            <div class="three-col-grid top-grids grids">
                <div class="heading-wrap">
                    <h3>Quick Views</h3>
                </div>
                <div class="visitor-listing service-listing">
                    <div class="grid top-grid">
                        <a href="{{ route('units.index') }}">
                            <h3>{{ $master['units'] }}</h3>
                            <span>Apartments</span>
                        </a>
                    </div>
                    <div class="grid top-grid">
                        <a href="{{ route('apartment.index') }}">
                            <h3>{{ $master['appUsers'] }}</h3>
                            <span>Residents</span>
                        </a>
                    </div>
                    <div class="grid top-grid">
                        <a href="{{ route('concierges.index') }}">
                            <h3>{{ $master['concierges'] }}</h3>
                            <span>Concierge</span>
                        </a>
                    </div>
                    <div class="grid top-grid">
                        <a href="{{ route('parcels.index') }}">
                            <h3>{{ $master['parcels'] }}</h3>
                            <span>Today’s Parcel</span>
                        </a>
                    </div>
                    <div class="grid top-grid">
                        <a href="{{ route('issues.index') }}">
                            <h3>{{ $master['issue'] }}</h3>
                            <span>Todays Requests</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="three-col-grid service-list-wrap issue-request-wrap">
                <div class="heading-wrap">
                    <h3>Total Issue Requests <span>{{ count($master['counttodayIssue']) }}</span></h3>
                    <div class="right-btn">
                        <a href="{{ route('issues.index') }}">Show All</a>
                    </div>
                    <ul class="right-link">
                        <li @if (!isset($_GET['issue']) && \Request::route()->getName() == 'home') class="active"
                            @endif><a href="{{ route('home') }}">Today</a>
                        </li>
                        <li @if (isset($_GET['issue']) && $_GET['issue']=='month' ) class="active" @endif><a
                            href="?issue=month">Month</a>
                        </li>
                        <li @if (isset($_GET['issue']) && $_GET['issue']=='year' ) class="active" @endif>
                            <a href="?issue=year">Year</a>
                        </li>
                    </ul>
                </div>
                <div class="visitor-listing issue-listing-wrap">
                    <ul class="issue-listing">
                        @forelse ($master['todayIssue'] as $issue)
                        @if($issue->status==1)
                        <li>
                            <div class="pro-img">
                                @if(isset($issue->userApp->member_image))
                                <img src="{{ asset('public/front/member_image/' . $issue->userApp->member_image) }}" >
                                @else
                                <img src="{{ asset('public/front') }}/images/profile.jpeg">
                                @endif
                            </div>
                            <div class="pro-info">
                                <a href="{{ route('issues.edit', $issue->id) }}">
                                    <h4>{{ $issue->userApp->last_name }} {{ $issue->userApp->first_name }}</h4>
                                    <h4>{{ $issue->issue }}</h4>
                                </a>
                                <span>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($issue->created_at))->diffForHumans() }}</span>
                            </div>
                            <div class="status done">Done</div>
                        </li>
                        @elseif($issue->status==0)
                        <li>
                            <div class="pro-img">
                                @if(isset($issue->userApp->member_image))
                                <img src="{{ asset('public/front/member_image/' . $issue->userApp->member_image) }}" >
                                @else
                                <img src="{{ asset('public/front') }}/images/profile.jpeg">
                                @endif
                            </div>
                            <div class="pro-info">
                                <a href="{{ route('issues.edit', $issue->id) }}">
                                    <h4>{{ $issue->userApp->last_name }} {{ $issue->userApp->first_name }}</h4>
                                    <h4>{{ $issue->issue }}</h4>
                                </a>
                                <span>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($issue->created_at))->diffForHumans() }}</span>
                            </div>
                            <div class="status pending">Pending</div>
                        </li>
                        @elseif($issue->status==2)
                        <li>
                            <div class="pro-img">
                                @if(isset($issue->userApp->member_image))
                                <img src="{{ asset('public/front/member_image/' . $issue->userApp->member_image) }}" >
                                @else
                                <img src="{{ asset('public/front') }}/images/profile.jpeg">
                                @endif
                            </div>
                            <div class="pro-info">
                                <a href="{{ route('issues.edit', $issue->id) }}">
                                    <h4>{{ $issue->userApp->last_name }} {{ $issue->userApp->first_name }}</h4>
                                    <h4>{{ $issue->issue }}</h4>
                                </a>
                                <span>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($issue->created_at))->diffForHumans() }}</span>
                            </div>
                            <div class="status in-review">In Review</div>
                        </li>
                        @endif
                        @empty
                        No Issue Requests Found
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="three-col-grid service-list-wrap">
                <div class="heading-wrap">
                    <h3>Services <span>{{ count($master['countservices']) }}</span></h3>
                    <div class="right-btn">
                        <a href="{{ route('services.index') }}">Show All</a>
                    </div>
                </div>
                <div class="visitor-listing service-listing">
                    <ul>
                        @forelse ($master['services'] as $service)
                        <li>
                            <div class="pro-icon"><i class="fas fa-life-ring"></i></div>
                            <div class="pro-info">
                                <h4>{{ $service->service_provider_name }},</h4>
                                <span>{{ $service->service_name }},</span> <span>
                                    <a href="tel:{{ $service->contact_number }}">{{ $service->contact_number }}</a>
                                </span>
                            </div>
                            @if($service->status==0)
                            <div class="status close">Close</div>
                            @elseif($service->status==1)
                            <div class="status open">Open</div>
                            @endif
                        </li>
                        @empty
                        <div class="no-msg">No Services Found</div>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="three-col-grid">
                <div class="heading-wrap">
                    <h3>Parcel <span>{{ count($master['countparcels']) }}</span></h3>
                    <div class="right-btn">
                        <a href="{{ route('parcels.index') }}">Show All</a>
                    </div>
                </div>
                <div class="visitor-listing">
                    <ul>
                        @forelse ($master['allparcels'] as $service)
                        <li>
                            <div class="pro-info">
                                <h4>{{ $service->unit }},</h4>
                                <span>Total Parcel - {{ $service->total_parcel }}@if(isset($service->name)),@endif {{ $service->name }}</span> 
                                @if($service->status==0)
                                <span>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($service->created_at))->diffForHumans() }}</span> 
                                @elseif($service->status==1)
                                <span>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($service->updated_at))->diffForHumans() }}</span> 
                                @endif
                            </div>
                            @if($service->status==0)
                            <div class="status close">Pending</div>
                            @elseif($service->status==1)
                            <div class="status open">Collected</div>
                            @endif
                        </li>
                        @empty
                        <div class="no-msg">No Services Found</div>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="three-col-grid">
                <div class="heading-wrap">
                    <h3>Visitors <span>{{ $master['countvisitors']->total() }}</span></h3>
                    <div class="right-btn">
                        <a href="{{ route('visitors.index') }}">Show All</a>
                    </div>
                </div>
                <div class="visitor-listing">
                    <ul>
                        @forelse ($master['visitors'] as $visitor)
                        <li>
                            <div class="pro-info">
                                <h4>{{ $visitor->visitor_name }}</h4>
                                <span>{{ $visitor->unitName->block_number }}-{{ $visitor->unitName->flat_number }}, {{ $visitor->reason }}</span>
                            </div>
                            <div class="day-data">
                                {{ \Carbon\Carbon::createFromTimeStamp(strtotime($visitor->check_in_date))->diffForHumans() }}
                            </div>
                        </li>
                        @empty
                        <div class="no-msg">No Visitors Found</div>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="three-col-grid">
                <div class="heading-wrap">
                    <h3>Notifications 
                        @if(count(auth()->user()->Notifications))
                        <span>{{ count(auth()->user()->Notifications) }}</span>
                        @endif
                    </h3>
                    <div class="right-btn">
                        <a href="{{ route('show.all.notification') }}">Show All</a>
                    </div>
                </div>
                <div class="Notification-listing">
                    <ul>
                        @foreach(auth()->user()->Notifications->take(5) as $notification)
                        <li>
                            <div class="checked"></div>
                            <div class="notification">
                                <a href="{{ route('issues.index') }}" onclick="markAsRead(this,'{{ $notification->id }}')">{!! $notification->data['data'] !!}
                                </a>
                                <div class="day-data"><i class="far fa-clock"></i> {{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}</div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="three-col-grid">
                <div class="heading-wrap">
                    <h3>Message Board <span>{{ $master['countmessageBoard']->total() }}</span></h3>
                    <div class="right-btn">
                        <a href="{{ route('messageBoard.index') }}">Show All</a>
                    </div>
                </div>
                <div class="visitor-listing">
                    <ul>
                        @forelse ($master['messageBoard'] as $message)
                        <li>
                            <div class="pro-info">
                                <h4>{{ $message->title }}</h4>
                                <span>{{ $message->description }}</span>
                            </div>
                            <div class="day-data">
                                {{ \Carbon\Carbon::createFromTimeStamp(strtotime($message->created_at))->diffForHumans() }}
                            </div>
                        </li>
                        @empty
                        <div class="no-msg">No Message Found</div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="emergencyAlarmModal" tabindex="-1" role="dialog" aria-labelledby="emergencyAlarmModalTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLongTitle">Emergency Alarm</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="post" id="emergency_alarms_form">
            <div class="modal-body">
                <div id="error_message"></div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="sendEmergencyAlarms()" class="btn btn-outline-secondary">Send
                Emergency Alarms</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

@push('js')

<script>
    $('#emergencyAlarm').click(function (e) {
        e.preventDefault();
        $('#emergencyAlarmModal').modal('show');
    });
    function sendEmergencyAlarms(){
        $("#loading").show();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: '{{ route("send.emergency.alarm") }}',
            type: "post",
            data: $("#emergency_alarms_form").serialize(),
            dataType: "json",
            success: function(res) {
                $("#loading").hide();
                $("#error_message").html(
                    '<div class="alert alert-success">' + res.msg + "</div>"
                    );
                setTimeout(() => {
                    $('#emergencyAlarmModal').modal('hide');
                },3000);
            },
            error: function(err) {
                $("#loading").hide();
                if (err.status == 422) {
                    console.log(err);
                    $('#error_message').fadeIn().html('<div class="alert alert-danger">'+err.responseJSON.msg+'</div>');
                    $.each(err.responseJSON.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        $(".error_msg").remove();
                        el.after(
                            $(
                                '<span style="color: red;" class="error_msg">' +
                                error[0] +
                                "</span>"
                                )
                            );
                    });
                }
            }
        });
    }
</script>

<script type="text/javascript">
    var tday=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var tmonth=["1","2","3","4","5","6","7","8","9","10","11","12"];

    function GetClock(){
        var  currentDate  =  new  Date().toLocaleString("en-US", {timeZone: "Europe/London"});
        var d=new Date(currentDate);
        var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getFullYear();
        var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

        

        if(nhour==0){ap=" AM";nhour=12;}
        else if(nhour<12){ap=" AM";}
        else if(nhour==12){ap=" PM";}
        else if(nhour>12){ap=" PM";nhour-=12;}

        if(nmin<=9) nmin="0"+nmin;
        if(nsec<=9) nsec="0"+nsec;

        var clocktext=" "+ndate+"/"+tmonth[nmonth]+"/"+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
        document.getElementById('clockbox').innerHTML=clocktext;
    }

    GetClock();
    setInterval(GetClock,1000);
</script>




@endpush
