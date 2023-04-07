<?php

namespace App\Models;

use App\Enums\DepenseCategorie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depense extends Model
{
    use HasFactory, HasUlids;

    public $guarded = [];
    protected $casts = [
        'categorie' => DepenseCategorie::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = ['user'];

    public static function dataOfLast($days = 7): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $lDate = Carbon::now()->subDays($i);
            $data[] = self::whereDate('created_at', '=', $lDate)->sum('montant');
        }
        return $data;
    }

    public static function sommeBetween($annee_id, $ddebut, $dfin)
    {
        $debut = Carbon::parse($ddebut)->startOfDay();
        $fin = Carbon::parse($dfin)->endOfDay();
        return self::where('annee_id', $annee_id)->whereBetween('created_at', [$debut, $fin])->sum('montant');
    }

    public static function sommeDepensesByTypeBetween(int $annee_id, $ddebut, $dfin): array
    {
        $debut = Carbon::parse($ddebut)->startOfDay();
        $fin = Carbon::parse($dfin)->endOfDay();
        $data = [];
        $depTypes = DepenseType::all();
        foreach ($depTypes as $ty) {
            $data[$ty->nom] = self::where('annee_id', $annee_id)->where('depense_type_id', $ty->id)->whereDate('created_at', '>=', $debut)->whereDate('created_at', '<=', $fin)->sum('montant');
        }

        return $data;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(DepenseType::class, 'depense_type_id');
    }
}
