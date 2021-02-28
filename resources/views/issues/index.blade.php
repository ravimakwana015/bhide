@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Requested Issues') }}</h3>
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
                <table id="issues" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Apartment Number')}}</th>
                            <th>{{__('Resident')}}</th>
                            <th>{{__('Issue Reported')}}</th>
                            <th>{{__('Date Reported')}}</th>
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
{{-- @include('dentist-booking.modal') --}}
@endsection
@push('js')
<script>
    (function () {
		var dataTable = $('#issues').DataTable({
			processing: true,
			// serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route("get.issues") }}',
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
			{data: 'unit', name: 'unit'},
			{data: 'name', name: 'name'},
			{data: 'issue', name: 'issue'},
			{data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},
			{data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
			],
			order: [[5, "desc"]],
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
