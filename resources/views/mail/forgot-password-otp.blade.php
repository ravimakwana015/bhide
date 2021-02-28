@component('mail::message')
<p style="line-height: 24px; margin-bottom:15px;">
	Hi {{ $user['first_name'] }} {{ $user['last_name'] }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
	Your Otp is {{ $otp }}
</p>

{{-- @component('mail::button', ['url' => ''])
SmileScan
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
