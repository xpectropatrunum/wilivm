<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\HasApiTokens;

class Bulletin extends Model
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'message',
        'id',
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
}
