@component('mail::message')
# You're invited to a study
Hey,
You've been invited to a study {{ $invitation->study->name }} on Neucruit.<br><br>
Please, follow the link below and create an account for youself to access it.

@component('mail::button', ['url' => $url])
Create an account
@endcomponent
@endcomponent