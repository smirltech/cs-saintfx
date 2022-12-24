<?php

namespace App\Models;

use App\Enums\FraisFrequence;
use App\Enums\FraisType;
use App\Http\Integrations\Scolarite\Requests\Classe\GetClasseRequest;
use App\Http\Integrations\Scolarite\Requests\Filiere\GetFiliereRequest;
use App\Http\Integrations\Scolarite\Requests\Option\GetOptionRequest;
use App\Http\Integrations\Scolarite\Requests\Section\GetSectionRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Frais extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'type' => FraisType::class,
        'frequence' => FraisFrequence::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public static function montantFraisType(int $annee_id, FraisType $type)
    {
        return Perception::whereHas("frais", function ($q) use ($type) {
            $q->where('type', $type->value);
        })->where('annee_id', $annee_id)->sum('montant');
    }

    public static function montantFraisTypeOf(int $annee_id, FraisType $type, int $days = 7)
    {
        $edate = Carbon::now();
        $sdate = Carbon::now()->subDays($days);

        return Perception::whereHas("frais", function ($q) use ($type) {
            $q->where('type', $type->value);
        })->where('annee_id', $annee_id)->whereDate('created_at', '>=', $sdate)->whereDate('created_at', '<=', $edate)->sum('montant');
    }

    public static function paidFraisType(int $annee_id, FraisType $type)
    {
        return Perception::whereHas("frais", function ($q) use ($type) {
            $q->where('type', $type->value);
        })->where('annee_id', $annee_id)->sum('paid');
    }

    public static function paidFraisTypeOf(int $annee_id, FraisType $type, int $days = 7)
    {
        $edate = Carbon::now();
        $sdate = Carbon::now()->subDays($days);

        return Perception::whereHas("frais", function ($q) use ($type) {
            $q->where('type', $type->value);
        })->where('annee_id', $annee_id)->whereDate('created_at', '>=', $sdate)->whereDate('created_at', '<=', $edate)->sum('paid');
    }

    public function montantPerceptions()
    {
        return $this->perceptions()->sum('montant');
    }

    public function perceptions()
    {
        return $this->hasMany(Perception::class);
    }

    public function montantPerceptionsOf($days = 7)
    {
        $edate = Carbon::now();
        $sdate = Carbon::now()->subDays($days);

        return $this->perceptions()->whereDate('created_at', '>=', $sdate)->whereDate('created_at', '<=', $edate)->sum('montant');
    }

    public function classable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getClassableAttribute(): mixed
    {
        if (str_ends_with($this->classable_type, 'Classe')) {
            return Classe::find($this->classable_id);
        } else if (str_ends_with($this->classable_type, 'Filiere')) {
            return Filiere::find($this->classable_id);
        } else if (str_ends_with($this->classable_type, 'Option')) {
            return Option::find($this->classable_id);
        } else if (str_ends_with($this->classable_type, 'Section')) {
            return Section::find($this->classable_id);
        } else {
            return null;
        }
    }

    public static function sommeFraisByTypeBetween(int $annee_id, $ddebut, $dfin)
    {
        $debut = Carbon::parse($ddebut)->startOfDay();
        $fin = Carbon::parse($dfin)->endOfDay();
        $data = [];
        foreach (FraisType::cases() as $type) {
            $data[$type->label()] = Perception::whereHas("frais", function ($q) use ($type) {
                $q->where('type', $type->value);
            })->where('annee_id', $annee_id)->whereBetween('created_at', [$debut, $fin])->sum('montant');
        }

        return $data;
    }
}
