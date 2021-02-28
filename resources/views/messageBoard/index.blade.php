@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Message Board') }}</h3>
            </div>
            {{-- <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('messageBoard.create') }}" class="btn btn-outline-primary"><i class="fas fa-envelope-open-text"></i> Add Notice</a>
            </div> --}}
            <div class="btn-wrap">
                <a href="javascript:;" class="btn btn-outline-primary" id="add-notice"><i class="fas fa-envelope-open-text"></i> Add Message</a>
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
                <table id="messageBoard" class="table table-striped table-bordered" style="width:100%;text-align: center;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Subject')}}</th>
                            <th>{{__('Description')}}</th>
                            <th>{{__('Date Created')}}</th>
                            <th>{{__('Valid Untill Date')}}</th>
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
@include("messageBoard.add_modal")
<div id="edit_modal_content"></div>
@endsection
@push('js')
<script>
    $('#add-notice').click(function (e) {
        $('#addNotice').modal('show');
    });
    $(document).ready(function () {
        $('.datetimepicker').datepicker({
            format: 'DD/MM/YYYY',
            'autoHide':true,
            'startDate' : new Date()
        });
      $('#create-messageBoard').validate({
        rules:{
          title: {
            required: true
          },
          description: {
            required: true
          },
          status: {
            required: true
          },
          notice_valid_until: {
            required: true
          },

        },
        messages: {
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
            addService('{{ route('messageBoard.store') }}','create-messageBoard','messageBoard','addNotice');
            return false;
          }
      });
    });
    (function () {
		var dataTable = $('#messageBoard').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{{ route("get.messageBoard") }}',
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
			{data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'created_at', name: 'created_at'},
			{data: 'notice_valid_until', name: 'notice_valid_until', "width": "15%"},
			{data: 'status', name: 'status'},
			{data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "10%"}
			],
			order: [[6, "desc"]
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
