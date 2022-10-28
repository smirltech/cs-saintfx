<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class SectionController extends Controller
{
    use DisableAuthorization;

    protected $model = Section::class;

    public function includes(): array
    {
        return ['options',  'classes', 'options.filieres.classes', 'options.classes', 'options.filieres'];
    }

    public function alwaysIncludes(): array
    {
        return ['options',  'classes', 'options.filieres.classes', 'options.classes', 'options.filieres'];
    }

    public function exposedScopes(): array
    {
        return ['options', 'classes', 'options.filieres.classes', 'options.classes', 'options.filieres'];
    }

}
