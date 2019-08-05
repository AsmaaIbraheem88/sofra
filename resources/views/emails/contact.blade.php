@component('mail::message')

<p>From: {{ $contact['email']}}</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
