@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Admin Details</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- /.card -->
      <div class="card card-dark card-tabs">
        @include("admin.include.message")
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-edit"></i>
            Admin Details Update
          </h3>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
              href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
              aria-selected="true">Admin Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-content-below-apartment-tab" data-toggle="pill"
              href="#custom-content-below-apartment" role="tab" aria-controls="custom-content-below-apartment"
              aria-selected="true">Change Password</a>
            </li>
          </ul>
          <div class="tab-content" id="custom-content-below-tabContent" style="margin-top:25px;">
            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel"
            aria-labelledby="custom-content-below-home-tab">
            {!! Form::model($adminDetails, ['route' => ['admin.update'], 'class' => 'form-horizontal', 'role' =>
            'form', 'method' => 'POST', 'files' => true ,'id' => 'edit-settings']) !!}
            <input type="hidden" name="id" value="{{ $adminDetails->id }}" />
            <div class="form-group">
              {{ Form::label('name','Name', ['class' => 'control-label'])}}
              {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name'])}}
            </div>

            <div class="form-group">
              {{ Form::label('email','Email Address', ['class' => 'control-label'])}}
              {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email Address'])}}
            </div>
            {{ Form::submit('Update', ['class' => 'btn btn-dark btn-md']) }}
            {{ Form::close() }}
          </div>
          <div class="tab-pane fade show" id="custom-content-below-apartment" role="tabpanel"
          aria-labelledby="custom-content-below-apartment-tab">
          {!! Form::model($adminDetails, ['route' => ['admin.changepassword'], 'class' => 'form-horizontal', 'role' =>
          'form', 'method' => 'POST', 'files' => true ,'id' => 'changepassword']) !!}
          <input type="hidden" name="id" value="{{ $adminDetails->id }}" />
          <div class="form-group">
            {{ Form::label('new_password','New Password', ['class' => 'control-label'])}}
            {{ Form::text('new_password', null, ['class' => 'form-control', 'placeholder' => 'New Password'])}}
          </div>
          <div class="form-group">
            {{ Form::label('confirm_password','Confirm Password', ['class' => 'control-label'])}}
            {{ Form::text('confirm_password', null, ['class' => 'form-control', 'placeholder' => 'Confirm Password'])}}
          </div>
          {{ Form::submit('Update', ['class' => 'btn btn-dark btn-md']) }}
          {{ Form::close() }}
        </div>
        
      </div>
      <!-- /.card -->
    </div>
    <div class="card-footer">
      {{-- {{ Form::submit('Update', ['class' => 'btn btn-dark btn-md']) }} --}}
    </div>
    {{-- {{ Form::close() }} --}}
  </div>
</section>
</div>
@endsection
@section('after-scripts')
<script>
  tinymce.init({
    selector:'textarea[id="address"]',
		// width: 900,
		height: 300
	});
</script>

<script type="text/javascript">
  $(document).ready(function () {
    $('#changepassword').validate({
      rules:{
        new_password: {
          required: true
        },
        confirm_password: {
          required: true,
          equalTo: "#new_password",
        },
      },
      messages: {
        new_password: {
          required: 'Please Enter Your Password'
        },
        confirm_password: {
          required: 'Please Confirm Your Password'
        },
      },
      submitHandler: function (form) {
        form.submit();

      }
    });
  });
</script>

@endsection
