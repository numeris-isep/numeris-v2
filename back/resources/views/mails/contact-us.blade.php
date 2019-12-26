@component('mail::message')
# Bonjour,

{{ $user }} (<a href="mailto:{{ $email }}">{{ $email }}</a>)
a envoyé un message depuis le formulaire de contact du site.

@component('mail::panel')
**{{ $subject }}**

{{ $content }}
@endcomponent
@endcomponent
