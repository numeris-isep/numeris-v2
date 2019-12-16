@php
  $user = $notifiable;
  $frontUrl = env('FRONT_APP_URL');
  $contactUrl = env('FRONT_APP_URL') . '/nous-contacter';
@endphp

@component('mail::message')
# Bonjour {{ $user->first_name }},

Ton compte a été **{{ $user->activated ? 'activé' : 'désactivé' }}**.

@if($user->activated)
Tu peux maintenant postuler aux missions et suivre tes candidatures.

@component('mail::button', ['url' => $frontUrl])
  Se rendre sur le site
@endcomponent

*N'hésite pas à <a href="{{ $contactUrl }}" target="_blank">contacter</a> un membre de l'équipe si tu as des questions.*
@else
*N'hésite pas à contacter un membre de l'équipe si tu as des questions.*
@endif

Cordialement,<br>
L'équipe Numéris.
@endcomponent
