@extends('admin.layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <a class="btn btn-info" href="{{ route('poll.index') }}"><i class="fas fa-chevron-circle-left"></i>
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
        <h3 class="card-title">Poll's Detail</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
              <p class="text-sm">Title
                <b class="d-block">{{ $poll->title }}</b>
            </p>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
        <div class="text-muted">
          <p class="text-sm">Poll Expired Date
            <b class="d-block">{{ $poll->poll_valid_untill }}</b>
        </p>
    </div>
</div>
<div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
    <div class="text-muted">
      <p class="text-sm">Status
        <b class="d-block">
          @if ($poll->status == 1)
          <label class="btn btn-warning btn-xs">Active</label>
          @elseif ($poll->status == 0)
          <label class="btn btn-success btn-xs">In Active</label>
          @endif
      </b>
  </p>
</div>
</div>

</div>
</div>

<div class="card-body">
    <h4>Options</h4>
    <div class="row">
        @php
        if(isset($poll)){
            $options = $poll->options;
            $count=count($options);
        }
        @endphp
        @if(isset($poll))

        @if(count($options))
        @foreach ($options as $key=>$val)
        <div class="col-12 col-md-12 col-lg-2 order-2 order-md-1">
            <div class="text-muted">
                <p class="text-sm">Option {{ $key+1 }}</p><br />
                <b class="d-block">{{ $val['option'] }}</b>
            </div>
        </div>
        @endforeach
        @endif

        @endif


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
