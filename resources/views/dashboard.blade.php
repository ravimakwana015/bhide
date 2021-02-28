@extends('layouts.app')

@section('content')
<div class="profile-edit-page">
    <div class="card shadow">
        <div class="card-header ">
            <div class="row align-items-center">
                <div class="titleText">
                    <h3 class="mb-0">{{ __('Dashboard') }}</h3>
                </div>
            </div>
        </div>

        <div class="card-body">
            
            <p>Under Construction</p>
            
        </div>
    </div>
</div>
@endsection
@push('js')

<script>
    $(document).ready(function() {
		$("#profile_form").validate({
			rules: {
                'company_name':{
                   'required': true
                },
                'person_name':{
                   'required': true
                },
                'mobile':{
                   'required': true
                },
                'landline':{
                   'required': true
                },
                'company_address':{
                   'required': true
                },
			},
			messages: {
			},
		});
	});
</script>
@endpush
