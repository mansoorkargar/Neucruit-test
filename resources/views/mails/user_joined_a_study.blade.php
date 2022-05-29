@component('mail::message')
# {{ $user->name }} joined a "{{ $study->name }}" study
Hey,
We just want to let you know that {{ $user->name }} {{ $user->last_name }} has just joined a "{{ $study->name }}" study on Neucruit.com!

@component('mail::button', ['url' => url(config('app.url'))])
Go to the studies
@endcomponent
@endcomponent