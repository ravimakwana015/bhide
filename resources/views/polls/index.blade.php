@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Polls') }}</h3>
            </div>
            <div class="btn-wrap">
                <a href="{{ route('polls.create') }}" class="btn btn-outline-primary"><i class="fas fa-poll"></i>
                Add Poll</a>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="box-header">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4" style="text-align: right;"></div>
                </div>
            </div>
            <br />
            <div class="table-responsive">
                <table id="polls" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Subject')}}</th>
                            <th>{{__('Poll Sub')}}</th>
                            <th>{{__('Date Created')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('include.modals')
@endsection
@push('js')
<script>

    function getPollUsers(poll_id)
    {
      $('#poll_result').html('');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: '{{ route("get.poll.users") }}',
            type: "post",
            data: {
                id: poll_id
            },
            dataType: "json",
            success: function(res) {
                if(res.status==1){
                    $('#poll_result_user').html(res.result);
                    $('#pollResultUser').modal('show');
                }else{
                    $('#poll_result_user').html('No Result Found');
                    $('#pollResultUser').modal('show');
                }
            }
        });
    }

    function getPollResult(poll_id){
        $('#poll_result').html('');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: '{{ route("get.poll.result") }}',
            type: "post",
            data: {
                id: poll_id
            },
            dataType: "json",
            success: function(res) {
                if(res.status==1){
                    $('#poll_result').html(res.result);
                    $('#pollResult').modal('show');
                }else{
                    $('#poll_result').html('No Result Found');
                    $('#pollResult').modal('show');
                }
            }
        });
    }
    (function () {
      var dataTable = $('#polls').DataTable({
         processing: true,
         // serverSide: true,
         ajax: {
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: '{{ route("get.polls") }}',
           type: 'post',
       },
       columns: [
       {data: null, searchable: false, sortable: false},
       {data: 'title', name: 'title'},
       {data: 'poll_submission', name: 'poll_submission'},
       {data: 'created_at', name: 'created_at'},
       {data: 'status', name: 'status'},
       {data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
       ],
       order: [[3, "desc"]],
       searchDelay: 500,
       "fnRowCallback": function (nRow, aData, iDisplayIndex) {
        $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
        return nRow;
    }
});
      Backend.DataTableSearch.init(dataTable);
  })();
</script>
@endpush
