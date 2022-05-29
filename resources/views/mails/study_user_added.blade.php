@component('mail::message')
# You're added to a study
Hey {{ $user->name }} {{ $user->last_name }},
You've been added to a study {{ $study->name }} on Neucruit

@component('mail::button', ['url' => $url])
View the study
@endcomponent
@endcomponent