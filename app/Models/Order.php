<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\ELogType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Order extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'server_id',
        'user_id',
        'cycle',
        'expires_at',
        'price',
        'label_ids',
        'discount',
    ];
    function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    function service()
    {
        return $this->hasOne(UserService::class, "id", "server_id");
    }
    protected $appends = ['status'];
    function getStatusAttribute()
    {
        return $this->transaction?->status ?? 0;
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function getLabelsAttribute()
    {
        $labels = [];
        foreach (json_decode($this->attributes["label_ids"]) as $id) {
            if ($label = OrderLabel::find($id)) {
                $labels[] = (object)["id" => $id, "label" => $label];
            }
        }
        return collect($labels);
    }
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
