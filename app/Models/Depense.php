<?php

namespace App\Models;

use App\Enums\DepenseCategorie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $with = ['user'];

    public static function dataOfLast($days = 7)
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $lDate = Carbon::now()->subDays($i);
            $data[] = self::whereDate('created_at', '=', $lDate)->sum('montant');
        }
        return $data;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function sommeBetween($annee_id, $ddebut, $dfin)
    {
        $debut = Carbon::parse($ddebut)->startOfDay();
        $fin = Carbon::parse($dfin)->endOfDay();
        return self::where('annee_id', $annee_id)->whereBetween('created_at', [$debut, $fin])->sum('montant');
    }

    public static function sommeDepensesByCategoryBetween(int $annee_id, $ddebut, $dfin)
    {
        $debut = Carbon::parse($ddebut)->startOfDay();
        $fin = Carbon::parse($dfin)->endOfDay();
        $data = [];
        foreach (DepenseCategorie::cases() as $category) {
            $data[$category->label()] = self::where('annee_id', $annee_id)->where('categorie', $category)->whereBetween('created_at', [$debut, $fin])->sum('montant');
        }

        return $data;
    }
}
