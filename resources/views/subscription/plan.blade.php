@extends('layouts.app')

@section('content')
<div class="main plan-page">
    <section class="banner-wrap">
        <div class="img-wrap">
            <img src="{{ asset('public/front') }}/images/home-banner.jpeg" alt="home-banner">
        </div>
        <div class="banner-content">
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            @endif
            <div class="left-content">
                <div class="contact-text-wrap">
                    <p>To Pay</p>
                    <h2>£{{ number_format($plan->amount/100, 2) }}</h2>
                </div>
                <div class="back-btn-wrap">
                    <a href="{{ route('payment.details',Request::segment(2)) }}" class="button"><i
                            class="fas fa-caret-left"></i> Back to payment Details</a>
                </div>
            </div>
            <div class="right-content">
                <div class="contact-form-wrap">
                    <h2>Payments</h2>
                    <div class="pay-with">
                        <span>Pay with credit card</span>
                        <div class="card-symbols">
                            <img src="{{ asset('public/front/images/AX.jpg')}}" alt="ax"
                                style="float: left; width: 30%;">
                            <img src="{{ asset('public/front/images/master.jpg')}}" alt="master"
                                style="float: left; width: 30%;">
                            <img src="{{ asset('public/front/images/visa.png')}}" alt="visa"
                                style="float: left; width: 30%;">
                        </div>
                    </div>
                    {!! Form::open(['url' => route('order-post'), 'data-parsley-validate', 'id' => 'payment-form']) !!}
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <div id="error-msg"></div>
                    <input type="hidden" value="{{ $plan->id }}" name="plan">
                    <input type="hidden" value="{{ $company->id }}" name="company_id">
                    <div class="form-item" id="cc-group">
                        <label class="fo"></label>
                        {!! Form::text('number', null, [
                        'class' => 'form-control',
                        'required' => 'required',
                        'data-stripe' => 'number',
                        'data-parsley-type' => 'number',
                        'maxlength' => '16',
                        'data-parsley-trigger' => 'change focusout',
                        'data-parsley-class-handler' => '#cc-group',
                        'placeholder' => 'Credit Card Number',
                        ]) !!}
                    </div>
                    <div class="form-item" id="ccv-group">
                        <label>Expiration</label>
                        {!! Form::selectMonth('exp_month', null, [
                        'required' => 'required',
                        'data-stripe' => 'exp-month'
                        ], '%m') !!}
                        {!! Form::selectYear('exp_year', date('Y'), date('Y') + 10, null, [
                        'required' => 'required',
                        'data-stripe' => 'exp-year'
                        ]) !!}
                    </div>
                    <div class="form-item">
                        <input required="required" data-stripe="cvc" data-parsley-type="number"
                            data-parsley-trigger="change focusout" maxlength="4" data-parsley-class-handler="#ccv-group"
                            placeholder="3 or 4 digits CVC/CVV code" name="cvc" type="password" />
                    </div>
                    <div class="form-action">
                        {!! Form::submit('Place order!', ['class' => 'btn', 'id' => 'submitBtn', 'style' =>
                        'margin-bottom: 10px;']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

    <!-- PARSLEY -->
    <script>
        window.ParsleyConfig = {
					errorsWrapper: '<div></div>',
					errorTemplate: '<div class="alert alert-danger parsley" role="alert"></div>',
					errorClass: 'has-error',
					successClass: 'has-success'
				};
    </script>

    <script src="https://parsleyjs.org/dist/parsley.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey("<?php echo env('STRIPE_KEY') ?>");
    </script>
</div>
@endsection
