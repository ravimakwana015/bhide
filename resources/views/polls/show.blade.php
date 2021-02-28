@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Poll Details') }}</h3>
            </div>
            <div class="btn-wrap">
              <a class="btn mb-0" href="{{ route('polls.index') }}"><i class="fas fa-arrow-left"></i> Back</a>
          </div>
      </div>

      <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('title', 'Title', ['class' => 'control-label required']) }}
                    <br />
                    {{ $poll->title }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('title', 'Poll Valid', ['class' => 'control-label required']) }}
                    <br />
                    {{ $poll->poll_valid_until }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {{ Form::label('status', 'Status', ['class' => 'control-label required']) }}
                    <br />
                    @if ($poll->status == 1)
                    <label class="btn btn-warning btn-xs">Active</label>
                    @elseif ($poll->status == 0)
                    <label class="btn btn-success btn-xs">In Active</label>
                    @endif
                </div>
            </div>
        </div>
        <hr />
        <h4>Options</h4>
        <hr />
        @php
        if(isset($poll)){
            $options = $poll->options;
            $count=count($options);
        }
        @endphp
        @if(isset($poll))
        <div class="row">
            @if(count($options))
            @foreach ($options as $key=>$val)
            <div class="col-md-4">
                <div class="form-group">
                    <label>Option {{ $key+1 }}</label><br />
                    <b>{{ $val['option'] }}</b>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        @endif
    </div>
</div>
</div>
{{-- @include('dentist-booking.modal') --}}
@endsection
@push('js')
@endpush
