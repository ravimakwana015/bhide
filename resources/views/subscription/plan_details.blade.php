@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content mt-3">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">Company Details</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->

          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('company_name') ? ' is-invalid' : '' }}">
                  {{ Form::label('company_name','Company Name:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->company_name }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('person_name') ? ' is-invalid' : '' }}">
                  {{ Form::label('person_name','Contact Person Name:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->person_name }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
                  {{ Form::label('email','Company Email:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->email }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('mobile') ? ' is-invalid' : '' }}">
                  {{ Form::label('mobile','Mobile Number:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->mobile }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('landline') ? ' is-invalid' : '' }}">
                  {{ Form::label('landline','Landline Number:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->landline }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('apartment_count') ? ' is-invalid' : '' }}">
                  {{ Form::label('apartment_count','Apartment Count:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->apartment_count }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('subscription_amount') ? ' is-invalid' : '' }}">
                  {{ Form::label('subscription_amount','Subscription Amount:', ['class' => 'control-label required']) }}
                  <br/>
                  £{{ number_format($company->subscription_amount, 2,'.', '') }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('subscription_time') ? ' is-invalid' : '' }}">
                  {{ Form::label('subscription_time','Subscription time:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->subscription_time }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('building_address') ? ' is-invalid' : '' }}">
                  {{ Form::label('building_address','Building Address:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->building_address }}
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group {{ $errors->has('company_address') ? ' is-invalid' : '' }}">
                  {{ Form::label('company_address','Company Address:', ['class' => 'control-label required']) }}
                  <br/>
                  {{ $company->company_address }}
                </div>
              </div>
            </div>

          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <a href="{{ route('payment',$id) }}" class="btn btn-primary">Confirm and Pay now</a>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

</div>
@endsection
