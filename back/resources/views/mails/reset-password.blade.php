@php
  $email = $notifiable->getEmailForPasswordReset();
  $minutes = config('auth.passwords.users.expire');
  $resetPasswordUrl = env('FRONT_APP_URL') . "/mot-de-passe/reinitialiser?token=$token&email=$email";
@endphp

@component('mail::message')
  # Bonjour,

  Vous recevez cet email car nous avons reçu une **demande de réinitialisation de
  mot de passe** pour votre compte Numéris.

  @component('mail::button', ['url' => $resetPasswordUrl])
    Réinitialiser le mot de passe
  @endcomponent

  Ce lien de réinitialisation expirera dans **{{ $minutes }} minutes**.

  *Si vous n'êtes pas l'auteur de cette demande, cela peut signifier que quelqu'un
  essaye de redéfinir votre mot de passe.*

  Cordialement,<br>
  L'équipe Numéris.

  @component('mail::panel')
    Si vous ne pouvez pas accéder au lien, veuillez copier-coller ce lien dans
    votre navigateur :<br>
    <a href="{{ $resetPasswordUrl }}">{{ $resetPasswordUrl }}</a>
  @endcomponent

@endcomponent
