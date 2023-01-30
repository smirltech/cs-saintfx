<?php

namespace App\Enums;

enum RolePermission: string
{
    //------------------ Consommables ---------------- //
    case consommables_all = 'consommables.*';
    case consommables_view = 'consommables.view.*';
    case consommables_create = 'consommables.create';
    case consommables_update_all = 'consommables.update.*';
    case consommables_delete = 'consommables.delete.*';
    case consommables_restore = 'consommables.restore.*';
    case consommables_force_delete = 'consommables.force-delete.*';
    //------------------ ./Consommables ---------------- //
    //------------------ Units ---------------- //
    case units_all = 'units.*';
    case units_view = 'units.view.*';
    case units_create = 'units.create';
    case units_update_all = 'units.update.*';
    case units_delete = 'units.delete.*';
    case units_restore = 'units.restore.*';
    case units_force_delete = 'units.force-delete.*';
    //------------------ ./Units ---------------- //
    //------------------ Ouvrages ---------------- //
    case ouvrages_all = 'ouvrages.*';
    case ouvrages_view = 'ouvrages.view.*';
    case ouvrages_create = 'ouvrages.create';
    case ouvrages_update_all = 'ouvrages.update.*';
    case ouvrages_delete = 'ouvrages.delete.*';
    case ouvrages_restore = 'ouvrages.restore.*';
    case ouvrages_force_delete = 'ouvrages.force-delete.*';
    //------------------ ./Ouvrages ---------------- //
    //------------------ OuvrageCategory ---------------- //
    case ouvrage_categories_all = 'ouvrage-categories.*';
    case ouvrage_categories_view = 'ouvrage-categories.view.*';
    case ouvrage_categories_create = 'ouvrage-categories.create';
    case ouvrage_categories_update_all = 'ouvrage-categories.update.*';
    case ouvrage_categories_delete = 'ouvrage-categories.delete.*';
    case ouvrage_categories_restore = 'ouvrage-categories.restore.*';
    case ouvrage_categories_force_delete = 'ouvrage-categories.force-delete.*';
    //------------------ ./OuvrageCategory ---------------- //
    //------------------ Etiquettes ---------------- //
    case etiquettes_all = 'etiquettes.*';
    case etiquettes_view = 'etiquettes.view.*';
    case etiquettes_create = 'etiquettes.create';
    case etiquettes_update_all = 'etiquettes.update.*';
    case etiquettes_delete = 'etiquettes.delete.*';
    case etiquettes_restore = 'etiquettes.restore.*';
    case etiquettes_force_delete = 'etiquettes.force-delete.*';
    //------------------ ./Etiquettes ---------------- //
    //------------------ Auteurs ---------------- //
    case auteurs_all = 'auteurs.*';
    case auteurs_view = 'auteurs.view.*';
    case auteurs_create = 'auteurs.create';
    case auteurs_update_all = 'auteurs.update.*';
    case auteurs_delete = 'auteurs.delete.*';
    case auteurs_restore = 'auteurs.restore.*';
    case auteurs_force_delete = 'auteurs.force-delete.*';
    //------------------ ./Auteurs ---------------- //
    //------------------ Depenses ---------------- //
    case depenses_all = 'depenses.*';
    case depenses_view = 'depenses.view.*';
    case depenses_create = 'depenses.create';
    case depenses_update_all = 'depenses.update.*';
    case depenses_delete = 'depenses.delete.*';
    case depenses_restore = 'depenses.restore.*';
    case depenses_force_delete = 'depenses.force-delete.*';
    //------------------ ./Depenses ---------------- //
    //------------------ DepenseTypes ---------------- //
    case depense_types_all = 'depense-types.*';
    case depense_types_view = 'depense-types.view.*';
    case depense_types_create = 'depense-types.create';
    case depense_types_update_all = 'depense-types.update.*';
    case depense_types_delete = 'depense-types.delete.*';
    case depense_types_restore = 'depense-types.restore.*';
    case depense_types_force_delete = 'depense-types.force-delete.*';
    //------------------ ./DepenseTypes ---------------- //
    //------------------ Revenu ---------------- //
    case revenus_all = 'revenus.*';
    case revenus_view = 'revenus.view.*';
    case revenus_create = 'revenus.create';
    case revenus_update_all = 'revenus.update.*';
    case revenus_delete = 'revenus.delete.*';
    case revenus_restore = 'revenus.restore.*';
    case revenus_force_delete = 'revenus.force-delete.*';
    //------------------ ./Revenu ---------------- //
    //------------------ Frais ---------------- //
    case frais_all = 'frais.*';
    case frais_view = 'frais.view.*';
    case frais_create = 'frais.create';
    case frais_update_all = 'frais.update.*';
    case frais_delete = 'frais.delete.*';
    case frais_restore = 'frais.restore.*';
    case frais_force_delete = 'frais.force-delete.*';
    //------------------ ./Frais ---------------- //
    //------------------ Perceptions ---------------- //
    case perceptions_all = 'perceptions.*';
    case perceptions_view = 'perceptions.view.*';
    case perceptions_create = 'perceptions.create';
    case perceptions_update_all = 'perceptions.update.*';
    case perceptions_delete = 'perceptions.delete.*';
    case perceptions_restore = 'perceptions.restore.*';
    case perceptions_force_delete = 'perceptions.force-delete.*';
    //------------------ ./Perceptions ---------------- //
    //------------------ Classes ---------------- //
    case classes_all = 'classes.*';
    case classes_view = 'classes.view.*';
    case classes_create = 'classes.create';
    case classes_update_all = 'classes.update.*';
    case classes_delete = 'classes.delete.*';
    case classes_restore = 'classes.restore.*';
    case classes_force_delete = 'classes.force-delete.*';
    //------------------ ./Classes ---------------- //
    //------------------ Cours ---------------- //
    case cours_all = 'cours.*';
    case cours_view = 'cours.view.*';
    case cours_create = 'cours.create';
    case cours_update_all = 'cours.update.*';
    case cours_delete = 'cours.delete.*';
    case cours_restore = 'cours.restore.*';
    case cours_force_delete = 'cours.force-delete.*';
    //------------------ ./Cours ---------------- //
    /*//------------------ Factures ---------------- //
    case factures_all = 'factures.*';
    case factures_view = 'factures.view.*';
    case factures_create = 'factures.create';
    case factures_update_all = 'factures.update.*';
    case factures_delete = 'factures.delete.*';
    case factures_restore = 'factures.restore.*';
    case factures_force_delete = 'factures.force-delete.*';
    //------------------ ./Factures ---------------- //*/

    //------------------ Permissions ---------------- //
    case permissions_all = 'permissions.*';
    case permissions_view = 'permissions.view.*';
    case permissions_create = 'permissions.create';
    case permissions_update_all = 'permissions.update.*';
    case permissions_delete = 'permissions.delete.*';
    case permissions_restore = 'permissions.restore.*';
    case permissions_force_delete = 'permissions.force-delete.*';
    //------------------ ./Permissions ---------------- //
    //------------------ Roles ---------------- //
    case roles_all = 'roles.*';
    case roles_view = 'roles.view.*';
    case roles_create = 'roles.create';
    case roles_update_all = 'roles.update.*';
    case roles_delete = 'roles.delete.*';
    case roles_restore = 'roles.restore.*';
    case roles_force_delete = 'roles.force-delete.*';
    //------------------ ./Roles ---------------- //

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


    public function label(): string
    {
        return match ($this) {
            default => $this->value,
            // Users
            self::users_create => 'Créer un utilisateur',
            self::users_delete => 'Supprimer un utilisateur',
            self::users_all => 'Gérer les utilisateurs',
            self::users_force_delete => 'Supprimer définitivement un utilisateur',
            self::users_restore => 'Restaurer un utilisateur',
            self::users_update_all => 'Modifier un utilisateur',
            self::users_view => 'Voir un utilisateur',
            // Roles
            self::roles_all => 'Gérer les rôles',
            self::roles_create => 'Créer un rôle',
            self::roles_delete => 'Supprimer un rôle',
            self::roles_force_delete => 'Supprimer définitivement un rôle',
            self::roles_restore => 'Restaurer un rôle',
            self::roles_update_all => 'Modifier un rôle',
            self::roles_view => 'Voir un rôle',
            // Permissions
            self::permissions_all => 'Gérer les permissions',
            self::permissions_create => 'Créer une permission',
            self::permissions_delete => 'Supprimer une permission',
            self::permissions_force_delete => 'Supprimer définitivement une permission',
            self::permissions_restore => 'Restaurer une permission',
            self::permissions_update_all => 'Modifier une permission',
            self::permissions_view => 'Voir une permission',
            // Années
            self::annees_all => 'Gérer les années',
            self::annees_create => 'Créer une année',
            self::annees_delete => 'Supprimer une année',
            self::annees_force_delete => 'Supprimer définitivement une année',
            self::annees_restore => 'Restaurer une année',
            self::annees_update_all => 'Modifier une année',
            self::annees_update_encours => 'Modifier l\'année en cours',
            self::annees_view => 'Voir une année',
            // Eleves
            self::eleves_all => 'Gérer les élèves',
            self::eleves_create => 'Créer un élève',
            self::eleves_delete => 'Supprimer un élève',
            self::eleves_force_delete => 'Supprimer définitivement un élève',
            self::eleves_restore => 'Restaurer un élève',
            self::eleves_update_all => 'Modifier un élève',
            self::eleves_view => 'Voir un élève',
            // Responsables
            self::responsables_all => 'Gérer les responsables',
            self::responsables_create => 'Créer un responsable',
            self::responsables_delete => 'Supprimer un responsable',
            self::responsables_force_delete => 'Supprimer définitivement un responsable',
            self::responsables_restore => 'Restaurer un responsable',
            self::responsables_update_all => 'Modifier un responsable',
            self::responsables_view => 'Voir un responsable',
            // Enseignants
            self::enseignants_all => 'Gérer les enseignants',
            self::enseignants_create => 'Créer un enseignant',
            self::enseignants_delete => 'Supprimer un enseignant',
            self::enseignants_force_delete => 'Supprimer définitivement un enseignant',
            self::enseignants_restore => 'Restaurer un enseignant',
            self::enseignants_update_all => 'Modifier un enseignant',
            self::enseignants_view => 'Voir un enseignant',
            // Sections
            self::sections_all => 'Gérer les sections',
            self::sections_create => 'Créer une section',
            self::sections_delete => 'Supprimer une section',
            self::sections_force_delete => 'Supprimer définitivement une section',
            self::sections_restore => 'Restaurer une section',
            self::sections_update_all => 'Modifier une section',
            self::sections_view => 'Voir une section',
            // Options
            self::options_all => 'Gérer les options',
            self::options_create => 'Créer une option',
            self::options_delete => 'Supprimer une option',
            self::options_force_delete => 'Supprimer définitivement une option',
            self::options_restore => 'Restaurer une option',
            self::options_update_all => 'Modifier une option',
            self::options_view => 'Voir une option',
            // Filières
            self::filieres_all => 'Gérer les filières',
            self::filieres_create => 'Créer une filière',
            self::filieres_delete => 'Supprimer une filière',
            self::filieres_force_delete => 'Supprimer définitivement une filière',
            self::filieres_restore => 'Restaurer une filière',
            self::filieres_update_all => 'Modifier une filière',
            self::filieres_view => 'Voir une filière',
            // Inscriptions
            self::inscriptions_all => 'Gérer les inscriptions',
            self::inscriptions_create => 'Créer une inscription',
            self::inscriptions_delete => 'Supprimer une inscription',
            self::inscriptions_force_delete => 'Supprimer définitivement une inscription',
            self::inscriptions_restore => 'Restaurer une inscription',
            self::inscriptions_update_all => 'Modifier une inscription',
            self::inscriptions_view => 'Voir une inscription',
            // Devoirs
            self::devoirs_all => 'Gérer les devoirs',
            self::devoirs_create => 'Créer un devoir',
            self::devoirs_delete => 'Supprimer un devoir',
            self::devoirs_force_delete => 'Supprimer définitivement un devoir',
            self::devoirs_restore => 'Restaurer un devoir',
            self::devoirs_update_all => 'Modifier un devoir',
            self::devoirs_view => 'Voir un devoir',
            /*   // Factures
               self::factures_all => 'Gérer les factures',
               self::factures_create => 'Créer une facture',
               self::factures_delete => 'Supprimer une facture',
               self::factures_force_delete => 'Supprimer définitivement une facture',
               self::factures_restore => 'Restaurer une facture',
               self::factures_update_all => 'Modifier une facture',
               self::factures_view => 'Voir une facture',*/
            // Cours
            self::cours_all => 'Gérer les cours',
            self::cours_create => 'Créer un cours',
            self::cours_delete => 'Supprimer un cours',
            self::cours_force_delete => 'Supprimer définitivement un cours',
            self::cours_restore => 'Restaurer un cours',
            self::cours_update_all => 'Modifier un cours',
            self::cours_view => 'Voir un cours',
            // Classes
            self::classes_all => 'Gérer les classes',
            self::classes_create => 'Créer une classe',
            self::classes_delete => 'Supprimer une classe',
            self::classes_force_delete => 'Supprimer définitivement une classe',
            self::classes_restore => 'Restaurer une classe',
            self::classes_update_all => 'Modifier une classe',
            self::classes_view => 'Voir une classe',
            // Perceptions
            self::perceptions_all => 'Gérer les perceptions',
            self::perceptions_create => 'Créer une perception',
            self::perceptions_delete => 'Supprimer une perception',
            self::perceptions_force_delete => 'Supprimer définitivement une perception',
            self::perceptions_restore => 'Restaurer une perception',
            self::perceptions_update_all => 'Modifier une perception',
            self::perceptions_view => 'Voir une perception',
            // Frais
            self::frais_all => 'Gérer les frais',
            self::frais_create => 'Créer un frais',
            self::frais_delete => 'Supprimer un frais',
            self::frais_force_delete => 'Supprimer définitivement un frais',
            self::frais_restore => 'Restaurer un frais',
            self::frais_update_all => 'Modifier un frais',
            self::frais_view => 'Voir un frais',
            // Revenus
            self::revenus_all => 'Gérer les revenus',
            self::revenus_create => 'Créer un revenu',
            self::revenus_delete => 'Supprimer un revenu',
            self::revenus_force_delete => 'Supprimer définitivement un revenu',
            self::revenus_restore => 'Restaurer un revenu',
            self::revenus_update_all => 'Modifier un revenu',
            self::revenus_view => 'Voir un revenu',
            // DepenseTypes
            self::depense_types_all => 'Gérer les types de dépenses',
            self::depense_types_create => 'Créer un type de dépense',
            self::depense_types_delete => 'Supprimer un type de dépense',
            self::depense_types_force_delete => 'Supprimer définitivement un type de dépense',
            self::depense_types_restore => 'Restaurer un type de dépense',
            self::depense_types_update_all => 'Modifier un type de dépense',
            self::depense_types_view => 'Voir un type de dépense',
            // Depenses
            self::depenses_all => 'Gérer les dépenses',
            self::depenses_create => 'Créer une dépense',
            self::depenses_delete => 'Supprimer une dépense',
            self::depenses_force_delete => 'Supprimer définitivement une dépense',
            self::depenses_restore => 'Restaurer une dépense',
            self::depenses_update_all => 'Modifier une dépense',
            self::depenses_view => 'Voir une dépense',
            // Auteurs
            self::auteurs_all => 'Gérer les auteurs',
            self::auteurs_create => 'Créer un auteur',
            self::auteurs_delete => 'Supprimer un auteur',
            self::auteurs_force_delete => 'Supprimer définitivement un auteur',
            self::auteurs_restore => 'Restaurer un auteur',
            self::auteurs_update_all => 'Modifier un auteur',
            self::auteurs_view => 'Voir un auteur',
            // Etiquettes
            self::etiquettes_all => 'Gérer les étiquettes',
            self::etiquettes_create => 'Créer une étiquette',
            self::etiquettes_delete => 'Supprimer une étiquette',
            self::etiquettes_force_delete => 'Supprimer définitivement une étiquette',
            self::etiquettes_restore => 'Restaurer une étiquette',
            self::etiquettes_update_all => 'Modifier une étiquette',
            self::etiquettes_view => 'Voir une étiquette',
            // OuvrageCategories
            self::ouvrage_categories_all => 'Gérer les catégories d\'ouvrages',
            self::ouvrage_categories_create => 'Créer une catégorie d\'ouvrage',
            self::ouvrage_categories_delete => 'Supprimer une catégorie d\'ouvrage',
            self::ouvrage_categories_force_delete => 'Supprimer définitivement une catégorie d\'ouvrage',
            self::ouvrage_categories_restore => 'Restaurer une catégorie d\'ouvrage',
            self::ouvrage_categories_update_all => 'Modifier une catégorie d\'ouvrage',
            self::ouvrage_categories_view => 'Voir une catégorie d\'ouvrage',
            // Ouvrages
            self::ouvrages_all => 'Gérer les ouvrages',
            self::ouvrages_create => 'Créer un ouvrage',
            self::ouvrages_delete => 'Supprimer un ouvrage',
            self::ouvrages_force_delete => 'Supprimer définitivement un ouvrage',
            self::ouvrages_restore => 'Restaurer un ouvrage',
            self::ouvrages_update_all => 'Modifier un ouvrage',
            self::ouvrages_view => 'Voir un ouvrage',
            // Units
            self::units_all => 'Gérer les unités',
            self::units_create => 'Créer une unité',
            self::units_delete => 'Supprimer une unité',
            self::units_force_delete => 'Supprimer définitivement une unité',
            self::units_restore => 'Restaurer une unité',
            self::units_update_all => 'Modifier une unité',
            self::units_view => 'Voir une unité',
            // Consommables
            self::consommables_all => 'Gérer les consommables',
            self::consommables_create => 'Créer un consommable',
            self::consommables_delete => 'Supprimer un consommable',
            self::consommables_force_delete => 'Supprimer définitivement un consommable',
            self::consommables_restore => 'Restaurer un consommable',
            self::consommables_update_all => 'Modifier un consommable',
            self::consommables_view => 'Voir un consommable',
        };
    }

}
