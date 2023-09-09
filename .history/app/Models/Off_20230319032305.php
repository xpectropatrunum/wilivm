<?php

namespace App\Models;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Off extends Model
{
    use HasFactory;


    public $table = "off_codes";

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'code',
        'limit',
        'enable',
        'current',
        'from_date',
        'to_date'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected static function boot()
    {
        parent::boot();
        if (auth()->guard("web")->check()) {
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
