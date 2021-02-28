<header>
    <div class="brand-name">
        @if(\Auth::id())
        <a href="{{ url('dashboard') }}">
            @if(isset($settings->logo))
            <img src="{{ url('storage/app/img/logo/'.$settings->logo) }}">
            @endif
        </a>
        @else
        <a href="https://www.aptlymanaged.com/{{-- {{ url('/') }} --}}">
            @if(isset($settings->logo))
            <img src="{{ url('storage/app/img/logo/1604068915aptly.png') }}">
            @endif
        </a>
        @endif
    </div>
    @if(\Auth::user())
    @if(\Auth::user()->subscribed('main'))
    <div class="toggle-menu">
        <span></span>
    </div>
    @endif
    @endif
    <div class="right-wap">
        @if(\Request::route()->getName()!='payment' && \Request::route()->getName()!='payment.details')
        @guest
        <ul class="main-menu">
            <li><a class="active" href="https://www.aptlymanaged.com/{{-- {{ route('landing.page') }} --}}">Home</a></li>
            <li><a href="https://www.aptlymanaged.com/discover{{-- {{ route('user.features') }} --}}">Discover</a></li>
            <li><a href="https://www.aptlymanaged.com/contact{{-- {{ route('user.contactus') }} --}}">Contact</a></li>
            {{-- @foreach($pagesforfront as $page)
            <li><a href="{{ route('user.dynamicPage',str_replace(' ', '-', $page->title)) }}">{{ ucfirst($page->title) }}</a></li>
            @endforeach --}}
            <li><a href="https://www.instagram.com/aptlymanaged/" target="_blank"><i class="fab fa-instagram"></i></a></li>
            {{-- <li><a class="btn" href="javascript:void(0);" id="loginpopup" data-toggle="modal" data-target="#exampleModalCenter">Login</a></li> --}}
            <li><a class="btn" href="{{ url('/') }}">Login</a></li>
        </ul>
        @endguest
        @endif
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
        {{-- @endif --}}
        @endif
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


