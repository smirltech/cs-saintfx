<?php

namespace App\Enums;

enum UserRole: string
{

    case promoteur = 'promoteur';
    case admin = 'admin';
    case caissier = 'caissier';
    case eleve = 'eleve';
    case parent = 'parent';
    case enseignant = 'enseignant';

    public function permissions(): array
    {
        // return permissions based on user role
        return match ($this) {
            self::promoteur => [
                RolePermission::users_all->value,
                RolePermission::roles_all->value,
                RolePermission::permissions_all->value,
                RolePermission::annees_all->value,
            ],
            self::admin => [
                RolePermission::eleves_all->value,
                RolePermission::enseignants_all->value,
            ],
            self::enseignant => [
                RolePermission::devoirs_all->value,
            ],
            self::caissier => [
                RolePermission::factures_all->value,
            ],
            self::eleve => [

            ],
            self::parent => [
                RolePermission::eleves_view->value,
            ]

        };

    }


}
