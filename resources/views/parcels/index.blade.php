@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Parcels') }}</h3>
            </div>
            <div class="btn-wrap">
                <a href="javascript:;" class="btn btn-outline-primary" id="add-Parcel"><i
                        class="fas fa-user-circle"></i> Add Parcel</a>
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
            {{-- <div class="box-header">
                <h3>Filter</h3>
                <div class="row">
                    <div class="col-md-4">
                        <label>Select Apartment Unit</label>
                        {!! Form::select('unit', array_unique($flats), null, ["class" => "select2 form-control search-input-select"]) !!}
                    </div>
                </div>
            </div> --}}
            <hr />
            <br />
            <div class="table-responsive">
                <table id="parcels" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Apartment Number')}}</th>
                            <th>{{__('Total Parcels')}}</th>
                            <th>{{__('Collected By')}}</th>
                            <th>{{__('Comment')}}</th>
                            <th>{{__('Date Collected')}}</th>
                            {{-- <th>{{__('Status')}}</th> --}}
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include("parcels.form")
<div id="edit_modal_content"></div>
@endsection
@push('js')
<script>
    $('#add-Parcel').click(function (e) {
        $('#addParcels').modal('show');
    });
    $(document).ready(function () {
      $('#create-parcels').validate({
        rules:{
          unit_id: {
            required: true
        },
        total_parcel: {
            required: true,
            digits: true
        },
        status: {
            required: true
        },
    },
    messages: {
        total_parcel:{
            digits:'Please Enter Number Only'
        }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
  },
  highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
  },
  unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
  },
  submitHandler: function (form) {
    addService('{{ route('parcels.store') }}','create-parcels','parcels','addParcels');
    return false;
}
});
  });
    (function () {
      var dataTable = $('#parcels').DataTable({
         processing: true,
         // serverSide: true,
         ajax: {
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
           url: '{{ route("get.parcels") }}',
           type: 'post',
           data: function(d) {
            d.unit = $('select[name=unit]').val();
        }
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
			{data: 'total_parcel', name:'total_parcel'},
            {data: 'name', name: 'name'},
            {data: 'comment', name: 'comment'},
            {data: 'created_at', name: 'created_at'},
            // {data: 'status', name: 'status'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
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


<script type="text/javascript">
    function parcelsDetails(poll_id)
    {
      $('#poll_result').html('');
      $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: '{{ route("get.parcels.details") }}',
        type: "post",
        data: {
            id: poll_id
        },
        dataType: "json",
        success: function(res) {
            if(res.status==1){
                $('#parcel_result_user').html(res.result);
                $('#parcelsdetails').modal('show');
            }else{
                $('#parcel_result_user').html('No Result Found');
                $('#parcelsdetails').modal('show');
            }
        }
    });
  }
</script>


@endpush
