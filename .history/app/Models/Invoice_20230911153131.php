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

class Invoice extends Model
{
    use SoftDeletes;

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'order_id',
        'description',
        'expires_at',
        'cycle',
        'price',
        'discount',
        'due_date',

    ];
    function transactions()
    {
        return $this->hasMany(Transaction::class, "order_id", "id");
    }
    function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    function service()
    {
        return $this->hasOne(UserService::class, "id", "server_id");
    }
    function order()
    {
        return $this->belongsTo(Order::class);
    }
    protected $appends = ['status', 'date', 'expire_date', 'create_date'];
    function getStatusAttribute()
    {
        return $this->transactions()?->latest()?->first()?->status ?? 0;
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }

    function getExpireDateAttribute()
    {
        return date("Y-m-d", $this->attributes["expires_at"]);
    }
    function getCreateDateAttribute()
    {
        return date("Y-m-d", strtotime($this->attributes["created_at"]));
    }
    function getDateAttribute()
    {
        return date("d M Y", strtotime($this->attributes["created_at"]));
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

        static::softDeleted(
            function ($item) {
                try{
                    foreach($item->items as $item__){
                        if($item__->order){
                            $item__->order->service()->delete();
                        }
                        
                        $item__->order()->delete();
                        $item__->delete();
                    }
                    $item->transactions()->delete();
                }catch(\Exception $e){

                }
            }
        );
        static::restoring(
            function ($item) {
                try{
                    $item->items()->restore();
                    foreach($item->items as $item__){
                        $item__->restore();
                        $item__->order()->restore();
                        if($item__->order){
                            $item__->order->service()->restore();
                        }
                        
                       
                    }
                    $item->transactions()->restore();
                }catch(\Exception $e){

                }
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
