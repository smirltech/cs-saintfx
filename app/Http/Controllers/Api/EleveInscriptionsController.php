<?php

namespace App\Http\Controllers\Api;

use App\Models\Eleve;

class EleveInscriptionsController
{

    protected $model = Eleve::class;
    protected $relation = 'inscriptions';

}
