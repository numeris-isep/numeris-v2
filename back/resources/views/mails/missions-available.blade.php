@php
  $availableMissionsUrl = env('FRONT_APP_URL') . '/missions-disponibles';
@endphp

@component('mail::message')
# Bonjour,

De nouvelles missions sont disponibles sur le site :

@foreach($missions as $mission)
- Le *{{ \Carbon\Carbon::parse($mission->start_at)->format('d/m/Y à H\hi') }}*, **{{ $mission->title }}** à *{{ $mission->fullAddress }}*
@endforeach

@component('mail::button', ['url' => $availableMissionsUrl])
  Voir toutes les missions disponibles
@endcomponent

*N'hésitez pas à postuler ou à contacter un membre de l'équipe pour plus d'informations.*

Cordialement,<br>
L'équipe Numéris.
@endcomponent
