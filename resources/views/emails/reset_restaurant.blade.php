@component('mail::message')

Sofra Reset Password.


<p>Your Reset Code Is :{{$user->pin_code}}</p>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
