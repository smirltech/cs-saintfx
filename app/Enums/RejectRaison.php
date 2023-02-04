<?php

namespace App\Enums;

enum RejectRaison: string
{
    case bordereau_invalid = 'bordereau_invalid';
    case matricule_invalid = 'matricule_invalid';
    case bordereau_absent = 'bordereau_absent';


    /**
     * @return string
     */
    public function label(): string
    {
        // match the enum value with the label, using match expression
        return match ($this) {
            RejectRaison::bordereau_invalid => 'Borereau invalide',
            RejectRaison::matricule_invalid => 'Matricule invalide',
            RejectRaison::bordereau_absent => 'Pas de bordereau',
        };
    }

    /**
     * @return string
     */
    public function message(): string
    {
        // match the enum value with the label, using match expression
        return match ($this) {
            RejectRaison::bordereau_invalid => 'Veillez fournir un bordereau valide',
            RejectRaison::matricule_invalid => 'Veillez fournir un matricule valide',
            RejectRaison::bordereau_absent => 'Veillez fournir un bordereau',
        };
    }

    public function isBordereau(): bool
    {
        return $this->value === RejectRaison::bordereau_invalid->value || $this->value === RejectRaison::bordereau_absent->value;
    }


}
