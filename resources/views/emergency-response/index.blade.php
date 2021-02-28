@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
          <div class="titleText">
                <h3 class="mb-0">{{ __('Emergency Response') }}</h3>
            </div>
            <div class="btn-wrap">
              <a class="btn mb-0" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i>Back</a>
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
                    <label>Select Apartment Number</label>
                    {!! Form::select('unit', array_unique($flats), null, ["class" => "select2 form-control search-input-select"]) !!}
                </div>
            </div>
        </div>
        <hr/>
        <br/>
        <div class="table-responsive">
            <table id="emergency" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('Unit')}}</th>
                        <th>{{__('Member Name')}}</th>
                        <th>{{__('Note')}}</th>
                        <th>{{__('Safe')}}</th>
                        <th>{{__('Response Date')}}</th>
                        {{-- <th>{{__('Action')}}</th> --}}
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
      var dataTable = $('#emergency').DataTable({
         processing: true,
         // serverSide: true,
         ajax: {
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: '{{ route("get.emergency.response") }}',
           type: 'post',
           data: function(d) {
               d.unit = $('select[name=unit]').val();
           }
       },
       columns: [
       {data: null, searchable: false, sortable: false},
       {data: 'description', name: 'description'},
       {data: 'unit', name: 'unit'},
       {data: 'name', name: 'name'},
       {data: 'note', name: 'note'},
       {data: 'status', name: 'status'},
       {data: 'response_date', name: 'response_date'},
			// {data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
			],
			order: [[5, "desc"]
            ],
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
