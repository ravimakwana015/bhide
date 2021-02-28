@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Services') }}</h3>
            </div>
            <div class="btn-wrap">
                <a href="javascript:;" class="btn btn-outline-primary" id="add-service"><i class="fab fa-servicestack"></i> Add Service</a>
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
                <table id="services" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Type of Service')}}</th>
                            <th>{{__('Service Provider')}}</th>
                            <th>{{__('Contact Number')}}</th>
                            {{-- <th>{{__('Mobile Number	')}}</th> --}}
                            <th>{{__('Email')}}</th>
                            <th>{{__('Location')}}</th>
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
@include("services.add_modal")
<div id="edit_modal_content"></div>


@endsection
@push('js')
<script>
    $('#add-service').click(function (e) {
        $('#addService').modal('show');
    });
    $(document).ready(function () {
      $('#create-service').validate({
        rules:{
          category_id: {
          required: true
        },
          service_name: {
            required: true
        },
        service_provider_name: {
            required: true
        },
        contact_number: {
          required: true,
          minlength:11,
          maxlength:11,
          digits: true,
      },
      status: {
        required: true
    },
},
messages: {
    contact_number: {
      required: "Please enter a Mobile number",
      minlength:'Please Enter Valid Mobile No',
      maxlength:'Please Enter Valid Mobile No',
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
},
submitHandler: function (form) {
    addService('{{ route('services.store') }}','create-service','services','addService');
    return false;
}
});
  });
    (function () {
      var dataTable = $('#services').DataTable({
       processing: true,
       // serverSide: true,
       ajax: {
        headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     },
     url: '{{ route("get.services") }}',
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
			{data: null, searchable: true, sortable: false},
			{data: 'service_name', name: 'service_name'},
			{data: 'service_provider_name', name: 'service_provider_name'},
			{data: 'contact_number', name: 'contact_number'},
			// {data: 'mobile_number', name: 'mobile_number'},
			{data: 'email', name: 'email'},
			{data: 'address', name: 'address'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},
            {data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
            ],
            order: [[8, "desc"]],
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
