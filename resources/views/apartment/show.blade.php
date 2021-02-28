@extends('layouts.app')
@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="titleText">
                <h3 class="mb-0">{{ __('View Apartment Member') }}</h3>
            </div>
            <div class="btn-wrap">
              <a class="btn mb-0" href="{{ route('apartment.index') }}"><i class="fas fa-arrow-left"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <h5 class="mb-0">{{ __('General Information') }}</h5>
            <hr />
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-user"></i> First Name</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->first_name !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-user"></i> Middle Name</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->middle_name !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-user"></i> Last Name</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->last_name !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-birthday-cake"></i> Date Of Birth</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! date('d F Y',strtotime($user->date_of_birth)) !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-mars"></i> Gender</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! ucfirst($user->gender) !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-envelope"></i> Email</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color"><a href="mailto:{!! $user->email !!}">{!! $user->email
                                    !!}</a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-user"></i> Member Type</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->member_type !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-mobile"></i> Mobile</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color"><a href="tel:{!! $user->phone_number !!}">{!! $user->phone_number
                                    !!}</a></span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-university"></i> Building Name</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->userCompany->company_name !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-list-ol"></i> Apartment</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->userUnit->block_number !!}-{!! $user->userUnit->flat_number !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <h5 class="mb-0">{{ __('Permanent Contact Information') }}</h5>
            <hr />
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-map-marker"></i> Address</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->address !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-map-marker"></i> City </div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->city !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-globe"></i> Country</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->country !!}</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <i class="fa fa-list-ol"></i> Postal Code</div>
                        <div class="col-md-6">
                            <span class="span_left span_padding">:</span>
                            <span class="txt_color">{!! $user->zip_code !!}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <h5 class="mb-0">{{ __('Resident Status') }}</h5>
            <hr />
            <div class="row">
                <div class="col-md-6">
                    <div class="my-group-list">
                        <table class="table">
                            <tbody>
                                @foreach ($members as $member)
                                <tr>
                                    <td>
                                       {!! $member->first_name !!} {!! $member->last_name !!} {!! $member->middle_name !!}
                                    </td>
                                    <td>
                                        {!! Str::ucfirst($member->member_type) !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @include('dentist-booking.modal') --}}
@endsection
@push('js')
@endpush
