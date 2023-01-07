<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OuvrageCategory extends Model
{
    use HasFactory;

    public $guarded = [];

    public function ouvrages(): HasMany|null
    {
        return null;//$this->hasMany(self::class);
    }

    public function groupe():BelongsTo
    {
        return $this->belongsTo(self::class, 'ouvrage_category_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(self::class);
    }

    public function getGroupeNomAttribute(){
        return $this->groupe?->nom;
    }

    public function getOuvragesCountAttribute():int{
        return 0;//$this->ouvrages?->count();
    }

    public function getOuvragesCountAggregateAttribute():int{
        return $this->ouvragesCount + $this->categories->sum('ouvragesCountAggregate');
    }
}
