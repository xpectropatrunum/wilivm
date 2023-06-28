<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserService extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'plan',
        'ram',
        'storage',
        'cpu',
        'bandwith',
        'ip',
        'ipv4',
        'ipv6',
        'os',
        'location',
        'username',
        'password',
        'status',
    ];
    protected static function boot()
    {
        parent::boot();

          if(auth()->guard("web")->check()){
            return 0;
        }
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
                Log::create([
                    "admin_id" => auth()->user()->id,
                    "type" => ELogType::Create,
                    "model" => self::class,
                    "related_id" => $item,
                ]);
            }
        );
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function order()
    {
        
            return $this->hasOne(Order::class, "server_id", "id");
      
    }
    function requests()
    {
        return $this->hasMany(UserServiceRequest::class);
    }
    function location_()
    {
        return $this->hasOne(Location::class, "id", "location");
    }
    function os_()
    {
        return $this->hasOne(Os::class,  "id", "os");
    }
    function os_parent()
    {
        $type = ServerType::where("name", $this->attributes["type"])->first();
    
        $server = Server::where("server_type_id", $type->id)->first();
        return $server->os();
    }
  
}
