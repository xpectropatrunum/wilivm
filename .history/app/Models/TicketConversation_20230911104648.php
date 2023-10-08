<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TicketConversation extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static function boot()
    {
      
        parent::boot();

        if (auth()->guard("web")->check()) {
            return 0;
        }
    
        static::deleted(
            function ($item) {
                   dd(23);
                Log::create([
                    "admin_id" => auth()->user()->id,
                    "type" => ELogType::Delete,
                    "model" => self::class,
                    "related_id" => $item,
                ]);
                Trash::create([
                    "model" => self::class,
                    "json" => json_encode($item)
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
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticket_id',
        'type',
        'message',
    ];


    function assets()
    {
        return $this->hasMany(TicketConversationAsset::class);
    }
}
