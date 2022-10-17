<?php

namespace App\Traits;

use App\Helpers\Helpers;
use App\Models\Filiere;
use App\Models\Option;
use App\Models\Section;

trait FakeProfileImage
{
    // set code
    public function setFakeProfileImageUrl()
    {
        if (isset($this->eleves)) {
         foreach ($this->eleves as $eleve){
           if( $eleve->profile_url == null) {
               $eleve->profile_url = Helpers::fakePicsum($eleve->id, 120, 120);
               $eleve->update();
           }
         }
        }
        if (isset($this->eleve)) {
            if( $this->eleve->profile_url == null) {
                $this->eleve->profile_url = Helpers::fakePicsum($this->eleve->id, 120, 120);
                $this->eleve->update();
            }
        }
    }

}
