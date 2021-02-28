<div class="chat-listing">
    <span id="chatusers"></span>
    @if(isset($chatLists))
    @foreach($chatLists as $conciergekey => $chatListing)
    <h3 class="chatgroup">{{ getUserName($conciergekey) }}</h3>
    
    @foreach($chatListing as $chatList)
    <div class="chat-list" id="chatlist_{{ $chatList->id }}_{{ getUserId($conciergekey) }}">
        @if(isset($chatList->member_image))
        <img src="{{ asset('public/front/member_image/') }}/{{ $chatList->member_image }}">
        @else
        <img src="https://demo.joykal.com/laravel/aptly/public/front/images/male.jpg">
        @endif

        @if($conciergesCount >= 2)
        <div class="chat-contact-wrap" id="button1" onclick="getChat({{$chatList->id}},{{ getUserId($conciergekey) }})">
            <h3>{{ $chatList->first_name }} {{ $chatList->last_name }}</h3>
            <span>{{ getUnitName($chatList->id) }}</span>
        </div>
        @else
        <div class="chat-contact-wrap" onclick="getChat({{$chatList->id}},{{ getUserId($conciergekey) }})">
            <h3>{{ $chatList->first_name }} {{ $chatList->last_name }}</h3>
            <span>{{ getUnitName($chatList->id) }}</span>
        </div>
        @endif
        @if($conciergesCount >= 2)
        <div class="time-Wrap">
            <span class="time">{{ ChatLastMessage($chatList->id,getUserId($conciergekey)) }}</span>
            @php
            $notCount = ChatCount($chatList->id,getUserId($conciergekey));
            @endphp
            @if($notCount > 0)
            <span id="notification_{{$chatList->id}}_{{ getUserId($conciergekey) }}" class="numbers">{{ ChatCount($chatList->id,getUserId($conciergekey)) }}</span>
            @endif
        </div>
        @else
        <div class="time-Wrap">
            <span class="time">{{ ChatLastMessage($chatList->id,getUserId($conciergekey)) }}</span>
            <span class="numbers">{{ ChatCount($chatList->id,getUserId($conciergekey)) }}</span>
        </div>

        @endif
    </div>
    @endforeach
    @endforeach
    @endif
</div>