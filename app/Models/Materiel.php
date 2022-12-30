<?php

namespace App\Models;

use App\Enums\MaterialStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materiel extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $casts = [
        'status' => MaterialStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterielCategory::class, 'materiel_category_id', 'id');
    }

    public function getCategoryIdAttribute(): int|null
    {
        return $this->category->id;
    }

    public function getCategoryNomAttribute(): string|null
    {
        return $this->category->nom;
    }

    public function getVieRestanteAttribute(): int|null
    {
        if ($this->date == null) return null;
        $n0 = Carbon::parse($this->date);
        $n = Carbon::now();
        $d = $n->diffInYears($n0, absolute: true);

        return $d > $this->vie ? $this->vie : $this->vie - $d;
    }

    public function getDateFormattedAttribute(): string|null
    {
        return $this->date == null ? null : Carbon::parse($this->date)->format('d-m-Y');
    }

    public function getAmortissementAttribute(): string|null
    {
        return $this->amortissementTaux == null ? null : ($this->montant * $this->amortissementTaux/100);
    }

    public function getAmortissementTauxAttribute(): float|null
    {
        return $this->vie == null ? null : number_format((100 / $this->vie), 2);
    }
}
