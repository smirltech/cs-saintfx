<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class OptionController extends Controller
{
    use DisableAuthorization;

    protected $model = Section::class;

    public function includes(): array
    {
        return ['options', 'classes'];
    }

    public function alwaysIncludes(): array
    {
        return ['options', 'classes'];
    }

}
