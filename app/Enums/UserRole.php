<?php

namespace App\Enums;

enum UserRole: string
{

    case super_admin = 'super_admin';
    case admin = 'admin';
    case operateur = 'operateur';
    case caissier = 'caissier';
    case prefet = 'prefet';
    case promoteur = 'promoteur';

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
            self::prefet => [
                RolePermission::view_etudiant->name,


                RolePermission::create_faculte->name,
                RolePermission::create_promotion->name,
            ],
            self::promoteur => [
                RolePermission::view_etudiant->name,
                RolePermission::create_user->name,
            ],
            self::operateur => [
                RolePermission::view_etudiant->name,
            ],
            self::caissier => [
                RolePermission::view_etudiant->name,
            ],

        };

    }


}
