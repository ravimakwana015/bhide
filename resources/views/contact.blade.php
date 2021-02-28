@extends('layouts.app')
@section('content')
<div class="main partner-with-page"> 
    <section class="partner-with-wrap-main">
        <div class="img-wrap">
            <img src="{{ asset('public/front/images/home-main-banner.jpg') }}">
        </div>
        <div class="partner-with-detail-wrap">
            <div class="container">
                <div class="partner-with-detail">
                    <div class="left-content">
                        <h1>Partner with us.</h1>
                        <p>We look to partner with studios which offer the highest levels of service and quality for our members.</p>
                        <p>Enquire today and we will endeavour to come back to you within 48 hours.</p>
                        <ul class="social-icons">
                            <li><a href=""><i class="fab fa-instagram"></i></a></li>
                            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                        </ul>
                    </div>
                    <div class="right-content">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        <form action="{{ route('contactus.store') }}" method="post" id="contactus">
                            @csrf
                            <div class="form-item-row name-field">
                                <label>Name *</label>
                                <div class="form-item">
                                    <input type="text" name="first_name">
                                    <span>First Name</span>
                                </div>
                                <div class="form-item">
                                    <input type="text" name="last_name">
                                    <span>Last Name</span>
                                </div>
                            </div>
                            <div class="form-item-row">
                                <label>Company *</label>
                                <div class="form-item">
                                    @guest
                                    <input type="text" name="company">
                                    @endguest
                                    @auth
                                    <input type="text" name="company" value="{{ Auth::user()->Company->company_name }}">
                                    @endauth
                                </div>
                            </div>
                            <div class="form-item-row">
                                <label>Email *</label>
                                <div class="form-item">
                                    <input type="email" name="email">
                                </div>
                            </div>
                            <div class="form-item-row">
                                <label>Message </label>
                                <div class="form-item">
                                    <textarea name="message"></textarea>
                                </div>
                            </div>
                            <div class="form-action">
                                <button type="submit" class="btn">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function () {
        $('#contactus').validate({
            rules:{
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                company: {
                    required: true
                },
                email: {
                    required: true
                },
            },
            messages: {
                first_name: {
                    required: 'Please Enter Your First Name'
                },
                last_name: {
                    required: 'Please Enter Your Last Name'
                },
                company: {
                    required: 'Please Enter Your Company Name'
                },
                email: {
                    required: 'Please Enter Your Email'
                },
            },
            submitHandler: function (form) {
                form.submit();

            }
        });
    });
</script>
@endpush
