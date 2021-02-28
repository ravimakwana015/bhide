@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<a class="btn btn-info" href="{{ route('admin.home') }}"><i class="fas fa-chevron-circle-left"></i> Back</a>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			@include("admin.include.message")
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<div class="row mb-2">
								<div class="col-sm-6">
									<h3 class="card-title">Facilities Options</h3>
								</div>
								<div class="col-sm-6">
									<a href="javascript:;" class="btn btn-primary float-right elevation-4" id="addButton"><i class="fas fa-plus"></i> Add Options</a>
								</div>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="company-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Title</th>
										<th>Created Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</section>


	<div class="modal fade bd-example-modal-lg" id="addService" tabindex="-1" role="dialog"
	aria-labelledby="addServiceTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLongTitle">Add Options</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			{{ Form::open(['route' => 'facilitiesoptions.store','role' => 'form', 'method' => 'post', 'id' => 'create-service']) }}
			<div class="modal-body">
				<div class="msg"></div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('title') ? ' is-invalid' : '' }}">
							{{ Form::label('title','Title', ['class' => 'control-label required']) }}
							{{ Form::text('title', null, ['class' => 'form-control '.($errors->has('title') ? 'is-invalid':''), 'placeholder' => 'Title']) }}
							@if ($errors->has('title'))
							<span class="invalid-feedback">{{ $errors->first('title') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
							{{ Form::label('status', 'Status', ['class' =>'control-label required']) }}
							<br />
							<input type="radio" name="status" value="1" checked=""/>
							Active
							<input type="radio" name="status" value="0" />
							Inactive
							<br />
							@if ($errors->has('status'))
							<span class="invalid-feedback">{{ $errors->first('status') }}</span>
							@endif
							<div class="error_msg"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-secondary">Submit</button>
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
aria-labelledby="addServiceTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="deleteModalLongTitle">Edit Options</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form  method="post" role="form" id="editForm" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="register-form-errors"></div>
				{{csrf_field()}}
				<div id="edi_data_wrap"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Update changes</button>
			</div>
		</form>
	</div>
</div>
</div>

<div class="modal fade bd-example-modal-lg" id="deletemodel" tabindex="-1" role="dialog"
aria-labelledby="addServiceTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="deleteModalLongTitle">Are you Sure You want Delete This Option ??</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form action="{{ route('admin.facilitiesoptions.delete') }}" method="post" role="form" id="deleteForm" enctype="multipart/form-data">
			{{csrf_field()}}
			<input type="hidden" name="id" id="delete_id">
			<div class="modal-footer" style="text-align: center;">
				<button type="button" class="btn btn-info" data-dismiss="modal">No</button>
				<button type="submit" class="btn btn-primary">Yes</button>
			</div>
		</form>
	</div>
</div>
</div>


<!-- /.content -->
</div>
@endsection
@section('after-scripts')

<script>
	tinymce.init({
		selector:'textarea[id="content"]',
		height: 300
	});
</script>
<script>
	tinymce.init({
		selector:'textarea[id="editcontent"]',
		height: 300
	});
</script>

<script>

	function getDelete(id)
	{
		$('#deletemodel').modal('show');
		$('#delete_id').val(id);
	}

	$('#addButton').click(function (e) {
		$('#addService').modal('show');
	});
	$(document).ready(function () {
		$('#create-service').validate({
			rules:{
				title: {
					required: true
				},
				status: {
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
				addService('{{ route('facilitiesoptions.store') }}','create-service','services','addService');

				setTimeout(function(){ 
					window.location.reload();
					$("#editModal").modal('hide');
				}, 5000);
			}
		});
	});
	(function() {
		var dataTable = $('#company-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{!! route('facilitiesoptions.get') !!}',
				type: 'post'
			},
			columns: [
			{data: null, searchable: false, sortable: false},
			{data: 'title', name: 'title'},
			{data: 'created_at', name: 'created_at'},
			{data: 'status', name: 'status'},
			{data: 'actions', name: 'actions', searchable: false, sortable: false}
			],
			order: [[2, "desc"]],
			"fnRowCallback": function (nRow, aData, iDisplayIndex) {
				$("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
				return nRow;
			}
		});
	})();
</script>

<script type="text/javascript">

	function getData(id)
	{
		var getUrl = window.location;
		var routeUrl = getUrl + '/edit' + "/" + id;

		$('#edi_data_wrap').html('');
		$('#loading').show();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: routeUrl,
			type: "get",
			dataType: 'json',
			success: function (data) {
				$('#loading').hide();
				$('#edi_data_wrap').html(data.data);
				$('#editModal').modal('show');
			},
			error: function (data) {
			},
		});
	}


	$('#editForm').validate({ 
		rules:{
			title: {
				required: true
			},
			status: {
				required: true
			},
		},
		messages: {

		},
		submitHandler: function(form) {
			$('#loading').show();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{route('admin.facilitiesoptions.update')}}",
				type: "POST",
				data: $("#editForm").serialize(),
				dataType: 'json',
				success: function (data) {
					$('#loading').hide();
					if(data.status==1){
						$( '.register-form-errors' ).html('<div class="alert alert-success">Option Update Successfully</div>');
						setTimeout(function(){ 
							$("#editModal").modal('hide');
							window.location.reload();
						}, 3000);

					}
				},
				error: function (data) {
					$('#loading').hide();
					var errorString = '<ul>';
					$.each(data.responseJSON.errors, function( key, value) {
						errorString += '<li>' + value + '</li>';
					});
					errorString += '</ul>';
					$('.register-form-errors').html('');
					$( '.register-form-errors' ).html('<div class="alert alert-danger">'+errorString+'</div>');
				},
			});
			return false;
		}
	});

</script>

@endsection
