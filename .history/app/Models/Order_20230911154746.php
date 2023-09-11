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

class Order extends Model
{

    use SoftDeletes;

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
        'due_date',
        
    ];
    function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    function service()
    {
        return $this->hasOne(UserService::class, "id", "server_id");
    }
  
    function invoiceItem()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    function invoices()
    {

        return $this->hasManyThrough(Invoice::class, InvoiceItem::class);
    }
    protected $appends = ['status', 'date','expire_date','create_date'];
    function getStatusAttribute()
    {
        return $this->transactions()?->latest()?->first()?->status ?? 0;
    }
    function getExpireDateAttribute()
    {
        return date("Y-m-d", $this->attributes["expires_at"]);
    }
    function getCreateDateAttribute()
    {
        return date("Y-m-d", strtotime($this->attributes["created_at"]));
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }

    function getDateAttribute()
    {
        return date("d M Y", strtotime($this->attributes["created_at"]));
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

             if(!auth()->user()->tg_id){
            return 0;
        }
        static::forceDeleted(
            function ($item) {
                Log::create([
                    "admin_id" => auth()->user()?->id ?? 0,
                    "type" => ELogType::Delete,
                    "model" => self::class,
                    "related_id" => $item,
                ]);
                try{
                    $item->transactions()->delete();
                    $item->service()->delete();
                }catch(\Exception $e){

                }
            }
        );
        static::softDeleted(
            function ($item) {
                try{
                    $item->transactions()->delete();
                    $item->service()->delete();
                }catch(\Exception $e){

                }
            }
        );
        static::restoring(
            function ($item) {
                try{
                    $item->transactions()->restore();
                    $item->service()->restore();
                }catch(\Exception $e){

                }
            }
        );
        static::updating(
            function ($item) {
                Log::create([
                    "admin_id" => auth()->user()?->id ?? 0,
                    "type" => ELogType::Update,
                    "model" => self::class,
                    "related_id" => $item,
                ]);
            }
        );
        static::created(
            function ($item) {
                Log::create([
                    "admin_id" => auth()->user()?->id ?? 0,
                    "type" => ELogType::Create,
                    "model" => self::class,
                    "related_id" => $item,
                ]);
            }
        );
    }


}
