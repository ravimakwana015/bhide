@component('mail::message')
# Introduction

<p style="line-height: 24px; margin-bottom:15px;">
    Hi {{ $user->name }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    THANK YOU FOR SIGNING UP!
</p>

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
