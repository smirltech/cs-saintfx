<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'filiere_codes' => 'json'
    ];

    // display name attribute
    public function getDisplayNameAttribute()
    {
        if ($this->filieres->count() > 0)
            return "{$this->nom} | {$this->display_filieres}";
        else
            return $this->nom;

    }

    // display filieres attribute
    public function getDisplayFilieresAttribute()
    {
        $filieres = [];

        foreach ($this->filieres as $filiere) {
            $filieres[] = $filiere->code;
        }

        return implode(', ', $filieres);
    }



    // admins relationship where roles is admin or decanat and email verified
    // use hasMany
    public function admins()
    {
        return $this->hasMany(User::class, 'faculte_id', 'id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'admin')
                    ->orWhere('name', 'decanat');
            })
            ->where('email_verified_at', '!=', null);
    }


    // admins who will receive notifications about new demandes
    public function getAdminEmailsAttribute()
    {
        return $this->admins->pluck('email')->toArray();
    }

    public function filieres()
    {
        return $this->hasMany(Filiere::class);
    }
}
