@php
  $user = $application->user;
  $mission = $application->mission;
  $otherMissionsUrl = env('FRONT_APP_URL') . '/missions-disponibles';
  $contactUrl = env('FRONT_APP_URL') . '/nous-contacter';
@endphp

@component('mail::message')
  # Bonjour {{ $user->first_name }},

  Ta candidature a été **{{ trans("validation.attributes.$application->status") }}** sur la mission :<br>
  **{{ $mission->title }}**
  du **{{ \Carbon\Carbon::parse($mission->start_at)->format('d/m/Y à H\hi') }}**

  @if($application->status == \App\Models\Application::ACCEPTED)

  Tu recevras un email prochainement avec toutes les informations de la mission.
  N'hésite pas à <a href="{{ $contactUrl }}" target="_blank">contacter</a> un membre de l'équipe si tu as des questions.

  @endif

  @component('mail::button', ['url' => $otherMissionsUrl])
    Voir les autres missions disponibles
  @endcomponent

  Cordialement,<br>
  L'équipe Numéris.

@endcomponent
