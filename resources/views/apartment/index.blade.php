@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Apartment Residents') }}</h3>
            </div>
            <div class="btn-wrap">
                <a href="{{ route('apartment.create') }}" class="btn btn-outline-primary"><i class="fas fa-user-plus"></i> Add Resident</a>
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
                <h3>Filter</h3>
                <div class="row">
                    <div class="col-md-4">
                        <label>Select Apartment Unit</label>
                        {!! Form::select('unit', array_unique($flats), null, ["class" => "select2 form-control search-input-select"]) !!}
                    </div>
                </div>
            </div>
            <hr/>
            <br/>
            <div class="table-responsive">
                <table id="booking" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            {{-- <th>{{__('Company')}}</th> --}}
                            <th>{{__('Name')}}</th>
                            <th>{{__('Resident Type')}}</th>
                            <th>{{__('Apartment Number')}}</th>
                            <th>{{__('Contact Email')}}</th>
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
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

<script>
    (function () {
		var dataTable = $('#booking').DataTable({
			processing: true,
			// serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route("get.apartment.users") }}',
				type: 'post',
				data: function(d) {
					d.unit = $('select[name=unit]').val();
				}
			},
			columns: [
			{data: null, searchable: false, sortable: false},
			// {data: 'company_name', name: 'company_name', searchable: false, sortable: false},
			{data: 'name', name: 'name'},
			{data: 'member_type', name: 'member_type'},
			{data: 'unit_name', name: 'unit_name',searchable: false, sortable: false},
			{data: 'email', name: 'email'},
			{data: 'phone_number', name: 'phone_number'},
			{data: 'created_at', name: 'created_at'},
			{data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
			],
			order: [[5, "desc"]],
			searchDelay: 500,
			"fnRowCallback": function (nRow, aData, iDisplayIndex) {
				$("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
				return nRow;
			}
        });
        $('select[name=unit]').on('change', function() {
			dataTable.draw();
		});
		Backend.DataTableSearch.init(dataTable);
	})();
</script>
@endpush
