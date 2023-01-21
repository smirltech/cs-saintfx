<?php

namespace App\Enums;

enum RolePermission: string
{
    // Eleve
    case eleves_all = 'eleves.*';
    // Enseignant
    case enseignants_all = 'enseignants.*';
    // User
    case users_all = 'users.*';

    // Devoir
    case devoirs_all = 'devoirs.*';

    // Facture
    case factures_all = 'factures.*';

    // Inscription
    case inscriptions_all = 'inscriptions.*';

    // Role
    case roles_all = 'roles.*';
    // Permission
    case permissions_all = 'permissions.*';

    case responsables_all = 'responsables.*';
    case eleves_view = 'eleves.view';
}
// }
