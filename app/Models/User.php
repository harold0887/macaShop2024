<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Mchev\Banhammer\Traits\Bannable;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use Bannable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'picture', 'role_id', 'status', 'whatsapp', 'facebook','email_verified_at','comment'
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
    public function profilePicture()
    {
        if ($this->picture) {
            return "/storage/{$this->picture}";
        }

        return 'http://i.pravatar.cc/200';
    }

    //relacion con comentarios, retorna los comentarios de un usuario
    public function comentarios()
    {
        return $this->hasMany('App\Models\Comment');
    }


    //relacion con ordenes, retorna las ordenes de un usuario
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'customer_id');
    }


    //relacion con ips, retorna las ips de un usuario
    public function ips()
    {
        return $this->hasMany('App\Models\Ips', 'user_id')
        ->orderBy('created_at', 'desc');
    }


    //Relacion con ventas, retorna las ventas del producto
    public function sales(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
