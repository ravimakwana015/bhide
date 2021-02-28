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
            <form method="post">
                <input type="hidden" name="company_id" id="company_id" value="{{ Auth::user()->company->id }}">
                <input type="Search" name="search" id="search" placeholder="Search Here..">
                <i class="fas fa-search"></i>
            </form>
            <div class="chat-listing">
                <span id="chatusers"></span>
                <h3 class="chatgroup">Smith Mike</h3>
                @if(isset($chatLists))
                @foreach($chatLists as $chatList)
                <div class="chat-list" id="chatlist_{{ $chatList->id }}">
                    @if(isset($chatList->member_image))
                    <img src="{{ asset('public/front/member_image/') }}/{{ $chatList->member_image }}">
                    @else
                    <img src="https://demo.joykal.com/laravel/aptly/public/front/images/male.jpg">
                    @endif
                    @if($conciergesCount >= 2)
                    <div class="chat-contact-wrap" id="button1" onclick="getChat({{$chatList->id}})">
                        <h3>{{ $chatList->first_name }} {{ $chatList->last_name }}</h3>
                        @foreach($chatList->getUnitAttribute() as $chatunit)
                        <span>{{ $chatunit->block_number }}-{{ $chatunit->flat_number }}</span>
                        @endforeach
                    </div>
                    @else
                    <div class="chat-contact-wrap" onclick="getChat({{$chatList->id}},{{ request()->route('id') }})">
                        <h3>{{ $chatList->first_name }} {{ $chatList->last_name }}</h3>
                        @foreach($chatList->getUnitAttribute() as $chatunit)
                        <span>{{ $chatunit->block_number }}-{{ $chatunit->flat_number }}</span>
                        @endforeach
                    </div>
                    @endif
                    <div class="time-Wrap">
                        <span class="time">{{ ChatLastMessage($chatList->id,request()->route('id')) }}</span>
                        <span class="numbers">{{ ChatCount($chatList->id,request()->route('id')) }}</span>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        <div class="chat-msg-wrap">
            <div class="chat-heading">
                @if(isset($conciergesOnline))
                @if(count($conciergesOnline) == 1)
                @foreach($conciergesOnline as $concierge)
                <h2>{{ $concierge['name'] }}</h2>
                <span id="online" style="color: green;"><i class="fas fa-circle"></i> Active</span>
                @endforeach
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
                    @if(count($conciergesOnline) == 1)
                    @foreach($conciergesOnline as $concierge)
                    <input type="hidden" name="form_Concierge_id" id="form_Concierge_id" value="{{ $concierge['id'] }}">
                    @endforeach
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
    }

    function getChat(appUserid,Concierge_id='')
    {
        $('.chat-list').removeClass("active");
        $('#chatlist_'+appUserid).addClass("active");
        $('#chatusers').html('');
        var form_Concierge_id = $('#form_Concierge_id').val();
        
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
                        $('#NameCon').html('');
                        $('#NameCon').html(res.concierges);
                        $('#form_appUserid').val(appUserid);
                        $('#form_Concierge_id').val(Concierge_id);
                        $('#online').css('color','green');
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
                        $('#poll_result_user').html(res.data);
                        $('#NameCon').html('');
                        $('#NameCon').html(res.concierges);
                        $('#form_appUserid').val(appUserid);
                        $('#form_Concierge_id').val(Concierge_id);
                        $('#online').css('color','green');
                        $('#messageWrite').val('');
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
                if(res.status==1){
                    $('#poll_result_user').html(res.data);
                    $('#NameCon').html('');
                    $('#NameCon').html(res.concierges);
                    $('#form_appUserid').val(appUserid);
                    $('#form_Concierge_id').val(Concierge_id);
                    $('#online').css('color','green');
                }else{
                    $('#poll_result_user').html('No Result Found');
                }
            }
        });
    });

    // $(document).on('change', '#search', function(){
    //     var search = $('#search').val();
    //     console.log(search);
    // });
    
</script>
@endpush