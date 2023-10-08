<?php

namespace App\Models;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlockedUser extends Model
{
    use HasFactory;



    protected $fillable = ['user_id','from_datetime','to_datetime','description','enable'];

    protected $casts = [
        'extra' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    protected static function boot()
    {
        parent::boot();
        if(!auth()->user()->tg_id){
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
}
