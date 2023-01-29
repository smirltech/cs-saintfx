<?php

namespace App\Models;


use App\Traits\HasAvatar;
use Closure;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{


    use HasFactory, Notifiable, HasRoles, HasAvatar, HasUlids;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    public function isAdmin(): bool
    {
        return true;
    }


    public function adminlte_image()
    {
        return $this->avatar;
    }

    public function image()
    {
        return $this->avatar;
    }


    public function adminlte_desc(): string
    {
        return $this->roles->first()->name ?? "N/A";
    }


    public function adminlte_profile_url(): string
    {
        return route('users.edit', $this);
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name ?? 'Non assigné';
    }

    public function getRoleAttribute(): Closure|Role|null
    {
        return $this->roles->first();
    }

    // set password attribute
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setRoleIdAttribute($role_id)
    {
        $this->syncRoles($role_id);
    }

    // all permission names attribute

    // display permissions attribute
    public function getDisplayPermissionsAttribute(): string
    {
        return $this->getAllPermissions()->pluck('name')->implode(', ');
    }

}
