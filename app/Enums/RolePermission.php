<?php

namespace App\Enums;

enum RolePermission: string
{
    // Eleve
    case eleves_all = 'eleves.*';

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

    //------------------ Enseignant ---------------- //
    case enseignants_all = 'enseignants.*';
    case enseignants_create = 'enseignants.create';
    case enseignants_update_all = 'enseignants.update.*';
    case enseignants_delete = 'enseignants.delete.*';
    case enseignants_restore = 'enseignants.restore.*';
    case enseignants_forceDelete = 'enseignants.forceDelete.*';

    //------------------ ./Enseignant ---------------- //


    //------------------ Année ---------------- //
    case annees_all = 'annees.*';
    case annees_view = 'annees.view.*';
    case annees_create = 'annees.create';
    case annees_update_all = 'annees.update.*';
    case annees_delete = 'annees.delete.*';
    case annees_restore = 'annees.restore.*';
    case annees_forceDelete = 'annees.forceDelete.*';
    case annees_encours = 'annees.encours';

    //------------------ ./Année ---------------- //
}
// }
