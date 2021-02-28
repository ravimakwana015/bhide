<header class="header-newtheme">
    <div class="top-content">
        {{-- <div class="greting-msg">Hello, Welcome John</div> --}}
        <div class="greting-msg">Hello, {{ \App\Models\Company::where(['user_id' => Auth::user()->id])->pluck('company_name')->first() }}</div>
        @if(\Auth::user())
        <div class="profile-wrap">
            <a href="javascript:void(0);">
                @if(isset(\Auth::user()->Company->building_image))
                <img src="{{ asset('public/front') }}/building_image/{{ \Auth::user()->Company->building_image }}" class="img-responsive" alt="Building">
                @else
                <img src="{{ asset('public/front') }}/images/building.png" alt="thum">
                @endif
            </a>
            <div class="profile-option">
                <ul>
                    {{-- @if(\Auth::user()->subscribed('main')) --}}
                    <li><a href="{{ route('edit') }}">My Account</a></li>
                    {{-- @endif --}}
                    <li>
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        {{-- @if(\Auth::user()->subscribed('main')) --}}
        <ul class="menu">
            <li><a href="{{ url('dashboard') }}">
                <img src="{{ asset('public/front') }}/images/home.svg">
            </a></li>
        </ul>
        {{-- <div class="notification-wrap">
            <div class="notification-icon">
                @if(count(auth()->user()->unreadNotifications))
                <span class="noti-bell">{{ count(auth()->user()->unreadNotifications) }}</span>
                @endif
                <img src="{{ asset('public/front') }}/images/notification.svg">
            </div>
            <ul>
                <li>This is notification.</li>
                <li>This is notification.</li>
                <li>This is notification.</li>
                <li>This is notification.</li>
            </ul>
        </div> --}}
        <div class="notification-wrap">
            <div class="notification-icon">
                @if(count(auth()->user()->unreadNotifications))
                <span class="noti-bell">{{ count(auth()->user()->unreadNotifications) }}</span>
                @endif
                <img src="{{ asset('public/front') }}/images/notification.svg">
            </div>
            <ul>
                @foreach(auth()->user()->unreadNotifications->take(5) as $notification)
                <li><a href="{{ route('issues.index') }}"
                    onclick="markAsReads(this,'{{ $notification->id }}')">{!! $notification->data['data'] !!}</a>
                </li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- @endif --}}
    </div>
    <div class="bottom-content">
        <div class="company-name">
            <h2>
                @auth
                {{ \App\Models\Company::where(['user_id' => Auth::user()->id])->pluck('company_name')->first() }} - Dashboard <span id="clockbox"></span>
                @endauth
            </h2>
        </div>
        <div class="alarm-btn" style="text-align: right;">
            <a href="javascript:;" id="emergencyAlarm">
                <img src="{{ asset('public/front') }}/images/alarm.png" />
            </a>
        </div>
    </div>
</header>

<script>
    function markAsReads(element, id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('markAsRead.notification') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id
            },
        }).done(function (res) {
            $(element).closest("div").removeClass('unread');
        });
    }
</script>
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

        var clocktext=" "+ndate+"-"+tmonth[nmonth]+"-"+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
        document.getElementById('clockbox').innerHTML=clocktext;
    }

    GetClock();
    setInterval(GetClock,1000);
</script>