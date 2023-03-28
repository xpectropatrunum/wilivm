<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'username',
        'first_name',
        'last_name',
        'email',
        "affiliate_code",
        'verification_code',
        'verified',
        'status',
        'password',
        'phone',
        'state',
        'city',
        'company',
        'address',
        'parent_id',
        'country',
    ];
    protected static function boot()
    {
        parent::boot();

        if (auth()->guard("web")->check()) {
            return 0;
        }
        try {


            static::deleting(
                function ($item) {
                    Log::create([
                        "admin_id" => auth()->user()->id,
                        "type" => ELogType::Delete,
                        "model" => self::class,
                        "related_id" => $item,
                    ]);
                }
            );
            static::updating(
                function ($item) {
                    Log::create([
                        "admin_id" => auth()->user()->id,
                        "type" => ELogType::Update,
                        "model" => self::class,
                        "related_id" => $item,
                    ]);
                }
            );
            static::created(
                function ($item) {
                    Log::create([
                        "admin_id" => auth()->user()->id,
                        "type" => ELogType::Create,
                        "model" => self::class,
                        "related_id" => $item,
                    ]);
                }
            );
        } catch (\Exception $e) {
           
        }
    }
    function services()
    {
        return $this->hasMany(UserService::class, "user_id", "id");
    }
    function childrens()
    {
        return $this->hasMany(User::class, "parent_id", "id");
    }
    function orders()
    {
        return $this->hasMany(Order::class);
    }
    function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    function blockedUser()
    {
        return $this->hasOne(BlockedUser::class);
    }
}
