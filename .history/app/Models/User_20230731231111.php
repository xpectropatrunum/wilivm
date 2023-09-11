<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        "google_id",
        'city',
        'company',
        'address',
        'parent_id',
        'country',
        'google2fa_secret'
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
                    try{
                        $item->blockedUser()->delete();
                        $item->services()->delete();
                        $item->wallet()->delete();
                        $item->orders()->each(function($query){
                            $query->transactions()->delete();
                            $query->delete();
                        });
                        $item->tickets()->delete();
                        $item->notifications()->delete();

                    }catch(\Exception $e){
                        Log::debug($e->getMessage());

                    }
                }
            );
            static::updating(
                function ($item) {
                    
                    try{
                        Log::create([
                            "admin_id" => auth()->user()->id,
                            "type" => ELogType::Update,
                            "model" => self::class,
                            "related_id" => $item,
                        ]);
                    }catch(\Exception $e){

                    }
                }
            );
            static::created(
                function ($item) {
                    try{
                        Log::create([
                            "admin_id" => auth()->user()->id,
                            "type" => ELogType::Create,
                            "model" => self::class,
                            "related_id" => $item,
                        ]);
                    }catch(\Exception $e){

                    }
                    
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
    function emails()
    {
        return $this->hasMany(SentEmail::class);
    }
    function invoices()
    {
        return $this->hasMany(Invoice::class);
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
