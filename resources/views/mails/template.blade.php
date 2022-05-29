@component('mail::message')
# {{ $communication->email_subject }}
{!! $communication->content !!}
@endcomponent