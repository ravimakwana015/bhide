@extends('admin.layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <a class="btn btn-info" href="{{ route('companies.index') }}"><i class="fas fa-chevron-circle-left"></i>
            Back</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ Str::ucfirst($company->company_name)  }}'s Detail</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">
            <div class="row">
              <div class="col-12 col-sm-4">
                <div class="info-box bg-info">
                  <div class="info-box-content">
                    <span class="info-box-text text-center ">
                      Total Apartments
                    </span>
                    <span class="info-box-number text-center mb-0">{{ $company->apartment_count }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-success">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">
                      Per Apartment Price
                    </span>
                    <span class="info-box-number text-center mb-0">{{ $settings->currency_symbol }}{{  number_format($company->per_apartment_amount,2) }}</span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">
                <div class="info-box bg-dark">
                  <div class="info-box-content">
                    <span class="info-box-text text-center">Subscription Amount</span>
                    <span
                      class="info-box-number text-center mb-0">{{ $settings->currency_symbol }}{{  number_format($company->subscription_amount,2) }}
                      / ({{ $company->subscription_time }})</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @if (count($subscription))
          <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2">
            <h5 class="text-muted">Subscription Details</h5>
            <div class="text-muted">
              <p class="text-sm">Current Period Start
                <b class="d-block">{{ date('dS M Y H:i A',$subscription->current_period_start) }}</b>
              </p>
              <p class="text-sm">Current Period Ends
                <b class="d-block">{{ date('dS M Y H:i A',$subscription->current_period_end) }}</b>
              </p>
            </div>
          </div>
          @endif
          <div class="col-12 col-md-12 col-lg-3 order-1 order-md-2">
            <h5 class="text-muted">Client Invoices</h5>
            <ul class="list-unstyled">
              @foreach ($invoices as $invoice)
              <li>
                <a href="{{  route('download.invoice',[
                                    $user->id,$invoice->id ]) }}">
                  <i class="far fa-fw fa-file-pdf"></i>
                  {{ $invoice->number }}
                </a>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
              <p class="text-sm">Company
                <b class="d-block">{{ Str::ucfirst($company->company_name) }}</b>
              </p>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
              <p class="text-sm">Name
                <b class="d-block">{{ Str::ucfirst($company->person_name) }}</b>
              </p>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
              <p class="text-sm">Email
                <b class="d-block">
                  <a href="mailto:{{ $company->email }}" class="text-muted">{{ $company->email }}</a>
                </b>
              </p>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
              <p class="text-sm">Mobile
                <b class="d-block ">
                  <a href="tel:{{ $company->mobile }}" class="text-muted">{{ $company->mobile }}</a>
                </b>
              </p>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
              <p class="text-sm">Landline
                <b class="d-block">
                  <a href="tel:{{ $company->landline }}" class="text-muted">{{ $company->landline }}</a>
                </b>
              </p>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
              <p class="text-sm">Building Address
                <b class="d-block">
                  {{ $company->building_address }}
                </b>
              </p>
            </div>
          </div>
          <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
              <p class="text-sm">Company Address
                <b class="d-block">
                  {{ $company->company_address }}
                </b>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
