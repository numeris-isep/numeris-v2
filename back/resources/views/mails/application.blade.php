@php
  $user = $application->user;
  $mission = $application->mission;
  $otherMissionsUrl = env('FRONT_APP_URL') . '/missions-disponibles';
@endphp

@component('mail::message')
  # Bonjour {{ $user->first_name }},

  Ta candidature a été **{{ trans("validation.attributes.$application->status") }}** sur la mission :<br>
  **{{ $mission->title }}**
  du **{{ \Carbon\Carbon::parse($mission->start_at)->format('d/m/Y à H\hi') }}**

  @if($application->status == \App\Models\Application::ACCEPTED)

  @endif


  @component('mail::button', ['url' => $otherMissionsUrl])
    Voir les autres missions disponibles
  @endcomponent

  Cordialement,<br>
  L'équipe Numéris.

@endcomponent
