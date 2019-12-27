<?php

use App\Models\Project;
use App\Models\Role;

return [
    /*
    |--------------------------------------------------------------------------
    | API Lines
    |--------------------------------------------------------------------------
    |
    | The following  lines are used when an error is thrown or in any response
    | of the backend.
    |
    */

    'auth'      => 'Veuillez vous connecter pour accéder à cette page.',
    'logout'    => 'Déconnecté avec succès.',

    '401'   => 'Non autorisé.',
    '403'   => 'Vous n\'avez pas le droit d\'effectuer cette action.',
    '404'   => 'La ressource demandée n\'existe pas ou plus.',
    '405'   => 'Méthode non autorisée.',
    '429'   => 'Trop de requêtes effectuées. Veuillez attendre 1 minute.',

    'roles' => [
        Role::STUDENT       => 'Vous n\'avez pas le droit d\'effectuer cette action.',
        Role::STAFF         => 'Veuillez contacter un Administrateur pour effectuer cette action.',
        Role::ADMINISTRATOR => 'Veuillez contacter un Développeur pour effectuer cette action.',
        Role::DEVELOPER     => 'Cette action est interdite pour tous les utilisateurs.',
    ],

    'users' => [
        'completed'         => 'L\'utilisateur n\'a complété son profil.',
        'tou_accepted'      => 'L\'utilisateur n\'a pas accepté les conditions d\'utilisations.',
        'email_verified_at' => 'L\'utilisateur n\'a pas vérifié son adresse email.'
    ],

    'projects' => [
        Project::HIRING => 'Le projet doit avoir le status Ouvert.',
    ],

    'clients' => [
        'bills' => 'Des données de paiement sont associées à ce client.',
    ],
];
