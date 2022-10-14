<?php

namespace App\Enum;

enum UserRole: string
{

    case super_admin = 'super_admin';
    case admin = 'admin';
    case operateur = 'operateur';
    case appariteur = 'appariteur';
    case sga = 'secretaire_general';

    public function permissions(): array
    {
        // return permissions based on user role
        return match ($this) {
            self::super_admin => [
                RolePermission::create_user->name,
                RolePermission::create_etudiant->name,
                RolePermission::edit_etudiant->name,
                RolePermission::delete_etudiant->name,
                RolePermission::view_etudiant->name,
                RolePermission::create_faculte->name,
                RolePermission::create_promotion->name,
            ],
            self::admin => [
                RolePermission::create_user->name,
            ],
            self::appariteur => [
                RolePermission::create_etudiant->name,
                RolePermission::edit_etudiant->name,
                RolePermission::delete_etudiant->name,
                RolePermission::view_etudiant->name,


                RolePermission::create_faculte->name,
                RolePermission::create_promotion->name,
            ],
            self::sga => [
                RolePermission::view_etudiant->name,
                RolePermission::create_user->name,
            ],
            self::operateur => [
                RolePermission::create_etudiant->name,
                RolePermission::view_etudiant->name,
            ]

        };

    }


}
