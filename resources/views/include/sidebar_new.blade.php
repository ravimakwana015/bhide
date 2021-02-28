@if(\Auth::user())
<div class="new-sidemenu-main">
    <div class="sidebar-control"><i class="fas fa-angle-double-left"></i></div>
    <div class="brand-name">
        @if(\Auth::id())
        <a href="{{ url('dashboard') }}">
            @if(isset($settings->logo))
            <img src="{{ url('storage/app/img/logo/'.$settings->logo) }}">
            @endif
        </a>
        @else
        <a href="{{ url('/') }}">
            @if(isset($settings->logo))
            <img src="{{ url('storage/app/img/logo/1604068915aptly.png') }}">
            @endif
        </a>
        @endif
    </div>  
    <ul>
        <li
        class="submenu-main @if(\Request::route()->getName()=='edit' || \Request::route()->getName()=='services' || \Request::route()->getName()=='change.password' || \Request::route()->getName()=='companySettings.index') active @endif">
        <a href="javascript:;"><i class="fas fa-user-cog"></i> Settings</a>
        <ul>
            <li @if(\Request::route()->getName()=='companySettings.index') class="active" @endif>
                <a href="{{ route('companySettings.index') }}">Edit Settings</a>
            </li>
            <li @if(\Request::route()->getName()=='edit') class="active" @endif>
                <a href="{{ route('edit') }}">Edit Profile</a>
            </li>
            <li @if(\Request::route()->getName()=='change.password') class="active" @endif>
                <a href="{{ route('change.password') }}">Change Password</a>
            </li>
        </ul>
    </li>
    <li
    class="submenu-main @if(\Request::route()->getName()=='apartment.index' || \Request::route()->getName()=='units.index' || \Request::route()->getName()=='messageBoard.index' || \Request::route()->getName()=='concierges.index') active @endif">
    <a href="javascript:;"><i class="fas fa-building"></i> Apartment & Building </a>
    <ul>
        <li @if(\Request::route()->getName()=='apartment.index') class="active" @endif>
            <a href="{{ route('apartment.index') }}">Residents</a>
        </li>
        <li @if(\Request::route()->getName()=='units.index') class="active" @endif>
            <a href="{{ route('units.index') }}">Apartment Units</a>
        </li>
        <li @if(\Request::route()->getName()=='concierges.index') class="active" @endif>
            <a href="{{ route('concierges.index') }}">Concierges</a>
        </li>
        <li @if(\Request::route()->getName()=='feed') class="active" @endif>
            <a href="{{ route('feed') }}"></i> Message Board</a>
        </li>
    </ul>
</li>
<li @if(\Request::route()->getName()=='services.index') class="active" @endif>
    <a href="{{ route('services.index') }}"><i class="fab fa-servicestack"></i> Services</a>
</li>
        {{-- <li @if(\Request::route()->getName()=='facilities.index') class="active" @endif>
            <a href="{{ route('facilities.index') }}"><i class="fas fa-calendar-alt"></i> Facility</a>
        </li> --}}
        <li @if(\Request::route()->getName()=='visitors.index') class="active" @endif>
            <a href="{{ route('visitors.index') }}"><i class="fas fa-user-circle"></i> Visitors</a>
        </li>
        <li @if(\Request::route()->getName()=='loyaltyCard.index') class="active" @endif>
            <a href="{{ route('loyaltyCard.index') }}"><i class="fas fa-percent"></i> Loyalty Card</a>
        </li>
        <li @if(\Request::route()->getName()=='polls.index') class="active" @endif>
            <a href="{{ route('polls.index') }}"><i class="fas fa-poll"></i> Polls</a>
        </li>
        <li @if(\Request::route()->getName()=='parcels.index') class="active" @endif>
            <a href="{{ route('parcels.index') }}"><i class="fas fa-gift"></i> Parcels</a>
        </li>
        <li @if(\Request::route()->getName()=='emergency.index') class="active" @endif>
            <a href="{{ route('emergency.index') }}"><i class="fas fa-exclamation"></i> Emergency</a>
        </li>
        <li @if(\Request::route()->getName()=='issues.index') class="active" @endif>
            <a href="{{ route('issues.index') }}"><i class="fas fa-exclamation-triangle"></i> Issues</a>
        </li>
        <li @if(\Request::route()->getName()=='show.all.notification') class="active" @endif>
            <a href="{{ route('show.all.notification') }}"><i class="fas fa-bell"></i> Notification
                @if(count(auth()->user()->unreadNotifications))
                ({{ count(auth()->user()->unreadNotifications) }})
            @endif</a>
        </li>
        {{-- <li @if(\Request::route()->getName()=='chat') class="active" @endif>
            <a href="{{ route('chatparticular',6) }}"><i class="fas fa-exclamation-triangle"></i> Chat</a>
        </li> --}}
        <li @if(\Request::route()->getName()=='chatparticular') class="active" @endif>
            <a href="{{ route('chatparticular') }}"><i class="far fa-comment-alt"> </i>Chat</a>
        </li>
        
        <li class="submenu-main" @if(\Request::route()->getName()=='stripe.account' ||
        \Request::route()->getName()=='subscription') active @endif><a href="javascript:;"><i
            class="fas fa-wallet"></i>
        Billing</a>
        <ul>
            <li @if(\Request::route()->getName()=='subscription') class="active" @endif>
                <a href="{{ route('subscription') }}">Subscription</a>
            </li>
        </ul>
    </li>
        {{-- <li @if(\Request::route()->getName()=='notifications') class="active" @endif>
            <a href="{{ route('notifications') }}"> <i class="far fa-bell"></i> Notifications
        @if(isset(auth()->user()->unreadNotifications) &&
        count(auth()->user()->unreadNotifications))({{ count(auth()->user()->unreadNotifications) }})@endif</a>
    </li> --}}
    <li>
        <a href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
        class="fas fa-power-off"></i> {{ __('Logout') }}
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>
</ul>
<hr>
<div class="profile-sidebar" style="text-align: center;">
    <!-- SIDEBAR USERPIC -->
    <a href="{{ route('edit') }}">
        <!-- SIDEBAR USER TITLE -->
        <div class="profile-usertitle">
            <div class="profile-usertitle-name">
                {{ \Auth::user()->name }}
            </div>
            <div class="profile-usertitle-job">
                {{ \Auth::user()->email }}
            </div>
        </div>
    </a>
    <!-- END SIDEBAR USER TITLE -->
    <!-- SIDEBAR BUTTONS -->
    <div class="profile-userbuttons">
        <a href="{{ route('subscription') }}" class="btn btn-success btn-sm">Your Plan</a>
    </div>
    <!-- END SIDEBAR BUTTONS -->
</div>
</div>
@endif
