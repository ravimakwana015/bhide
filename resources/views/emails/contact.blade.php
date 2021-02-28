@component('mail::message')

<p><b>Name:</b> {{ $user['first_name'] }} {{$user['last_name'] }}</p>
<p><b>Company Name:</b> {{$user['company'] }}</p>
<p><b>Email:</b> {{$user['email'] }}</p>
@if(isset($user['message']))
<p><b>Message:</b> {{$user['message'] }}</p>
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent
