<?php

namespace App\Enum;

enum RolePermission: string
{
    case create_etudiant = 'create_etudiant';
    case edit_etudiant = 'edit_etudiant';
    case view_etudiant = 'view_etudiant';
    case delete_etudiant = 'delete_etudiant';

    case create_promotion = 'create_promotion';
    case create_faculte = 'create_faculte';
    case create_user = 'create_user';


}
