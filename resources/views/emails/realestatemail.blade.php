@component('mail::message')

<p><b>Name:</b> {{ $user['name'] }} </p>
<p><b>Email:</b> {{$user['email'] }}</p>
<p><b>Phone:</b> {{$user['phone'] }}</p>
@if(isset($user['message']))
<p><b>Message:</b> {{$user['message'] }}</p>
@endif
Thanks,<br>
{{ config('app.name') }}
@endcomponent