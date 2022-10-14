<?php

namespace App\Enum;

enum ResponsableRelation: string
{
    case oncle = 'oncle';
    case tante = 'tante';
    case pere = 'pere';
    case mere = 'mere';
    case frere = 'frere';
    case soeur = 'soeur';
    case autre = 'autre';
}
