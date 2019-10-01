@php
  $minutes = config('auth.verification.expire');
@endphp

@component('mail::message')
  # Bonjour {{ $notifiable->first_name }},

  Vous recevez cet email car nous avons reçu une **demande de vérification de
  l'adresse email** pour votre compte Numéris.

  @component('mail::button', ['url' => $url])
    Vérifier votre adresse email
  @endcomponent

  Ce lien de réinitialisation expirera dans **{{ $minutes }} minutes**.

  *Si vous n'êtes pas l'auteur de cette demande, cela peut signifier que quelqu'un
  essaye de vérifier votre email.*

  Cordialement,<br>
  L'équipe Numéris.

@endcomponent
