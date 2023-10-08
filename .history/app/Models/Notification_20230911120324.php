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

class Notification extends Model
{
    use SoftDeletes;

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'message',
        'new',
    ];

    function user(){
        return $this->belongsTo(User::class);
    }
    function getNTimeAttribute(){
        $diff = time() - strtotime($this->created_at);
        $diff_hour = $diff / 3600;
        if($diff_hour >= 24){
            return round($diff_hour / 24) . " day(s) ago";
        }
        if($diff_hour < 1){
            $diff_min = round($diff / 60);
            if($diff_min == 0){
                return "now";
            }
            return $diff_min . " minutes ago";
        }
        return round($diff_hour) . " hours ago";
    }
    protected static function boot()
    {
        parent::boot();

        if(!auth()->user()->tg_id){
            return 0;
        }

        static::forceDeleted(
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
