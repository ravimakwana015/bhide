@extends('layouts.appnew')
@section('content') 
<div class="main new-theme chat-page-main">
    <div class="chat-headng-wrap">
        <h1>Residents Connect</h1>
        <ul class="concierge-list">
            @if(isset($concierges))
            @foreach($concierges as $concierge)
            <li @if($concierge['livestatus'] == 'active') onclick="setConcierge({{ $concierge['id'] }})" @endif>
                <form method="post" action="">
                    <input type="hidden" id="concierge_name_{{ $concierge['id'] }}" value="{{ $concierge['name'] }}">
                </form>
                <h2 class="con-name">{{$concierge['name']}}</h2>
                <span @if($concierge['livestatus'] == 'inactive') id="offline" @else  id="online" @endif ><i class="fas fa-circle"></i></span>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
    <span id="noconcierge"></span>
    <section class="chat-wrap">
        <div class="chat-listing-wrap">
            <form method="post" action="" id="searchForm">
                <input type="hidden" name="company_id" id="company_id" value="{{ Auth::user()->company->id }}">
                <input type="Search" name="search" id="search" placeholder="Search Here..">
                <i class="fas fa-search"></i>
            </form>
            <span style="text-align: center; color: red;" id="nousersfound"></span>
            <div class="chat-listing" id="chat-sidebar-renderId" style="display: none;">
                <span id="renders_chat_users"></span>
            </div>
            <div class="chat-listing" id="chat-sidebar-mainId">
                <span id="chatusers"></span>
                @if(isset($chatLists))
                @foreach($chatLists as $conciergekey => $chatListing)
                <div class="chatlist-wrap">
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
                        {{-- <div class="chat-contact-wrap" onclick="getChat({{$chatList->id}},{{ request()->route('id') }})"> --}}
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
                            @php
                            $notCount = ChatCount($chatList->id,getUserId($conciergekey));
                            @endphp
                            @if($notCount > 0)
                            <span id="notification_{{$chatList->id}}_{{ getUserId($conciergekey) }}" class="numbers">{{ ChatCount($chatList->id,getUserId($conciergekey)) }}</span>
                            @endif
                            {{-- <span class="time">{{ ChatLastMessage($chatList->id,request()->route('id')) }}</span>
                            <span class="numbers">{{ ChatCount($chatList->id,request()->route('id')) }}</span> --}}
                        </div>

                        @endif
                    </div>
                    @endforeach
                </div>
                @endforeach
                @endif
            </div>
        </div>

        <div class="chat-msg-wrap">
            <div class="chat-heading">
                @if(isset($conciergesOnline))
                @if($conciergesOnlineCount == 1)
                <h2 id="NameCon">{{ $conciergesOnline[0]->name }}</h2>
                <span id="online" style="color: green;"><i class="fas fa-circle"></i> Active</span>
                @else
                <h2 id="NameCon">Please Select Concierge</h2>
                <span id="online" class="newonline"><i class="fas fa-circle"></i> Active</span>
                @endif
                @endif
            </div>
            <div class="chat-msg-wrap-main">
                <span id="poll_result_user"></span>
            </div>
            <div class="chat-footer-bar">
                <form method="post" action="">
                    <textarea id="messageWrite" placeholder="Type a message"></textarea>
                    <input type="hidden" name="form_appUserid" id="form_appUserid">
                    @if(isset($conciergesOnline))
                    @if($conciergesOnlineCount == 1)
                    
                    <input type="hidden" name="form_Concierge_id" id="form_Concierge_id" value="{{ $conciergesOnline[0]->id }}">
                    
                    @else
                    <input type="hidden" name="form_Concierge_id" id="form_Concierge_id">
                    @endif
                    @endif
                    <button type="button" class="btn" id="SendButton">Send</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
@push('js')
<script>

    function setConcierge(Concierge_id)
    {
        var conciergename = $('#concierge_name_'+Concierge_id).val();
        $('#form_Concierge_id').val(Concierge_id);
        $('#NameCon').html(conciergename);
        $('.newonline').css('color','green');
        $('#noconcierge').html('');

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: '{{ route("chatSidebarslide") }}',
            type: "post",
            data: {
                Concierge_id: Concierge_id
            },
            dataType: "json",
            success: function(res) {
                if(res.status==1){
                    $('#poll_result_user').html('');
                    $('#chat-sidebar-renderId').css('display','');
                    $('#chat-sidebar-mainId').css('display','none');
                    $('#renders_chat_users').html(res.data);
                    $('#NameCon').html('');
                    $('#NameCon').html(res.concierges);
                    $('#form_appUserid').val(appUserid);
                    $('#form_Concierge_id').val(Concierge_id);
                    $('#online').css('color','green');
                    $('#messageWrite').val('');
                }else{
                    $('#renders_chat_users').html('No Result Found');
                }
            }
        });

    }

    function getChat(appUserid,Concierge_id='')
    {
        // var messageBody = jQuery('.chat-msg-wrap-main');
        // messageBody.scrollTop = messageBody.scrollHeight;

        $('.chat-list').removeClass("active");
        $('#chatlist_'+appUserid+'_'+Concierge_id).addClass("active");
        $('#chatusers').html('');
        if(Concierge_id == '')
        {
            var form_Concierge_id = $('#form_Concierge_id').val();
        }
        else
        {
            var form_Concierge_id = Concierge_id;
        }

        if(form_Concierge_id == '' && Concierge_id == '')
        {
            $('#noconcierge').html('<div class="alert alert-danger"> Please Select Online Concierge </div>');
        }
        else
        {
            $('.newonline').css('color','green');
            var Concierge_id = form_Concierge_id;
            $('#poll_result').html('');
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: '{{ route("chatslide") }}',
                type: "post",
                data: {
                    appUserid: appUserid,
                    Concierge_id: Concierge_id
                },
                dataType: "json",
                success: function(res) {
                    if(res.status==1){
                        $('#poll_result_user').html(res.data);
                        $('#notification_'+appUserid+'_'+Concierge_id).html(res.countnot);
                        $('#NameCon').html('');
                        $('#NameCon').html(res.concierges);
                        $('#form_appUserid').val(appUserid);
                        $('#form_Concierge_id').val(Concierge_id);
                        $('#online').css('color','green');
                        var messageBody = $('.chat-msg-wrap-main');
                        messageBody.animate({ scrollTop: messageBody.prop('scrollHeight') }, 10);
                    }else{
                        $('#poll_result_user').html('No Result Found');
                    }
                }
            });
        }
    }

    $('#SendButton').click(function(){
        var message = $('#messageWrite').val();
        var appUserid = $('#form_appUserid').val();
        var Concierge_id = $('#form_Concierge_id').val();
        
        if(appUserid != '')
        {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: '{{ route("chatParticularslide") }}',
                type: "post",
                data: {
                    appUserid: appUserid,
                    Concierge_id: Concierge_id,
                    message: message
                },
                dataType: "json",
                success: function(res) {
                    if(res.status==1){
                        console.log(res);
                        $('#poll_result_user').html(res.data);
                        $('#NameCon').html('');
                        $('#NameCon').html(res.concierges);
                        $('#form_appUserid').val(appUserid);
                        $('#form_Concierge_id').val(Concierge_id);
                        $('#online').css('color','green');
                        $('#messageWrite').val('');
                        var messageBody = $('.chat-msg-wrap-main');
                        messageBody.animate({ scrollTop: messageBody.prop('scrollHeight') }, 10);
                    }else{
                        $('#poll_result_user').html('No Result Found');
                    }
                }
            });
        }
        else
        {
            $('#chatusers').html('<div class="alert alert-danger"> Please Select User </div>');
        }

    })

    $("#search").keyup(function() {
        var search = $('#search').val();
        var company_id = $('#company_id').val();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: '{{ route("chatsearch") }}',
            type: "post",
            data: {
                search: search,
                company_id: company_id
            },
            dataType: "json",
            success: function(res) {
                if(res.status==1)
                {
                    $('.newonline').css('color','');
                    $('#poll_result_user').html('');
                    $('#nousersfound').html('');
                    $('#chat-sidebar-renderId').css('display','');
                    $('#chat-sidebar-mainId').css('display','none');
                    $('#renders_chat_users').html(res.data);
                    $('#NameCon').html('');
                    $('#NameCon').html(res.concierges);
                    $('#form_appUserid').val(appUserid);
                    $('#form_Concierge_id').val(Concierge_id);
                    $('#online').css('color','green');
                }
                else
                {
                    $('#nousersfound').html('No Users Found');
                }
            }
        });
    });


    $('#searchForm').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
    }
});
</script>
@endpush