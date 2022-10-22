<?php

namespace App\Http\Controllers\Api;

use App\Models\Eleve;

class EleveResponsablesController
{

    protected $model = Eleve::class;
    protected $relation = 'responsables';
}
