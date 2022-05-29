@component('mail::message')
# New user has just signed up
Dear Neucruit team,
A new user {{ $user->name }} {{ $user->last_name }} ({{ $user->email }}) has just signed up on Neucruit.

## Questionnaire

@if (count($answers))
@foreach ($answers as $answer)
<b>{{ $answer->question }}</b>: {{ $answer->answer ?: '–' }}<br>
@endforeach
@else
None
@endif

@component('mail::button', ['url' => $url])
View user
@endcomponent
@endcomponent