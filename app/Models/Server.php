<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Server extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'server_type_id',
        'server_plan_id',
        'cpu',
        'ram',
        'price',
        'bandwith',
        'storage',
        'enabled',
    ];

    function type()
    {
        return $this->belongsTo(ServerType::class,  "server_type_id", "id");
    }
    function plan()
    {
        return $this->belongsTo(ServerPlan::class,  "server_plan_id", "id");
    }
    function os()
    {
        return $this->belongsToMany(Os::class, ServerOs::class);
    }
    function locations()
    {
        return $this->belongsToMany(Location::class, ServerLocation::class);
    }
    function os_rel()
    {
        return $this->hasOne(ServerOs::class);
    }
    function locations_rel()
    {
        return $this->hasOne(ServerLocation::class);
    }
}
