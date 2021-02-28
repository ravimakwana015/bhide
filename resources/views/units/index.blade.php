@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Apartment') }}</h3>
            </div>
            <div class="btn-wrap">
                <a href="{{ route('units.create') }}" class="btn btn-outline-primary"><i class="fas fa-door-open"></i> Add Apartment Unit</a>
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
            <br/>
            <div class="table-responsive">
                <table id="units" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Core')}}</th>
                            <th>{{__('Apartment Number')}}</th>
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
		var dataTable = $('#units').DataTable({
			processing: true,
			// serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route("get.user.units") }}',
				type: 'post',
			},
			columns: [
			{data: null, searchable: false, sortable: false},
			{data: 'block_number', name: 'block_number'},
			{data: 'flat_number', name: 'flat_number'},
            {data: 'created_at', name: 'created_at'},
			{data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
			],
			order: [[3, "desc"]],
			// searchDelay: 500,
			"fnRowCallback": function (nRow, aData, iDisplayIndex) {
				$("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
				return nRow;
			}
		});
		Backend.DataTableSearch.init(dataTable);
	})();
</script>
@endpush
