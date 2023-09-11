<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Email extends Model
{
    use SoftDeletes;

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'name',
        'head',
        'template',
        'type',
        'enabled',
    ];
   
  
    protected static function boot()
    {
        parent::boot();
        if(!auth()->user()->tg_id){
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
