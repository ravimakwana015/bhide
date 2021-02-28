@extends('layouts.app')

@section('content')
<div class="main notification-page">
    <div class="profile-edit-page">
        <div class="col-12 mb-3" style="padding-left: 0px;">
            <a class="btn" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Back</a>
        </div>
        <div class="card shadow">
            <div class="card-header ">
                <div class="titleText">
                    <h3 class="mb-0">Notifications</h3>
                </div>
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('myproductsDeleteAll') }}">Delete All Selected</button>
                <div class="btn-wrap">
                    <a href="{{ route('read.all.notification') }}" class="btn mb-0">Mark all as Read</a>
                </div>
            </div>
            <div class="card-body">
                <div class="account-body">
                    <div class="my-account">
                        <div class="account-body">
                            <span id="successmsg" style="color: red;">

                            </span>
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
                            @foreach($userNotifications as $notification)
                            <div class="bill">
                                <a href="{{ route('delete.notification',[$notification->id]) }}" class="mr-1 btn btn-small"><i class="fa fa-trash"></i></a>
                                <input type="checkbox" class="sub_chk" data-id="{{$notification->id}}">
                                {{-- <input type="checkbox" id="deleteids" name=""> --}}
                                <h4>
                                    <div class="status bg-actor"></div>
                                    @if($notification->read_at==null)
                                    <div class="unread">
                                        @if(isset($notification->data['data']))
                                        @if($notification->type=='App\Notifications\MemberIssueRequest')
                                        <a href="{{ route('issues.index') }}"><span
                                            onclick="markAsRead(this,'{{ $notification->id }}')">{!! $notification->data['data']!!}</span>
                                        </a>
                                        @else
                                        <span onclick="markAsRead(this,'{{ $notification->id }}')">{!! $notification->data['data'] !!}
                                        </span>
                                        @endif
                                        @endif
                                        @if(isset($notification->data['message']))
                                        <span onclick="markAsRead(this,'{{ $notification->id }}')">{!! $notification->data['name']  !!} {!!
                                            $notification->data['message']!!}
                                        </span>
                                        @endif
                                    </div>
                                    @else
                                    <div>
                                        @if(isset($notification->data['data']))
                                        @if($notification->type=='App\Notifications\MemberIssueRequest')
                                        <a href="{{ route('issues.index') }}">
                                            <span>{!! $notification->data['data'] !!}</span>
                                        </a>
                                        @else
                                        <span>{!! $notification->data['data'] !!}</span>
                                        @endif
                                        @endif
                                        @if(isset($notification->data['message']))
                                        <span>{!! $notification->data['name']  !!} {!! $notification->data['message']  !!}</span>
                                        @endif
                                    </div>
                                    @endif
                                </h4>
                                
                            </div>
                            @endforeach
                            {{ $userNotifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function markAsRead(element, id) {
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

    $('#deleteids').click(function(id){
        alert(id);
    });
</script>

<script type="text/javascript">



    $('#master').on('click', function(e) {
     if($(this).is(':checked',true))  
     {
        $(".sub_chk").prop('checked', true);  
    } else {  
        $(".sub_chk").prop('checked',false);  
    }  
});


    $('.delete_all').on('click', function(e) {
        

        var allVals = [];  
        $(".sub_chk:checked").each(function() {  
            allVals.push($(this).attr('data-id'));
        });  

        console.log(allVals);
        if(allVals.length <=0)  
        {  
            alert("Please select row.");  
        }  else {  


            var check = confirm("Are you sure you want to delete this row?");  
            if(check == true){  


                var join_selected_values = allVals.join(","); 


                $.ajax({
                    url: $(this).data('url'),
                    type: 'DELETE',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: 'ids='+join_selected_values,
                    success: function (data) {
                        if (data['success']) {
                            $(".sub_chk:checked").each(function() {  
                                $(this).parents("tr").remove();
                            });
                                //alert(data['success']);
                                $('#successmsg').html('');
                                $('#successmsg').html(data['success']);
                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });


                $.each(allVals, function( index, value ) {
                  $('table tr').filter("[data-row-id='" + value + "']").remove();
              });
            }  
        }  
    });


    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        onConfirm: function (event, element) {
            element.trigger('confirm');
        }
    });


    $(document).on('confirm', function (e) {
        var ele = e.target;
        e.preventDefault();


        $.ajax({
            url: ele.href,
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                if (data['success']) {
                    $("#" + data['tr']).slideUp("slow");
                    alert(data['success']);
                } else if (data['error']) {
                    alert(data['error']);
                } else {
                    alert('Whoops Something went wrong!!');
                }
            },
            error: function (data) {
                alert(data.responseText);
            }
        });


        return false;
    });

</script>
@endpush
