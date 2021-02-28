@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Loyalty Card Image') }}</h3>
            </div>
            <div class="btn-wrap">
                <a href="{{ route('companySettings.index') }}" class="btn"><i class="fas fa-user-shield"></i> Edit
                    Loyalty Card Image</a>
            </div>
        </div>

        <div class="card-body" style="text-align: center;">
            <div class="form-group">
                @if(!empty($companySettings->loyalty_card_image))
                <img src="{{ asset('storage/app/img/loyaltyCard/' . $companySettings->loyalty_card_image) }}">
                @else
                @endif
            </div>
        </div>
    </div>
    <br/>
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Loyalty Stores') }}</h3>
            </div>
            <div class="btn-wrap">
                <a href="javascript:;" class="btn btn-outline-primary" id="add-Store"><i class="fas fa-user-shield"></i> Add Store</a>
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
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                    </div>
                </div>
            </div>
            <br />
            <div class="table-responsive">
                <table id="loyaltyCard" class="table table-striped table-bordered"
                    style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Store Name')}}</th>
                            <th>{{__('Store Location')}}</th>
                            <th>{{__('Store Offers')}}</th>
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
@include('loyaltyCard.form')
<div id="edit_modal_content"></div>

@endsection
@push('js')
<script>
    $('#add-Store').click(function (e) {
        $('#addStore').modal('show');
    });
    $(document).ready(function () {
      $('#create-store').validate({
        rules:{
          'category_id': {
            required: true
          },'store_name': {
            required: true
          },
          'store_address': {
            required: true
          },
          'store_offers': {
            required: true
          },

        },
        messages: {
         loyalty_card_image: {
            required: "Please select Loyalty Card image",
          },
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
        }
        ,
        submitHandler: function (form) {
            addService('{{ route('loyaltyCard.store') }}','create-store','loyaltyCard','addStore');
            return false;
          }
      });
    });
    (function () {
		var dataTable = $('#loyaltyCard').DataTable({
			processing: true,
			// serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route("get.loyaltyCard") }}',
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
			{data: 'store_name', name: 'store_name'},
			{data: 'store_address', name: 'store_address'},
			{data: 'store_offers', name: 'store_offers'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},
			{data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
			],
			order: [[4, "desc"]
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
@endpush
