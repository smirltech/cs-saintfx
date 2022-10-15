<?php

namespace App\Traits;

trait SectionCode
{
    // set code
    public function genCode()
    {
        if(isset($this->nom)) {
            $this->code = strtoupper(substr($this->nom, 0, 3));
        }else{
            $this->section->code = strtoupper(substr($this->section->nom, 0, 3));
        }
    }

}
