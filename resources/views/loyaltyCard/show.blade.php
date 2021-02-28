@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('Loyalty Card Details') }}</h3>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        {{ Form::label('loyalty_card_image', 'Loyalty Card Image', ['class' => 'control-label required']) }}
                        <br />
                        <img src="{{ asset('storage/app/img/loyaltyCard/' . $loyaltyCard->loyalty_card_image) }}" id="career_img">
                    </div>
                </div>
            </div>
            <hr />
            <h4>Offer & Discount stores</h4>
            <hr />
            @php
            $count=0;
            if(isset($loyaltyCard)){
            $storeDetails = json_decode($loyaltyCard->store_details,true);
            $count=count($storeDetails);
            }
            @endphp
            <input type="hidden" value="{{ $count }}" id="count" />
            @if(isset($loyaltyCard))
            <div class="row">
                @if(count($storeDetails))
                @foreach ($storeDetails as $key=>$val)
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Store name</label><br/>
                                <b>{{ $val['name'] }}</b>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Store Address</label><br/>
                                <b>{{ $val['address'] }}</b>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Offer Detail</label><br/>
                                <b>{{ $val['offer'] }}</b>
                            </div>
                        </div>
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
