<?php

namespace App\Http\Controllers\Api;

use App\Models\Filiere;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class FiliereController extends Controller
{
    use DisableAuthorization;

    protected $model = Filiere::class;

    public function includes(): array
    {
        return ['classes'];
    }

    /*    public function alwaysIncludes(): array
        {
            return ['classes'];
        }*/

}
