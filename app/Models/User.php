<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        $this->hasOne(UserRole::class, 'user_id');
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        $role = $this->getUserRole();
        if (! is_null($role)) {
            return $role->name == 'admin';
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        $role = $this->getUserRole();
        if (! is_null($role)) {
            return $role->name == 'super_admin';
        }

        return false;
    }

    /**
     * @return object|null
     */
    public function getUserRole()
    {
        $userRole = Cache::remember('user_role_'.$this->id, 300 * 5, function () {
            return $this->newQuery()
                ->join('user_role', 'users.id', '=', 'user_role.user_id', 'left')
                ->where('users.id', $this->id)
                ->first();
        });

        if (! is_null($userRole)) {
            $role = Role::query()->find($userRole->role_id);

            return $role;
        }

        return null;
    }
}
