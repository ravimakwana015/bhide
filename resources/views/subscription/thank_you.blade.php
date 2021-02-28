@extends('layouts.app')

@section('content')
<!-- Main content -->
<section class="content mt-3">
  <div class="container-fluid">
  	<div class="thankyou-content">
      <img src="https://demo.joykal.com/laravel/aptly/public/front/images/Thank-You.png">
      <p>Your Subscription has been completed. We look forward to having you on our platform!</p>
    </div>
    {{-- <div class="row">
      <div class="col-md-12">
        <div class="card card-dark">
          <div class="card-body">
            @if ($message = Session::get('success'))
            <div class="thankyou">
              <div class="textthanks">{{ $message }}</div>
            </div>
            @endif
            @if ($message = Session::get('warning'))
            <div class="thankyou">
              <div class="textthanks">{{ $message }}</div>
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="thankyou">
              <div class="textthanks">{{ $message }}</div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div> --}}
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

</div>
@endsection
