<?php

namespace App\Traits;

use App\Models\Option;

trait PomotionCode
{
    // set code
    public function setCode()
    {
        if ($this->grade and $this->filiere_id) {
            $filiere = Option::find($this->filiere_id);
            $this->code = "{$this->grade} {$filiere->code}";
        }
    }

}
