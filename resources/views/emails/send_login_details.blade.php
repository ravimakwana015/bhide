@component('mail::message')

<p style="line-height: 24px; margin-bottom:15px;">
    Hi {{ $user->name }}
</p>
<p>
    Welcome to {{ config('app.name') }}. Please find your login details below.
</p>
<p><b>Username:</b> {{$user->email}}</p>
@if(isset($password))
<p><b>Password:</b> {{$password}}</p>
@else
<p><b>Password:</b> {{$user->password}}</p>
@endif

@if($user->user_type=='company')
    @component('mail::button', ['url' => url('login')])
    Login
    @endcomponent
@else
    @component('mail::button', ['url' => url('login')])
    Download App
    @endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
