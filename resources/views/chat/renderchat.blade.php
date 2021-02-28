@if(!empty($chatDetails))
@foreach($chatDetails as $chatDetail)
@if($chatDetail->receiver_id != $sender)
<div class="chat_msg_wrap msg-sent-wrap">
    <div class="contact-info">
        @php
        $firstname = \App\Models\AppUsers::where(['id' => $sender])->pluck('first_name')->first();
        $lastname = \App\Models\AppUsers::where(['id' => $sender])->pluck('last_name')->first();
        $image = \App\Models\AppUsers::where(['id' => $sender])->pluck('member_image')->first();
        @endphp
        @if(!empty($image))
        <img src="{{ asset('public/front/concierges_image/') }}/{{ $image }}">
        @else
        <img src="https://demo.joykal.com/laravel/aptly/public/front/images/male.jpg">
        @endif
        <h3>{{ $firstname }} {{ $lastname }}</h3>
        <span>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($chatDetail->created_at))->diffForHumans() }}</span>
    </div>
    <div class="msg-wrap">
        <div class="msg">{{ $chatDetail->message }}</div>
    </div>
</div>
@else
<div class="chat_msg_wrap">
    <div class="contact-info">
        @php
        $firstname = \App\Models\AppUsers::where(['id' => $chatDetail->sender_id])->pluck('first_name')->first();
        $lastname = \App\Models\AppUsers::where(['id' => $chatDetail->sender_id])->pluck('last_name')->first();
        // $image = \App\Models\Concierges::where(['id' => $sender])->pluck('concierge_image')->first();
        $image = \App\Models\AppUsers::where(['id' => $chatDetail->sender_id])->pluck('member_image')->first();
        @endphp
        @if(!empty($image))
        <img src="{{ asset('public/front/member_image/') }}/{{ $image }}">
        {{-- <img src="{{ asset('public/front/concierges_image/') }}/{{ $image }}"> --}}
        @else
        <img src="https://demo.joykal.com/laravel/aptly/public/front/images/male.jpg">
        @endif
        <h3>{{ $firstname }} {{ $lastname }}</h3>
        <span>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($chatDetail->created_at))->diffForHumans() }}</span>
    </div>
    <div class="msg-wrap">
        <div class="msg">{{ $chatDetail->message }}</div>
    </div>
</div>
@endif

@endforeach
@endif