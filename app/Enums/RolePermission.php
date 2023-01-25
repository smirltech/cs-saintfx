<?php

namespace App\Enums;

enum RolePermission: string
{
    // Eleve
    case eleves_all = 'eleves.*';

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

    //------------------ Filière ---------------- //
    case filieres_all = 'filieres.*';
    case filieres_view = 'filieres.view.*';
    case filieres_create = 'filieres.create';
    case filieres_update_all = 'filieres.update.*';
    case filieres_delete = 'filieres.delete.*';
    case filieres_restore = 'filieres.restore.*';
    case filieres_force_delete = 'filieres.force-delete.*';
    //------------------ ./Filière ---------------- //
    //------------------ Option ---------------- //
    case options_all = 'options.*';
    case options_view = 'options.view.*';
    case options_create = 'options.create';
    case options_update_all = 'options.update.*';
    case options_delete = 'options.delete.*';
    case options_restore = 'options.restore.*';
    case options_force_delete = 'options.force-delete.*';
    //------------------ ./Option ---------------- //
    //------------------ Section ---------------- //
    case sections_all = 'sections.*';
    case sections_view = 'sections.view.*';
    case sections_create = 'sections.create';
    case sections_update_all = 'sections.update.*';
    case sections_delete = 'sections.delete.*';
    case sections_restore = 'sections.restore.*';
    case sections_force_delete = 'sections.force-delete.*';
    //------------------ ./Section ---------------- //
    //------------------ Enseignant ---------------- //
    case enseignants_all = 'enseignants.*';
    case enseignants_view = 'enseignants.view.*';
    case enseignants_create = 'enseignants.create';
    case enseignants_update_all = 'enseignants.update.*';
    case enseignants_delete = 'enseignants.delete.*';
    case enseignants_restore = 'enseignants.restore.*';
    case enseignants_force_delete = 'enseignants.force-delete.*';

    //------------------ ./Enseignant ---------------- //


    //------------------ Année ---------------- //
    case annees_all = 'annees.*';
    case annees_view = 'annees.view.*';
    case annees_create = 'annees.create';
    case annees_update_all = 'annees.update.*';
    case annees_delete = 'annees.delete.*';
    case annees_restore = 'annees.restore.*';
    case annees_force_delete = 'annees.force-delete.*';
    case annees_update_encours = 'annees.update.encours';

    //------------------ ./Année ---------------- //

    //------------------ Users ---------------- //
    case users_all = 'users.*';
    case users_view = 'users.view.*';
    case users_create = 'users.create';
    case users_update_all = 'users.update.*';
    case users_delete = 'users.delete.*';
    case users_restore = 'users.restore.*';
    case users_force_delete = 'users.force-delete.*';
    //------------------ ./Users ---------------- //
}
// }
