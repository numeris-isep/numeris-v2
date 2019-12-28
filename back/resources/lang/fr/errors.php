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
        'superior'          => 'Le rôle choisi doit être inférieur ou égal à votre rôle actuel.',
        'same'              => 'Le rôle de l\'utilisateur est déjà :role',
    ],

    'profile_not_completed' => 'L\'utilisateur n\'a complété son profil.',
    'tou_not_accepted'      => 'L\'utilisateur n\'a pas accepté les conditions d\'utilisations.',
    'email_not_verified'    => 'L\'utilisateur n\'a pas vérifié son adresse email.',

    'wrong_project_step'            => 'Le projet doit avoir le status :allowed_step.',
    'project_contains_user'         => 'L\'utilisateur est déjà membre du projet.',
    'project_doesnot_contain_user'  => 'L\'utilisateur n\'est pas membre du projet.',

    'no_bill_on_project'   => 'Les heures effectuées par les étudiants n\'ont pas été saisies sur les missions de ce projet.',
    'client_has_bill'      => 'Des données de paiement sont associées à ce client.',

    'convention_has_project' => 'La convention est rattachée à au moins un projet.',

    'no_payslip_for_month' => 'Il n\'y a pas de document étudiant pour ce mois-ci.',

    'application_exists'    => 'L\'utilisateur a déjà candidaté pour la mission.',
    'mission_locked'        => 'La mission est fermée aux candidatures.',
    'mission_expired'       => 'La mission a expirée.',
];
