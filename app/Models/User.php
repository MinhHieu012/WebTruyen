<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, Notifiable;

    const ROLE_ADMIN       = 'Admin';
    const ROLE_ADMIN_BRAND = 'Admin Brand';
    const ROLE_SEO         = 'SEO';
    const ROLE_CONTENT     = 'Content';

    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 2;

    const STATUS_TEXT = [
        self::STATUS_ACTIVE   => 'Hoạt động',
        self::STATUS_INACTIVE => 'Ngừng hoạt động',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'status',
        'last_login_ip',
        'last_login_time',
        'created_by',
        'avatar',
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
        'password'          => 'hashed',
        'last_login_time'   => 'datetime',
    ];

    // public function domains()
    // {
    //     return $this->belongsToMany(Domain::class, 'user_domain')->withPivot('user_id', 'domain_id');
    // }
}
