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
									<h3 class="card-title">Features</h3>
								</div>
								<div class="col-sm-6">
									<a href="{{ route('features.create') }}" class="btn btn-primary float-right elevation-4" id=""><i class="fas fa-plus"></i> Add Feature</a>
								</div>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="company-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Feature Image</th>
										<th>Title</th>
										{{-- <th>Description</th> --}}
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
				<h5 class="modal-title" id="deleteModalLongTitle">Add Feature</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('features.store') }}" method="post" id="create-service" enctype="multipart/form-data"> 
				{{csrf_field()}}
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
						<div class="col-md-12">
							<div class="form-group {{ $errors->has('status') ? ' is-invalid' : '' }}">
								{{ Form::label('status', 'Feature Image', ['class' =>'control-label required']) }}

								<input name="feature_image" value="{{ old('feature_image') }}" type="file" placeholder="Feature Image">
								@if ($errors->has('status'))
								<span class="invalid-feedback">{{ $errors->first('status') }}</span>
								@endif
								<div class="error_msg"></div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group {{ $errors->has('content') ? ' is-invalid' : '' }}">
								{{ Form::label('content','Content', ['class' => 'control-label required']) }}
								{{ Form::textarea('content', null, ['class' => 'form-control'.($errors->has('content') ? 'is-invalid':''), 'placeholder' => 'Content','rows'=>'1']) }}
								@if ($errors->has('content'))
								<span class="invalid-feedback">{{ $errors->first('content') }}</span>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-secondary">Submit</button>
					<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
aria-labelledby="addServiceTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="deleteModalLongTitle">Edit Features</h5>
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
			<h5 class="modal-title" id="deleteModalLongTitle">Are you Sure You want Delete This Features ??</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form action="{{ route('admin.features.delete') }}" method="post" role="form" id="editForm" enctype="multipart/form-data">
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
		selector:'textarea',
		height: 300
	});tinymce.init({
		selector:'textarea[id="contentsedit"]',
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
				feature_image: {
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
			submitHandler: function(form) {
				$('#loading').show();
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "{{route('admin.features.store')}}",
					type: "POST",
					data: new FormData(form),
					dataType: 'json',
					contentType: false,
					cache: false,
					processData:false,
					success: function (data) {
						$('#loading').hide();
						if(data.status==1){
							$( '.msg' ).html('<div class="alert alert-success">Feature Add Successfully</div>');
							setTimeout(function(){ 
								$("#addService").modal('hide');
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
	});
	(function() {
		var dataTable = $('#company-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '{!! route('features.get') !!}',
				type: 'post'
			},
			columns: [
			{data: null, searchable: false, sortable: false},
			{data: 'features_image', name: 'features_image'},
			{data: 'title', name: 'title'},
			// {data: 'content_edit', name: 'content_edit'},
			{data: 'actions', name: 'actions', searchable: false, sortable: false}
			],
			// order: [[2, "desc"]],
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
		},
		messages: {

		},
		submitHandler: function(form) {
			$('#loading').show();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{route('admin.features.update')}}",
				type: "POST",
				data: new FormData(form),
				dataType: 'json',
				contentType: false,
				cache: false,
				processData:false,
				success: function (data) {
					$('#loading').hide();
					if(data.status==1){
						$( '.register-form-errors' ).html('<div class="alert alert-success">Feature Update Successfully</div>');
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
