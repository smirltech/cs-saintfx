<?php

namespace App\Http\Controllers\Api;

use App\Models\Eleve;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class EleveInscriptionsController extends Controller
{
    use DisableAuthorization;

    protected $model = Eleve::class;
    protected $relation = 'inscriptions';

}
