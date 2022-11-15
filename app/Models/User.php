<?php

namespace App\Models;


use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{


    use HasFactory, Notifiable, HasRoles;

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
        return "https://ui-avatars.com/api/?name=" . $this->name . "&background=random";
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

    public function delete_image()
    {
        if (!empty($this->image)) {
            //  $file = 'public/companies/' .$this->company_id . '/users/' . $this->image;
            $file = Helpers::profile_image($this->image);
            return Storage::delete($file);
        }
    }


}
