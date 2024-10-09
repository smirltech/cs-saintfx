<?php

namespace App\Traits;

use App\Models\Option;
use App\Models\Section;

trait ClasseCode
{
    // set code
    public function setCode()
    {
        if ($this->grade and $this->filiere_id) {
            $filiere = Option::find($this->filiere_id);
            $this->code = "{$this->grade} {$filiere->code}";
        }else if ($this->grade and $this->option_id) {
            $option = Option::find($this->option_id);
            $this->code = "{$this->grade} {$option->code}";
        }else if ($this->grade and $this->section_id) {
            $section = Section::find($this->section_id);
            $this->code = "{$this->grade} {$section->code}";
        }
    }

}
