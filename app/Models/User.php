<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';
    const ROLE_USER = 'user';

    const ROLES_LABEL = [
        self::ROLE_ADMIN => 'Administrator',
        self::ROLE_EDITOR => 'Editor',
        self::ROLE_USER => 'Public user',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            $model->syncRoles([self::ROLE_USER]);
        });
    }

    public function posts()
    {
        return $this->hasMany('App\Models\PostInstance')->where('actual', true);
    }

    public function getRoleNameAttribute()
    {
        $roles = $this->getRoleNames();

        if (count($roles)) {
            return self::ROLES_LABEL[$roles[0]];
        } else {
            return "user";
        }
    }

    public static function getRoles()
    {
        return self::ROLES_LABEL;
    }
}
