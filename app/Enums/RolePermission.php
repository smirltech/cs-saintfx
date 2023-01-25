<?php

namespace App\Enums;

enum RolePermission: string
{
    // Facture
    case factures_all = 'factures.*';
    // Role
    case roles_all = 'roles.*';
    // Permission
    case permissions_all = 'permissions.*';

    //------------------ Devoirs ---------------- //
    case devoirs_all = 'devoirs.*';
    case devoirs_view = 'devoirs.view.*';
    case devoirs_create = 'devoirs.create';
    case devoirs_update_all = 'devoirs.update.*';
    case devoirs_delete = 'devoirs.delete.*';
    case devoirs_restore = 'devoirs.restore.*';
    case devoirs_force_delete = 'devoirs.force-delete.*';
    //------------------ ./Devoirs ---------------- //

    //------------------ Responsable ---------------- //
    case responsables_all = 'responsables.*';
    case responsables_view = 'responsables.view.*';
    case responsables_create = 'responsables.create';
    case responsables_update_all = 'responsables.update.*';
    case responsables_delete = 'responsables.delete.*';
    case responsables_restore = 'responsables.restore.*';
    case responsables_force_delete = 'responsables.force-delete.*';
    //------------------ ./Responsable ---------------- //

    //------------------ Eleve ---------------- //
    case eleves_all = 'eleves.*';
    case eleves_view = 'eleves.view.*';
    case eleves_create = 'eleves.create';
    case eleves_update_all = 'eleves.update.*';
    case eleves_delete = 'eleves.delete.*';
    case eleves_restore = 'eleves.restore.*';
    case eleves_force_delete = 'eleves.force-delete.*';
    //------------------ ./Eleve ---------------- //

    //------------------ Inscription ---------------- //
    case inscriptions_all = 'inscriptions.*';
    case inscriptions_view = 'inscriptions.view.*';
    case inscriptions_create = 'inscriptions.create';
    case inscriptions_update_all = 'inscriptions.update.*';
    case inscriptions_delete = 'inscriptions.delete.*';
    case inscriptions_restore = 'inscriptions.restore.*';
    case inscriptions_force_delete = 'inscriptions.force-delete.*';
    //------------------ ./Inscription ---------------- //
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
