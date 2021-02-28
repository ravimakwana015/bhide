@component('mail::message')
# Introduction

<p style="line-height: 24px; margin-bottom:15px;">
    Company Name : {{ $company->company_name }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Contact Person Name : {{ $company->person_name }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Company Email : {{ $company->email }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Mobile Number : {{ $company->mobile }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Landline Number : {{ $company->landline }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Apartment Count : {{ $company->apartment_count }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Subscription Amount : {{ $company->subscription_amount }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Subscription time : {{ $company->subscription_time }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Building Address : {{ $company->building_address }}
</p>
<p style="line-height: 24px; margin-bottom:15px;">
    Company Address : {{ $company->company_address }}
</p>

@component('mail::button', ['url' => $url])
Subscribe
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
