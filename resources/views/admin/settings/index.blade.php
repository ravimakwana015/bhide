@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Settings</h1>
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
            Settings Update
          </h3>
        </div>
        {!! Form::model($settings, ['route' => ['settings.update'], 'class' => 'form-horizontal', 'role' =>
        'form', 'method' => 'POST', 'files' => true ,'id' => 'edit-settings']) !!}
        <input type="hidden" name="id" value="{{ $settings->id }}" />
        <div class="card-body">
          <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill"
                href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home"
                aria-selected="true">Site Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-content-below-apartment-tab" data-toggle="pill"
                href="#custom-content-below-apartment" role="tab" aria-controls="custom-content-below-apartment"
                aria-selected="true">Apartment Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-content-below-apartment-tab" data-toggle="pill"
                href="#custom-content-below-firebase" role="tab" aria-controls="custom-content-below-apartment"
                aria-selected="true">Firebase Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-content-below-apartment-tab" data-toggle="pill"
                href="#custom-content-below-dashboard" role="tab" aria-controls="custom-content-below-dashboard"
                aria-selected="true">Dashboard Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-content-below-apartment-tab" data-toggle="pill"
                href="#custom-content-below-about-apartment" role="tab" aria-controls="custom-content-below-about-apartment"
                aria-selected="true">About Apartment Settings</a>
            </li>
          </ul>
          <div class="tab-content" id="custom-content-below-tabContent" style="margin-top:25px;">
            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel"
              aria-labelledby="custom-content-below-home-tab">
              <div class="form-group">
                {{ Form::label('contact_no','Contact Number', ['class' => 'control-label'])}}
                {{ Form::text('contact_no', null, ['class' => 'form-control', 'placeholder' => 'Contact Number'])}}
              </div>

              <div class="form-group">
                {{ Form::label('email','Email Address', ['class' => 'control-label'])}}
                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email Address'])}}
              </div>
              <div class="form-group">
                {{ Form::label('logo','Site Log', ['class' => 'control-label']) }}
                {{-- <div class="custom-file-input"> --}}
                <br />
                {!! Form::file('logo', array('class'=>'inputfile inputfile-1' )) !!}
                {{-- </div> --}}

                <div class="img-remove-logo">
                  @if(isset($settings->logo))
                  <img src="{{ url('storage/app/img/logo/'.$settings->logo) }}">
                  @endif
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('address','Address', ['class' => 'control-label'])}}
                {{ Form::textarea('address', null,['class' => 'form-control', 'placeholder' =>'Address', 'rows' => 2]) }}
              </div>
            </div>
            <div class="tab-pane fade show" id="custom-content-below-apartment" role="tabpanel"
              aria-labelledby="custom-content-below-apartment-tab">
              <div class="form-group">
                {{ Form::label('default_apartment_price','Default Apartment Price', ['class' => 'control-label'])}}
                {{ Form::number('default_apartment_price', null, ['class' => 'form-control', 'placeholder' => 'Default Apartment Price'])}}
              </div>
              <div class="form-group">
                {{ Form::label('currency_symbol','Currency Symbol', ['class' => 'control-label'])}}
                {{ Form::text('currency_symbol', null, ['class' => 'form-control', 'placeholder' => 'Currency Symbol'])}}
              </div>
            </div>
            <div class="tab-pane fade show" id="custom-content-below-firebase" role="tabpanel"
              aria-labelledby="custom-content-below-apartment-tab">
              <div class="form-group">
                {{ Form::label('firebase_server_key','Server Key', ['class' => 'control-label'])}}
                {{ Form::textarea('firebase_server_key', null, ['class' => 'form-control', 'placeholder' => 'Server Key','rows'=>'2'])}}
              </div>
            </div>
            <div class="tab-pane fade show" id="custom-content-below-dashboard" role="tabpanel"
              aria-labelledby="custom-content-below-apartment-tab">
              <div class="form-group">
                <input type="radio" name="dashboard_view" value="1" @if($settings->dashboard_view == 1) checked @endif/>
                {{ Form::label('firebase_server_key','Dashboard 1', ['class' => 'control-label'])}}

                <input type="radio" name="dashboard_view" value="2" @if($settings->dashboard_view == 2) checked @endif/>
                {{ Form::label('firebase_server_key','Dashboard 2', ['class' => 'control-label'])}}
                
              </div>
            </div>
            <div class="tab-pane fade show active" id="custom-content-below-about-apartment" role="tabpanel"
              aria-labelledby="custom-content-below-home-tab">
              
              <div class="form-group">
                {{ Form::label('parking_Information','Parking Information', ['class' => 'control-label'])}}
                {{ Form::textarea('parking_Information', null,['class' => 'form-control', 'placeholder' =>'Parking Information', 'rows' => 2]) }}
              </div>

              <div class="form-group">
                {{ Form::label('concierge','Concierge', ['class' => 'control-label'])}}
                {{ Form::textarea('concierge', null,['class' => 'form-control', 'placeholder' =>'Concierge', 'rows' => 2]) }}
              </div>
              <div class="form-group">
                {{ Form::label('fitness_centre','Fitness Centre', ['class' => 'control-label'])}}
                {{ Form::textarea('fitness_centre', null,['class' => 'form-control', 'placeholder' =>'Fitness Centre', 'rows' => 2]) }}
              </div>

            </div>
          </div>
          <!-- /.card -->
        </div>
        <div class="card-footer">
          {{ Form::submit('Update', ['class' => 'btn btn-dark btn-md']) }}
        </div>
        {{ Form::close() }}
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
@endsection
