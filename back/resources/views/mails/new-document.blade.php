@php
  $mailSav = env('SAV_ADDRESS');
  $profileUrl = env('FRONT_APP_URL') . '/profil';
  $contactUrl = env('FRONT_APP_URL') . '/nous-contacter';
@endphp

@component('mail::message')
# Bonjour,

De nouveaux documents sont disponibles sur ton profil.

Pense à les télécharger et à **envoyer par email** ton *contrat de travail signé* à
l'addresse <a href="mailto:{{ $mailSav }}">{{ $mailSav }}</a> ou à le **déposer au
local Numéris** situé au sous-sol du *28 Rue Notre Dame des Champs, 75006 Paris*.

**Note que tu ne seras pas payé tant que ton contrat ne sera pas remis à Numéris.**

@component('mail::button', ['url' => $profileUrl])
  Voir mon profil
@endcomponent

*N'hésite pas à <a href="{{ $contactUrl }}" target="_blank">contacter</a> un membre de l'équipe si tu as des questions.*

Cordialement,<br>
L'équipe Numéris.

@endcomponent
