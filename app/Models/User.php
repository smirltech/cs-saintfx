<?php

namespace App\Models;


use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{


    use HasFactory, Notifiable, HasRoles, HasUlids;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isAdmin()
    {
        return true;
    }


    public function adminlte_image()
    {
        return $this->avatar;
    }

    public function getAvatarAttribute()
    {
        return Helpers::fetchAvatar($this->name);
    }

    public function image()
    {
        return $this->avatar;
    }


    public function adminlte_desc()
    {
        return $this->roles->first()->name ?? "N/A";
    }


    public function adminlte_profile_url()
    {
        return route('admin.users.edit', $this);
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name ?? 'Non assigné';
    }

    public function getRoleAttribute()
    {
        return $this->roles->first();
    }


}
