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
									<h3 class="card-title">All Users</h3>
								</div>
								<div class="col-sm-6">
									<a href="javascript:;" class="btn btn-primary float-right elevation-4" id="addButton"><i class="fas fa-plus"></i> Add User</a>
								</div>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="box-header">
								<h3>Filter</h3>
								<div class="row">
									<div class="col-md-4">
										<label>Select Company Name</label>
										{!! Form::select('company_name', array_unique($companys), null, ["class" => "select2 form-control search-input-select"]) !!}
									</div>
								</div>
							</div>
							<hr/>
							<br/>
							<table id="company-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>{{__('Name')}}</th>
										<th>{{__('Company Name')}}</th>
										<th>{{__('Member Type')}}</th>
										<th>{{__('Apartment Unit')}}</th>
										<th>{{__('Email')}}</th>
										<th>{{__('Phone Number')}}</th>
										<th>{{__('Created Date')}}</th>
										<th>{{__('Action')}}</th>									
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
				<h5 class="modal-title" id="deleteModalLongTitle">Add User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			{{ Form::open(['route' => 'alluser.store','role' => 'form', 'method' => 'post', 'id' => 'create-service']) }}
			<div class="modal-body">
				<div class="msg"></div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
							{{ Form::label('company_id','Company Name', ['class' => 'control-label required']) }}
							{{ Form::select('company_id', $companys,'companyid', ['class' => 'form-control select2']) }}
							@if ($errors->has('company_id'))
							<span class="invalid-feedback">{{ $errors->first('company_id') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('unit_id') ? ' is-invalid' : '' }}">
							{{ Form::label('unit_id','Apartment Units', ['class' => 'control-label required']) }}
							<br/>
							<select class="form-control select2" name="unit_id" id="unitid">
								<option value="">Select Unit</option>
							</select>
							{{-- {{ Form::select('unit_id', null,null, ['class' => 'select2']) }} --}}
							@if ($errors->has('unit_id'))
							<span class="invalid-feedback">{{ $errors->first('unit_id') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('member_type') ? ' is-invalid' : '' }}">
							{{ Form::label('member_type', 'Member Type', ['class' =>'control-label required']) }}
							{{ Form::select('member_type', [""=>"Select Member Type","owner"=>"Owner","tenant"=>"Tenant","owner_family"=>"Owner Family","tenant_family"=>"Tenant Family"],null, ['class' => 'form-control','id'=>'member_type']) }}
							@if ($errors->has('member_type'))
							<span class="invalid-feedback">{{ $errors->first('member_type') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('gender') ? ' is-invalid' : '' }}">
							{{ Form::label('gender', 'Gender', ['class' =>'control-label required']) }}
							<br />
							<input type="radio" name="gender" value="male" @if(isset($user) && $user->gender=='male') checked @endif/>
							Male
							<input type="radio" name="gender" value="female" @if(isset($user) && $user->gender=='female') checked
							@endif/>
							Female
							<input type="radio" name="gender" value="prefer" @if(isset($user) && $user->gender=='prefer') checked
							@endif/>
							Prefer not to say
							<br />
							@if ($errors->has('gender'))
							<span class="invalid-feedback">{{ $errors->first('gender') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('first_name') ? ' is-invalid' : '' }}">
							{{ Form::label('first_name','First Name', ['class' => 'control-label required']) }}
							{{ Form::text('first_name', null, ['class' => 'form-control '.($errors->has('first_name') ? 'is-invalid':''), 'placeholder' => 'First Name']) }}
							@if ($errors->has('first_name'))
							<span class="invalid-feedback">{{ $errors->first('first_name') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('middle_name') ? ' is-invalid' : '' }}">
							{{ Form::label('middle_name','Middle Name', ['class' => 'control-label required']) }}
							{{ Form::text('middle_name', null, ['class' => 'form-control '.($errors->has('middle_name') ? 'is-invalid':''), 'placeholder' => 'Middle Name']) }}
							@if ($errors->has('middle_name'))
							<span class="invalid-feedback">{{ $errors->first('middle_name') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('last_name') ? ' is-invalid' : '' }}">
							{{ Form::label('last_name','Last Name', ['class' => 'control-label required']) }}
							{{ Form::text('last_name', null, ['class' => 'form-control '.($errors->has('last_name') ? 'is-invalid':''), 'placeholder' => 'Last Name']) }}
							@if ($errors->has('last_name'))
							<span class="invalid-feedback">{{ $errors->first('last_name') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('date_of_birth') ? ' is-invalid' : '' }}">
							{{ Form::label('date_of_birth','Date of birth', ['class' => 'control-label required']) }}
							<br />
							{{ Form::text('date_of_birth', null, ['class' => 'form-control datetimepicker '.($errors->has('date_of_birth') ? 'is-invalid':''), 'placeholder' => 'Date of birth','readonly']) }}
							@if ($errors->has('date_of_birth'))
							<span class="invalid-feedback">{{ $errors->first('date_of_birth') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('phone_number') ? ' is-invalid' : '' }}">
							{{ Form::label('phone_number','Mobile Number', ['class' => 'control-label required']) }}
							{{ Form::text('phone_number', null, ['class' => 'form-control '.($errors->has('phone_number') ? 'is-invalid':''), 'placeholder' => 'Mobile Number']) }}
							@if ($errors->has('phone_number'))
							<span class="invalid-feedback">{{ $errors->first('phone_number') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							{{ Form::label('member_image', 'Profile Image', ['class' => 'control-label required']) }}
							<br />
							<input type="hidden" name="member_images" id="profile-img-tag-textarea">
							@if(isset($user->member_image))
							<input type="file" name="member_image" id="member_image-1" class="inputfile inputfile-1"
							value="{{ $user->member_image }}" />
							<br />
							<br />
							<img src="{{ asset('public/front/member_image/' . $user->member_image) }}" width="80" height="80"
							id="career_img">
							@else
							<input type="file" accept="image/*" name="member_image" id="member_image-1" class="inputfile inputfile-1" />
							<br />
							@endif
							@if ($errors->has('member_image'))
							<span class="invalid-feedback">{{ $errors->first('member_image') }}</span>
							@endif
							@include('apartment.image-crop-wrap')
						</div>
						<span class="text-danger" id="image-dimension"></span>
					</div>
				</div>
				<hr />
				<h5>Correspondence Address</h5>
				<hr />
				<div class="row">
					<div class="col-md-4">
						<div class="form-group {{ $errors->has('address') ? ' is-invalid' : '' }}">
							{{ Form::label('address','Address', ['class' => 'control-label required']) }}
							{{ Form::text('address', null, ['class' => 'form-control '.($errors->has('address') ? 'is-invalid':''), 'placeholder' => 'Address']) }}
							@if ($errors->has('address'))
							<span class="invalid-feedback">{{ $errors->first('address') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group {{ $errors->has('city') ? ' is-invalid' : '' }}">
							{{ Form::label('city','City', ['class' => 'control-label required']) }}
							{{ Form::text('city', null, ['class' => 'form-control '.($errors->has('city') ? 'is-invalid':''), 'placeholder' => 'City']) }}
							@if ($errors->has('city'))
							<span class="invalid-feedback">{{ $errors->first('city') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group {{ $errors->has('country') ? ' is-invalid' : '' }}">
							{{ Form::label('country','Country', ['class' => 'control-label required']) }}
							{{ Form::text('country', null, ['class' => 'form-control '.($errors->has('country') ? 'is-invalid':''), 'placeholder' => 'Country']) }}
							@if ($errors->has('country'))
							<span class="invalid-feedback">{{ $errors->first('country') }}</span>
							@endif
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group {{ $errors->has('zip_code') ? ' is-invalid' : '' }}">
							{{ Form::label('zip_code','Postal Code', ['class' => 'control-label required']) }}
							{{ Form::text('zip_code', null, ['class' => 'form-control '.($errors->has('zip_code') ? 'is-invalid':''), 'placeholder' => 'Postal Code']) }}
							@if ($errors->has('zip_code'))
							<span class="invalid-feedback">{{ $errors->first('zip_code') }}</span>
							@endif
						</div>
					</div>
				</div>
				<hr />
				<h5>Member App login details</h5>
				<hr />
				<div class="row">
					<div class="col-md-3">
						<div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
							{{ Form::label('email','Email/Username', ['class' => 'control-label required']) }}
							<br />
							@if(isset($user))
							{{ $user->email }}
							@else
							{{ Form::text('email', null, ['class' => 'form-control '.($errors->has('email') ? 'is-invalid':''), 'placeholder' => 'Email/Username']) }}
							@if ($errors->has('email'))
							<span class="invalid-feedback">{{ $errors->first('email') }}</span>
							@endif
							@endif
						</div>
					</div>


					@if(!isset($user))
					<div class="col-md-3">
						<div class="form-group {{ $errors->has('password') ? ' is-invalid' : '' }}">
							{{ Form::label('password','Password', ['class' => 'control-label required']) }}
							<input type="password" name="password" class="form-control" placeholder="Password">
							
							@if ($errors->has('password'))
							<span class="invalid-feedback">{{ $errors->first('password') }}</span>
							@endif
						</div>
					</div>
					@endif
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
			<h5 class="modal-title" id="deleteModalLongTitle">Edit Pages</h5>
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
			<h5 class="modal-title" id="deleteModalLongTitle">Are you Sure You want Delete This User ??</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<form action="{{ route('admin.alluser.delete') }}" method="post" role="form" id="deleteForm" enctype="multipart/form-data">
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

	$('#company_id').change(function(){
		var id = $(this).val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			url: '{!! route('get.units') !!}',
			type: 'post',
			data: {id: id},
			dataType: 'json',
			success: function (data) {
				$('#unitid').empty();
				jQuery.each(data, function(key,value){
					$('#unitid').append('<option value="'+ key +'">'+ value +'</option>');
				});
			},
			error: function (data) {
			},
		});
	});

	$('#addButton').click(function (e) {
		$('#addService').modal('show');
	});
	$(document).ready(function () {
		var dt = new Date();
		dt.setFullYear(new Date().getFullYear()-10);
		$('.datetimepicker').datepicker({
			format: 'DD/MM/YYYY',
			'autoHide':true,
			endDate : dt
		});
		$('#create-service').validate({
			rules:{
				member_type: {
					required: true
				},
				unit_id: {
					required: true
				},
				first_name: {
					required: true
				},
				last_name: {
					required: true
				},
				gender: {
					required: true
				},
				date_of_birth: {
					required: true
				},
				address: {
					required: true
				},
				city: {
					required: true
				},
				country: {
					required: true
				},
				zip_code: {
					required: true
				},
				email: {
					required: true,
					email: true,
				},
				password: {
					required: true,
				},
				phone_number: {
					required: true,
					minlength:11,
					maxlength:11,
					digits: true,
				},
			},
			messages: {
				first_name: {
					required: "Please enter a first name",
				},
				last_name: {
					required: "Please enter a Last name",
				},
				gender: {
					required: "Please Select gender",
				},
				date_of_birth: {
					required: "Please Select Date of birth",
				},
				address: {
					required: "Please Enter Address",
				},
				city: {
					required: "Please Enter city",
				},
				state: {
					required: "Please Enter state",
				},
				country: {
					required: "Please Enter country",
				},
				zip_code: {
					required: "Please Enter Postal code",
				},
				email: {
					required: "Please enter a member email address",
					email: "Please enter a valid member email address"
				},
				password: {
					required: "Please enter a member password",
				},
				phone_number: {
					required: "Please enter a Mobile number",
					minlength:'Please Enter Valid Mobile No',
					maxlength:'Please Enter Valid Mobile No',
				},
				unit_id: {
					required: "Please Select member Unit",
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
				addService('{{ route('alluser.store') }}','create-service','services','addService');

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
				url: '{!! route('allusers.get') !!}',
				type: 'post',
				data: function(d) {
					d.company_name = $('select[name=company_name]').val();
				}
			},
			columns: [
			{data: null, searchable: false, sortable: false},
			// {data: 'company_name', name: 'company_name', searchable: false, sortable: false},
			{data: 'name', name: 'name'},
			{data: 'company_name', name: 'company_name'},
			{data: 'member_type', name: 'member_type'},
			{data: 'unit_name', name: 'unit_name',searchable: false, sortable: false},
			{data: 'email', name: 'email'},
			{data: 'phone_number', name: 'phone_number'},
			{data: 'created_at', name: 'created_at'},
			{data: 'actions', name: 'actions', searchable: false, sortable: false, "width": "20%"}
			],
			order: [[5, "desc"]],
			"fnRowCallback": function (nRow, aData, iDisplayIndex) {
				$("td:nth-child(1)", nRow).html(iDisplayIndex + 1);
				return nRow;
			}
		});
		$('select[name=company_name]').on('change', function() {
			dataTable.draw();
		});
		Backend.DataTableSearch.init(dataTable);
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
			member_type: {
				required: true
			},
			unit_id: {
				required: true
			},
			first_name: {
				required: true
			},
			last_name: {
				required: true
			},
			gender: {
				required: true
			},
			date_of_birth: {
				required: true
			},
			address: {
				required: true
			},
			city: {
				required: true
			},
			country: {
				required: true
			},
			zip_code: {
				required: true
			},
			email: {
				required: true,
				email: true,
			},
			password: {
				required: true,
			},
			phone_number: {
				required: true,
				minlength:11,
				maxlength:11,
				digits: true,
			},
		},
		messages: {
			first_name: {
				required: "Please enter a first name",
			},
			last_name: {
				required: "Please enter a Last name",
			},
			gender: {
				required: "Please Select gender",
			},
			date_of_birth: {
				required: "Please Select Date of birth",
			},
			address: {
				required: "Please Enter Address",
			},
			city: {
				required: "Please Enter city",
			},
			state: {
				required: "Please Enter state",
			},
			country: {
				required: "Please Enter country",
			},
			zip_code: {
				required: "Please Enter Postal code",
			},
			email: {
				required: "Please enter a member email address",
				email: "Please enter a valid member email address"
			},
			password: {
				required: "Please enter a member password",
			},
			phone_number: {
				required: "Please enter a Mobile number",
				minlength:'Please Enter Valid Mobile No',
				maxlength:'Please Enter Valid Mobile No',
			},
			unit_id: {
				required: "Please Select member Unit",
			},
		},
		submitHandler: function(form) {
			$('#loading').show();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{route('admin.alluser.update')}}",
				type: "POST",
				data: $("#editForm").serialize(),
				dataType: 'json',
				success: function (data) {
					$('#loading').hide();
					if(data.status==1){
						$( '.register-form-errors' ).html('<div class="alert alert-success">User updated successfully</div>');
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

<script>
	var resize = $('#upload-demo').croppie({
		enableExif: true,
		viewport: { 
			width: 300,
			height: 300,
			type: 'square'
		},
		boundary: {
			width: 300,
			height: 300
		}
	});

	$('#member_image-1').on('change', function () {
		$('#myModal').show('model');
		var reader = new FileReader();
		reader.onload = function (e) {
			resize.croppie('bind',{
				points: [77,469,280,739],
				url: e.target.result
			}).then(function(){
				resize.croppie('setZoom', 0.2);
				$('.profile-image-preview').addClass('active');
				$('body').addClass('profile-popup');
			});
		}
		reader.readAsDataURL(this.files[0]);
	});

	$('#close_image_crop').click(function(event) {
		$('.profile-image-preview').removeClass('active');
		$('body').removeClass('profile-popup');
		$('#member_image-1').val('');
		$('#myModal').hide('model');
	});

	$('.upload-image').on('click', function (ev) {
		resize.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (img) {
			$('#loading').show();
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "{{ route('upload-alluser-pic') }}",
				type: "POST",
				data: {"image":img},
				success: function (data) {
					$('#myModal').hide('model');
					$('#loading').hide(); 
					var path ='{{ asset('public/front/member_image/') }}';
					$('#profile-img-tag').attr('src', path+'/'+data);
					$('#profile-img-tag-textarea').val(data);

					$('#yellowbutton').trigger('click');
					setTimeout(function() { 
						$('#loadings').hide(); 
					}, 4000);
				}
			});
		});
	});
</script>

@endsection
