@php
  $user = $application->user;
  $mission = $application->mission;
  $userUrl = env('FRONT_APP_URL') . '/utilisateurs/' . $user->id;
  $missionUrl = env('FRONT_APP_URL') . '/missions/' . $mission->id;
@endphp

@component('mail::message')
# Bonjour,

L'utilisateur <a href="{{ $userUrl }}">{{ $user->getFullName() }}</a> a retiré sa candidature de la mission :<br>
**{{ $mission->title }}**
du **{{ \Carbon\Carbon::parse($mission->start_at)->format('d/m/Y à H\hi') }}**

@component('mail::button', ['url' => $missionUrl])
  Voir les détails de la mission
@endcomponent

@endcomponent
