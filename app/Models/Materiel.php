<?php

namespace App\Models;

use App\Enums\MaterialStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiel extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $casts = [
        'status' => MaterialStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getVieRestanteAttribute(): int|null
    {
        if ($this->date == null) return null;
        $n0 = Carbon::parse($this->date);
        $n = Carbon::now();
        $d = $n->diffInYears($n0, absolute: true);

        return $d > $this->vie ? $this->vie : $this->vie - $d;
    }
}
