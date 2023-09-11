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

class InvoiceItem extends Model
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
        'order_id',
        'invoice_id',
        'description',
        'expires_at',
        'cycle',
        'price',
        'discount',
        'due_date',

    ];


    function order()
    {
        return $this->belongsTo(Order::class);
    }
    protected $appends = ['date', 'expire_date', 'create_date'];
   
    function invoice()
    {
        return $this->belongsTo(Invoice::class);
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

    
        static::forceDeleted(
            function ($item) {
                try{
                    $item->order()->delete();
                }catch(\Exception $e){

                }
            }
        );
      
    }


}
