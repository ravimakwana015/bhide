@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Concierge') }}</h3>
            </div>
            <div class="btn-wrap">
                <a href="{{ route('concierges.create') }}" class="btn btn-outline-primary"><i class="fas fa-user-shield"></i> Add Concierge</a>
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

                </div>
            </div>
            <br/>
            <div class="table-responsive">
                <table id="concierges" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Profile Picture')}}</th>
                            <th>{{__('Full Name')}}</th>
                            {{-- <th>{{__('Shift Time')}}</th> --}}
                            <th>{{__('Clock')}}</th>
                            <th>{{__('Core')}}</th>
                            <th>{{__('Date Of Birth')}}</th>
                            <th>{{__('Email')}}</th>
                            <th>{{__('Contact Number')}}</th>
                            <th>{{__('Date Created')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- @include('dentist-booking.modal') --}}
@endsection
@push('js')
<script>
    (function () {
      var dataTable = $('#concierges').DataTable({
         processing: true,
			// serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route("get.concierges") }}',
				type: 'post',
				// data: function(d) {
				// 	d.month = $('select[name=month]').val();
				// 	d.year = $('select[name=year]').val();
				// 	d.from_date = $('input[name="from_date"]').val();
				// 	d.to_date = $('input[name="to_date"]').val();
				// 	d.status = $('select[name=status]').val();
				// 	d.payment_status = $('select[name=payment_status]').val();
				// }
			},
			columns: [
			{data: null, searchable: false, sortable: false},
			{data: 'concierge_image', name: 'concierge_image', searchable: false, sortable: false},
			{data: 'name', name: 'name'},
			// {data: 'shift', name: 'shift', "width": "15%"},
            {data: 'clock', name: 'clock', "width": "40%"},
            {data: 'gate', name: 'gate'},
            {data: 'date_of_birth', name: 'date_of_birth'},
            {data: 'email', name: 'email'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "10%"}
            ],
            order: [[3, "asc"]
            ],
            searchDelay: 500,
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
                return nRow;
            }
        });
      Backend.DataTableSearch.init(dataTable);
  })();
</script>


<script type="text/javascript">

    function clockstartend(id)
    {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: '{{ route("clock") }}',
            type: "post",
            data: {
                concierge_id: id
            },
            dataType: "json",
            success: function(res) {
                if(res.status==1)
                {
                    $('#clock_'+id).html('');
                    // $('#forclass_'+id).html('');
                    $('#time_'+id).html('');
                    $('#forclass_'+id).removeClass('btn btn-danger');
                    $('#forclass_'+id).addClass(res.newclass);
                    $('#clock_'+id).html(res.msg);
                    $('#time_'+id).html(res.button);
                }
                else
                {
                    $('#clock_'+id).html('');
                    $('#time_'+id).html('');
                    // $('#forclass_'+id).html('');
                    $('#forclass_'+id).removeClass('btn');
                    $('#forclass_'+id).addClass(res.newclass);
                    $('#clock_'+id).html(res.msg);
                    $('#time_'+id).html(res.button);
                }
            }
        });
    }

</script>
@endpush
