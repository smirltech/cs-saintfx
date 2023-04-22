<?php

namespace App\Traits;

use App\Models\Annee;

trait HasScopeAnnee
{
    public function scopeAnnee($query, $annee_id = null)
    {
        return $this->scopeAnneeScolaire($query, $annee_id);
    }

    public function scopeAnneeScolaire($query, $annee_id = null)
    {
        if ($annee_id) {
            return $query->where('annee_id', $annee_id);
        }
        return $query->where('annee_id', Annee::id());
    }
}
